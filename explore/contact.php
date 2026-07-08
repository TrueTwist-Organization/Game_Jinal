<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

$pageTitle = 'Contact Us | ' . SITE_NAME;
$pageDescription = 'Contact ' . SITE_NAME;
$bodyClass = 'static-page-body static-contact';

require dirname(__DIR__) . '/includes/static-header.php';
?>
    <h1>Contact Us</h1>
    <p>Got a question or want to share your thoughts? We'd love to hear from you!</p>
    <p>Drop us a line at <a href="mailto:<?= esc(CONTACT_EMAIL) ?>"><?= esc(CONTACT_EMAIL) ?></a> and we'll get back to you as soon as we can.</p>
    <p>Your feedback helps make <?= esc(SITE_BRAND) ?> even better. Thanks for being part of our community!</p>
    <a href="<?= esc(site_url('index.php')) ?>" class="btn-home">Back to Home</a>
</body>
</html>
