<?php

declare(strict_types=1);

$pageTitle = $pageTitle ?? SITE_TAGLINE . ' | ' . SITE_NAME;
$pageDescription = $pageDescription ?? SITE_DESCRIPTION;
$extraCss = $extraCss ?? [];
$extraJs = $extraJs ?? [];
$themeColor = $themeColor ?? '#0BCBFF';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="yes" name="apple-touch-fullscreen" />
    <meta content="telephone=no,email=no" name="format-detection" />
    <title><?= esc($pageTitle) ?></title>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= esc($pageTitle) ?>" />
    <meta property="og:site_name" content="<?= esc(SITE_NAME) ?>" />
    <meta property="og:description" content="<?= esc($pageDescription) ?>" />
    <meta name="description" content="<?= esc($pageDescription) ?>" />
    <meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="theme-color" content="<?= esc($themeColor) ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <?php foreach ($extraCss as $css): ?>
    <link rel="stylesheet" href="<?= esc(site_url($css)) ?>" />
    <?php endforeach; ?>
    <?php ads_head_game(); ?>
</head>
<body>
