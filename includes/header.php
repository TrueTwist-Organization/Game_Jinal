<?php

declare(strict_types=1);

$pageTitle = $pageTitle ?? SITE_TAGLINE . ' | ' . SITE_NAME;
$pageDescription = $pageDescription ?? SITE_DESCRIPTION;
$pageKeywords = $pageKeywords ?? '';
$bodyClass = $bodyClass ?? '';
$extraCss = $extraCss ?? [];
$extraJs = $extraJs ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="yes" name="apple-touch-fullscreen" />
    <meta content="telephone=no,email=no" name="format-detection" />
    <meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title><?= esc($pageTitle) ?></title>
    <?php if (!empty($pageKeywords)): ?>
    <meta name="keywords" content="<?= esc($pageKeywords) ?>" />
    <?php endif; ?>
    <meta name="description" content="<?= esc($pageDescription) ?>" />
    <?php foreach ($extraCss as $css): ?>
    <link rel="stylesheet" href="<?= esc(site_url($css)) ?>" />
    <?php endforeach; ?>
    <?php ads_head_home(); ?>
</head>
<body<?= $bodyClass !== '' ? ' class="' . esc($bodyClass) . '"' : '' ?>>
