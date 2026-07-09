<?php

declare(strict_types=1);

$file = $_GET['f'] ?? '';
$file = str_replace(['..', '\\'], '', $file);
$file = ltrim($file, '/');

if ($file === '' || !preg_match('/^[a-zA-Z0-9._\-\/]+$/', $file)) {
    http_response_code(400);
    exit('Invalid image path');
}

$cacheDir = __DIR__ . '/cache';
$localDir = __DIR__ . '/images';
$cacheFile = $cacheDir . '/' . str_replace('/', '__', $file);
$localFile = $localDir . '/' . $file;
$remoteUrl = 'https://warap.net/images/' . $file;

if (is_file($localFile) && filesize($localFile) > 0) {
    serve_cached_image($localFile);
}

if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

if (is_file($cacheFile) && filesize($cacheFile) > 0) {
    serve_cached_image($cacheFile);
}

$data = fetch_remote($remoteUrl);

if ($data === null || $data === '') {
    redirect_to_remote_image($remoteUrl);
}

file_put_contents($cacheFile, $data);
serve_cached_image($cacheFile);

function fetch_remote(string $url): ?string
{
    if (function_exists('shell_exec')) {
        $cmd = 'curl -fsSL --max-time 20 -A ' . escapeshellarg('GameNest/1.0') . ' ' . escapeshellarg($url);
        $data = shell_exec($cmd);
        if (is_string($data) && $data !== '') {
            return $data;
        }
    }

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        if ($ch !== false) {
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_USERAGENT => 'GameNest/1.0',
            ]);

            $data = curl_exec($ch);
            $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($data !== false && $code >= 200 && $code < 300) {
                return $data;
            }
        }
    }

    $context = stream_context_create([
        'http' => [
            'timeout' => 20,
            'header' => "User-Agent: GameNest/1.0\r\n",
            'ignore_errors' => true,
        ],
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
        ],
    ]);

    $data = @file_get_contents($url, false, $context);
    return is_string($data) && $data !== '' ? $data : null;
}

function redirect_to_remote_image(string $remoteUrl): void
{
    header('Location: ' . $remoteUrl, true, 302);
    exit;
}

function serve_cached_image(string $path): void
{
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $types = [
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
    ];

    header('Content-Type: ' . ($types[$ext] ?? 'application/octet-stream'));
    header('Cache-Control: public, max-age=86400');
    readfile($path);
    exit;
}
