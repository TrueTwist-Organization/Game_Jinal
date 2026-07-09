<?php

declare(strict_types=1);
?>
    <footer>
        <div class="line"></div>
        <div class="footer-content" style="max-width: 1030px">
            <p style="font-size: 16px; margin-bottom: 30px">
                Welcome to <?= esc(SITE_NAME) ?>, here we have the best games including
                strategy games, RPG games, horror games, simulation games, shooting
                games, casual games and many more kinds of games. We offer free game
                apk to download. Discover the best games and download faster, easier and
                safer.
            </p>
            <p style="text-align: left;">Disclaimer
                <br><br>
                1. Independent Platform
                <?= esc(SITE_NAME) ?> is an independent content platform and does not develop, own, or publish any of
                the games or applications featured on this website. We are not affiliated with or endorsed by any official game
                developers or publishers unless explicitly stated.<br>
                2. Content Source &amp; Purpose
                All game-related information, including descriptions, screenshots, APK references, and historical
                versions, is collected from publicly available sources such as official app stores (e.g., Google Play Store and Apple
                App Store). This content is provided strictly for informational and discovery purposes to help users explore
                games.<br>
                3. Intellectual Property Rights
                All trademarks, logos, product names, and brand assets displayed on this website belong to their
                respective owners. We do not claim ownership of any third-party intellectual property.<br>
                4. Download &amp; External Links
                We do not host or modify any copyrighted APK files on our servers unless explicitly stated. Where
                applicable, we provide official download links directing users to trusted platforms such as the Google Play Store or
                App Store. Users are encouraged to download applications only from official sources.<br>
                5. User Responsibility
                Users are solely responsible for how they use the information and links provided on this website. We do
                not guarantee compatibility, safety, or performance of third-party applications.<br>
                6. Copyright Compliance (DMCA)
                We comply with the Digital Millennium Copyright Act (DMCA) and other applicable laws. If you are a
                copyright owner or authorized representative and believe that any content on this website infringes your rights,
                please contact us with valid proof, and we will promptly review and take appropriate action.<br>
                7. Contact Information
                For any inquiries, copyright concerns, or content removal requests, please contact us via the official
                contact page.<br>
            </p><br>
            <div class="links">
                <a href="<?= esc(site_url('explore/contact.php')) ?>" title="Contact">Contact</a>
                <a href="<?= esc(site_url('explore/privacy.php')) ?>" title="Privacy">Privacy Policy</a>
                <a href="<?= esc(site_url('explore/terms.php')) ?>" title="Terms">Terms Of Services</a>
            </div>
            <p class="introduce">&copy; <?= date('Y') ?> <?= esc(SITE_NAME) ?>. All rights reserved.</p>
        </div>
    </footer>
    <script src="<?= esc(site_url('assets/js/lazy-load.js')) ?>"></script>
    <?php ads_footer_home(); ?>
</body>
</html>
