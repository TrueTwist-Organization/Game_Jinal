#!/usr/bin/env python3
"""Update you_may_like sidebar data for all scraped games."""

import json
import re
import time
import urllib.request
from html import unescape
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
GAMES_DIR = ROOT / "data" / "games"
BASE = "https://game.gameportals.online/explore/game/"


def extract_between(html: str, start: str, end: str) -> str:
    s = html.find(start)
    if s == -1:
        return ""
    s += len(start)
    e = html.find(end, s)
    return html[s:e] if e != -1 else html[s:]


def parse_you_may_like(html: str) -> list:
    section = extract_between(html, '<div class="you-may-like-title">', "</footer>")
    items = []

    for href, block in re.findall(
        r'<a class="game-item t-image" href="([^"]+\.html)">(.*?)</a>',
        section,
        re.DOTALL,
    ):
        img_match = re.search(r'data-load="([^"]+)"', block)
        title_match = re.search(r"<h2>([^<]+)</h2>", block)
        developer_match = re.search(r"<h2>[^<]+</h2>\s*<span>([^<]+)</span>", block)
        rating_match = re.search(r'class="rating-score"[^>]*>([^<]+)', block)
        if not img_match or not title_match:
            continue

        items.append({
            "slug": href.replace(".html", ""),
            "title": unescape(title_match.group(1).strip()),
            "image": img_match.group(1).replace("https://warap.net/images/", ""),
            "developer": unescape(developer_match.group(1).strip()) if developer_match else "",
            "rating": rating_match.group(1).strip() if rating_match else "4.5",
        })

    return items


def main() -> None:
    files = sorted(GAMES_DIR.glob("*.json"))
    for i, path in enumerate(files, 1):
        slug = path.stem
        url = BASE + slug + ".html"
        try:
            req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
            html = urllib.request.urlopen(req, timeout=30).read().decode("utf-8", errors="replace")
            data = json.loads(path.read_text())
            data["you_may_like"] = parse_you_may_like(html)
            path.write_text(json.dumps(data, indent=2, ensure_ascii=False))
            print(f"[{i}/{len(files)}] {slug}: {len(data['you_may_like'])} suggestions")
        except Exception as exc:
            print(f"[{i}/{len(files)}] {slug}: FAIL {exc}")

        time.sleep(0.12)


if __name__ == "__main__":
    main()
