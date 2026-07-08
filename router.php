<?php

declare(strict_types=1);

function send_html_headers(): void
{
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');
}

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$file = __DIR__ . $uri;

if ($uri !== '/' && is_file($file)) {
    return false;
}

send_html_headers();

if (preg_match('#^/explore/game/([^/.]+)\.html?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/explore/game.php';
    return true;
}

if ($uri === '/explore/contact' || $uri === '/explore/contact.html') {
    require __DIR__ . '/explore/contact.php';
    return true;
}

if ($uri === '/explore/privacy' || $uri === '/explore/privacy.html') {
    require __DIR__ . '/explore/privacy.php';
    return true;
}

if ($uri === '/explore/terms' || $uri === '/explore/terms.html') {
    require __DIR__ . '/explore/terms.php';
    return true;
}

if ($uri === '/' || $uri === '/index.php' || $uri === '/index.html') {
    require __DIR__ . '/index.php';
    return true;
}

http_response_code(404);
echo '404 Not Found';
return true;
