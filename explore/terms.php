<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

$pageTitle = 'Terms and Conditions | ' . SITE_NAME;
$pageDescription = 'Terms and Conditions | ' . SITE_NAME;
$bodyClass = 'static-page-body static-terms';

require dirname(__DIR__) . '/includes/static-header.php';
?>
    <h1>Terms and Conditions</h1>
    <p><strong>Last updated:</strong> March 22, 2025</p>
    <a href="<?= esc(site_url('index.php')) ?>" class="btn-home">Back to Home</a>

    <p>Please read these Terms and Conditions carefully before using our Service.</p>

    <h2>Interpretation and Definitions</h2>

    <h3>Interpretation</h3>
    <p>Capitalized terms have the meanings set out below. These definitions apply whether they appear in singular or plural form.</p>

    <h3>Definitions</h3>
    <ul>
        <li><strong>Affiliate:</strong> Any entity that controls, is controlled by, or is under common control with Us.</li>
        <li><strong>Country:</strong> Refers to Delhi, India.</li>
        <li><strong>Company:</strong> (referred to as "the Company", "We", "Us", or "Our") refers to <?= esc(SITE_BRAND) ?>.</li>
        <li><strong>Device:</strong> Any internet-connected device like a smartphone, tablet, or computer used to access the Service.</li>
        <li><strong>Service:</strong> Refers to the <?= esc(SITE_BRAND) ?> website and its related offerings.</li>
        <li><strong>Terms and Conditions:</strong> These terms that govern Your access and use of the Service.</li>
        <li><strong>Third-party Social Media Service:</strong> Any services or content provided by third parties integrated or accessible via Our Service.</li>
        <li><strong>Website:</strong> Refers to <?= esc(SITE_WEBSITE) ?>.</li>
        <li><strong>You:</strong> The individual or legal entity accessing or using the Service.</li>
    </ul>

    <h2>Acknowledgment</h2>
    <p>These Terms constitute a legal agreement between You and <?= esc(SITE_BRAND) ?> regarding the use of the Service. By accessing or using the Service, You agree to be bound by these Terms. If You disagree with any part of the Terms, You may not access the Service.</p>
    <p>You represent that You are at least 18 years old. If You are under 18, You may not use the Service.</p>
    <p>Your use of the Service is also governed by our <a href="<?= esc(site_url('explore/privacy.php')) ?>">Privacy Policy</a>, which describes how we collect and use personal data.</p>

    <h2>Links to Other Websites</h2>
    <p>Our Service may contain links to third-party websites. We do not control or endorse the content or practices of these websites. We recommend reviewing the Terms and Privacy Policies of any third-party websites You visit.</p>

    <h2>Termination</h2>
    <p>We reserve the right to suspend or terminate Your access to the Service at our sole discretion, without notice or liability, if You violate these Terms. Upon termination, Your right to use the Service will immediately cease.</p>

    <h2>Limitation of Liability</h2>
    <p>To the maximum extent permitted by law, <?= esc(SITE_BRAND) ?> and its affiliates shall not be liable for any indirect, incidental, or consequential damages, including but not limited to loss of data or profits, resulting from Your use of the Service. In no event shall our total liability exceed the amount You paid for the Service, or $100 USD if no purchase was made.</p>

    <h2>"AS IS" and "AS AVAILABLE" Disclaimer</h2>
    <p>The Service is provided on an "AS IS" and "AS AVAILABLE" basis. We make no warranties, express or implied, regarding the Service's performance, reliability, or availability.</p>

    <h2>Governing Law</h2>
    <p>These Terms are governed by the laws of Delhi, India, without regard to its conflict of law principles.</p>

    <h2>Dispute Resolution</h2>
    <p>If You have any dispute or concern, We encourage You to contact Us first to attempt an informal resolution.</p>

    <h2>For European Union (EU) Users</h2>
    <p>If You reside in the EU, You are entitled to certain rights under your local laws. Nothing in these Terms limits those rights.</p>

    <h2>United States Legal Compliance</h2>
    <p>You affirm that You are not located in a country subject to U.S. government embargoes or sanctions, and are not listed on any U.S. government prohibited parties lists.</p>

    <h2>Severability and Waiver</h2>
    <h3>Severability</h3>
    <p>If any provision of these Terms is found unenforceable or invalid, the remaining provisions will remain in full force and effect.</p>
    <h3>Waiver</h3>
    <p>Failure by Us to enforce any provision of these Terms will not constitute a waiver of that provision.</p>

    <h2>Changes to These Terms and Conditions</h2>
    <p>We reserve the right to update or modify these Terms at any time. If we make significant changes, we will provide reasonable notice. Your continued use of the Service after the revised Terms become effective signifies Your acceptance of the changes.</p>

    <h2>Contact Us</h2>
    <p>If You have any questions or concerns about these Terms and Conditions, please contact us:</p>
    <ul>
        <li>Email: <a href="mailto:<?= esc(TERMS_EMAIL) ?>"><?= esc(TERMS_EMAIL) ?></a></li>
    </ul>
</body>
</html>
