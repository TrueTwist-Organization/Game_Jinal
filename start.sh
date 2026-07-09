#!/bin/bash
set -e
cd "$(dirname "$0")"

PORT="${1:-8888}"
PHP_BIN="$(dirname "$0")/bin/php"

if [ -x "$PHP_BIN" ]; then
  PHP="$PHP_BIN"
elif command -v php >/dev/null 2>&1; then
  PHP="php"
else
  echo "PHP is not installed."
  exit 1
fi

if lsof -ti :"$PORT" >/dev/null 2>&1; then
  kill "$(lsof -ti :"$PORT")" 2>/dev/null || true
  sleep 1
fi

echo "Starting GameNest at http://localhost:$PORT"
exec "$PHP" -S "localhost:$PORT" router.php
