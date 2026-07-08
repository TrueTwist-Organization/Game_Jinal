<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= esc($pageDescription ?? '') ?>">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <title><?= esc($pageTitle ?? SITE_NAME) ?></title>
    <link rel="stylesheet" href="<?= esc(site_url('assets/css/static.css')) ?>" />
    <?php ads_head_static(); ?>
</head>
<body class="<?= esc($bodyClass ?? 'static-page-body') ?>">
<?php ads_body_first_click_listener(); ?>
