<?php

declare(strict_types=1);

define('SITE_NAME', 'GameNest');
define('SITE_BRAND', 'GameNest');
define('SITE_WEBSITE', 'hyygames.in');
define('SITE_TAGLINE', 'Play & Download Top Free Mobile Games');
define('SITE_DESCRIPTION', 'Play and download the best free mobile games! Enjoy action, racing, puzzle, cooking games, and more—fun for all ages and interests.');
define('SITE_EMAIL', 'contact@' . SITE_WEBSITE);
define('CONTACT_EMAIL', SITE_EMAIL);
define('TERMS_EMAIL', SITE_EMAIL);
define('SITE_LAST_UPDATED', 'July 9, 2026');
define('ADS_ENABLED', true);

require_once __DIR__ . '/includes/ads.php';
define('ROOT_DIR', __DIR__);
define('DATA_DIR', ROOT_DIR . '/data');
define('GAMES_DIR', DATA_DIR . '/games');

function site_url(string $path = ''): string
{
    if ($path === '') {
        return '/';
    }

    return '/' . ltrim($path, '/');
}

function img_url(string $file): string
{
    return site_url('assets/img.php?f=' . rawurlencode($file));
}

function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function load_games_list(): array
{
    static $games = null;
    if ($games !== null) {
        return $games;
    }

    $file = DATA_DIR . '/games-list.json';
    if (!is_file($file)) {
        return [];
    }

    $games = json_decode((string) file_get_contents($file), true) ?: [];
    return $games;
}

function load_game(string $slug): ?array
{
    $file = GAMES_DIR . '/' . $slug . '.json';
    if (!is_file($file)) {
        return null;
    }

    $game = json_decode((string) file_get_contents($file), true);
    return is_array($game) ? $game : null;
}

function render_stars(float $rating): string
{
    $full = (int) round($rating);
    $full = max(0, min(5, $full));
    $html = '';
    for ($i = 0; $i < 5; $i++) {
        $icon = $i < $full ? 'rate-yes.svg' : 'rate-no.svg';
        $html .= '<img class="start" src="' . esc(img_url($icon)) . '" alt="Rating" />';
    }

    return $html;
}
