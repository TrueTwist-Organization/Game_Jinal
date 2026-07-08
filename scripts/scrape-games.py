#!/usr/bin/env python3
"""Scrape game detail pages and extract structured JSON data."""

import json
import re
import sys
import time
import urllib.request
from html import unescape
from pathlib import Path

BASE_URL = "https://game.gameportals.online/explore/game/"
ROOT = Path(__file__).resolve().parent.parent
GAMES_LIST = ROOT / "data" / "games-list.json"
OUTPUT_DIR = ROOT / "data" / "games"


def fetch(url: str) -> str:
    req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
    with urllib.request.urlopen(req, timeout=30) as resp:
        return resp.read().decode("utf-8", errors="replace")


def extract_between(html: str, start: str, end: str) -> str:
    s = html.find(start)
    if s == -1:
        return ""
    s += len(start)
    e = html.find(end, s)
    return html[s:e] if e != -1 else html[s:]


def parse_game(html: str, slug: str) -> dict:
    title_match = re.search(r'<h1>([^<]+)</h1>', html)
    title = unescape(title_match.group(1).strip()) if title_match else slug

    cover_match = re.search(r'class="lazy-load cover-img" data-load="([^"]+)"', html)
    cover = cover_match.group(1).replace("https://warap.net/images/", "") if cover_match else f"{slug}.png"

    category_match = re.search(
        r'<div class="info-downloads info-developer-item">.*?<div class="number">([^<]+)</div>',
        html,
        re.DOTALL,
    )
    category = category_match.group(1).strip() if category_match else "Game"

    age_match = re.search(
        r'<div class="info-size info-developer-item">.*?<div class="number">([^<]+)</div>',
        html,
        re.DOTALL,
    )
    age = age_match.group(1).strip() if age_match else "3+"

    rating_match = re.search(r'<span class="rating-score">([^<]+)', html)
    rating = rating_match.group(1).strip() if rating_match else "4.5"

    info_table = {}
    for key, val in re.findall(
        r'<span class="info-key">([^<]+)</span><span class="info-value">([^<]+)</span>',
        html,
    ):
        info_table[key.strip()] = val.strip()

    editor_review = ""
    review_match = re.search(r'<div class="editor-review">.*?<div class="desc">\s*<span>(.*?)</span>', html, re.DOTALL)
    if review_match:
        editor_review = unescape(re.sub(r"\s+", " ", review_match.group(1).strip()))

    how_to_play = []
    how_match = re.search(r'<div class="how-to-play-info">(.*?)</div>\s*</div>\s*<div class="ads">', html, re.DOTALL)
    if how_match:
        how_to_play = [unescape(p.strip()) for p in re.findall(r"<p>([^<]+)</p>", how_match.group(1))]

    apple_url = ""
    google_url = ""
    apple_match = re.search(r"reward\(event,'([^']+)','apple'\)", html)
    google_match = re.search(r"reward\(event,'([^']+)','google'\)", html)
    if apple_match:
        apple_url = apple_match.group(1)
    if google_match:
        google_url = google_match.group(1)

    screenshots = [
        u.replace("https://warap.net/images/", "")
        for u in re.findall(r'data-load="(https://warap\.net/images/screenshots/[^"]+)"', html)
    ]

    histogram = []
    for star, width in re.findall(r'<span>(\d)</span>\s*<p class="score-progress"><b style="--width: (\d+%)"></b>', html):
        histogram.append({"stars": int(star), "width": width})

    featured = []
    for href, img, title in re.findall(
        r'href="([^"]+\.html)"[^>]*>.*?data-load="([^"]+)"\s*alt="([^"]+)"',
        extract_between(html, '<div class="rec-game-title">Featured App</div>', '<div class="you-may-like">'),
        re.DOTALL,
    ):
        featured.append({
            "slug": href.replace(".html", ""),
            "title": unescape(title),
            "image": img.replace("https://warap.net/images/", ""),
        })

    you_may_like = []
    yml_section = extract_between(html, '<div class="you-may-like-title">', "</footer>")
    for href, block in re.findall(
        r'<a class="game-item t-image" href="([^"]+\.html)">(.*?)</a>',
        yml_section,
        re.DOTALL,
    ):
        img_match = re.search(r'data-load="([^"]+)"', block)
        title_match = re.search(r"<h2>([^<]+)</h2>", block)
        developer_match = re.search(r"<h2>[^<]+</h2>\s*<span>([^<]+)</span>", block)
        rating_match = re.search(r'class="rating-score"[^>]*>([^<]+)', block)
        if not img_match or not title_match:
            continue

        you_may_like.append({
            "slug": href.replace(".html", ""),
            "title": unescape(title_match.group(1).strip()),
            "image": img_match.group(1).replace("https://warap.net/images/", ""),
            "developer": unescape(developer_match.group(1).strip()) if developer_match else "",
            "rating": rating_match.group(1).strip() if rating_match else "4.5",
        })

    meta_desc_match = re.search(r'<meta name="description"\s+content="([^"]+)"', html)
    description = unescape(meta_desc_match.group(1)) if meta_desc_match else editor_review[:200]

    return {
        "slug": slug,
        "title": title,
        "cover": cover,
        "category": category,
        "age": age,
        "rating": rating,
        "platform": info_table.get("Platform", "Android"),
        "price": info_table.get("Price", "Free"),
        "installs": info_table.get("Installs", ""),
        "updated": info_table.get("Updated", ""),
        "size": info_table.get("Size", ""),
        "description": description,
        "editor_review": editor_review,
        "how_to_play": how_to_play,
        "apple_url": apple_url,
        "google_url": google_url,
        "screenshots": screenshots,
        "histogram": histogram,
        "featured": featured[:15],
        "you_may_like": you_may_like,
    }


def main() -> None:
    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)
    games = json.loads(GAMES_LIST.read_text())
    total = len(games)
    start = int(sys.argv[1]) if len(sys.argv) > 1 else 0
    limit = int(sys.argv[2]) if len(sys.argv) > 2 else total

    for i, game in enumerate(games[start : start + limit]):
        slug = game["slug"]
        out_file = OUTPUT_DIR / f"{slug}.json"
        if out_file.exists():
            print(f"[{start + i + 1}/{total}] skip {slug}")
            continue

        url = f"{BASE_URL}{slug}.html"
        try:
            html = fetch(url)
            data = parse_game(html, slug)
            out_file.write_text(json.dumps(data, indent=2, ensure_ascii=False))
            print(f"[{start + i + 1}/{total}] ok {slug}")
        except Exception as exc:
            print(f"[{start + i + 1}/{total}] fail {slug}: {exc}")

        time.sleep(0.15)


if __name__ == "__main__":
    main()
