#!/usr/bin/env python3
"""Fix swapped title/image fields in scraped game JSON files."""

import json
from pathlib import Path

GAMES_DIR = Path(__file__).resolve().parent.parent / "data" / "games"


def fix_item(item: dict) -> dict:
    title = item.get("title", "")
    image = item.get("image", "")
    if title.startswith("http") or title.endswith(".png") or title.endswith(".jpg"):
        item["title"], item["image"] = image, title.replace("https://warap.net/images/", "")
    return item


def main() -> None:
    for path in GAMES_DIR.glob("*.json"):
        data = json.loads(path.read_text())
        data["featured"] = [fix_item(x) for x in data.get("featured", [])]
        data["you_may_like"] = [fix_item(x) for x in data.get("you_may_like", [])]
        path.write_text(json.dumps(data, indent=2, ensure_ascii=False))
        print(f"fixed {path.name}")


if __name__ == "__main__":
    main()
