<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

$pageTitle = 'Privacy Policy | ' . SITE_NAME;
$pageDescription = SITE_BRAND . ' Privacy Policy';
$bodyClass = 'static-page-body static-privacy';

require dirname(__DIR__) . '/includes/static-header.php';
?>
    <h1>Privacy Policy</h1>

    <p><strong>Last updated:</strong> <?= esc(SITE_LAST_UPDATED) ?></p>
    <a href="<?= esc(site_url('index.php')) ?>" class="btn-home">Back to Home</a>

    <p>At <?= esc(SITE_BRAND) ?>, your privacy matters to us. This Privacy Policy outlines how we collect, use, and protect your information when you use our services. It also explains your rights and how the law safeguards your personal data.</p>

    <p>By using our service, you agree to the collection and use of information in accordance with this policy.</p>

    <h2>Interpretation and Definitions</h2>
    <h3>Interpretation</h3>
    <p>Capitalized words have specific meanings defined below. These definitions apply whether used in singular or plural form.</p>

    <h3>Definitions</h3>
    <p>For the purposes of this Privacy Policy:</p>
    <ul>
        <li><strong>Account:</strong> A unique profile created for You to access our services.</li>
        <li><strong>Affiliate:</strong> Any entity that controls, is controlled by, or is under common control with Us.</li>
        <li><strong>Company:</strong> (referred to as "the Company", "We", "Us", or "Our") refers to <?= esc(SITE_BRAND) ?>.</li>
        <li><strong>Cookies:</strong> Small data files stored on Your device to improve functionality and analytics.</li>
        <li><strong>Country:</strong> Refers to Delhi, India.</li>
        <li><strong>Device:</strong> Any tool used to access our service, such as a smartphone, tablet, or computer.</li>
        <li><strong>Personal Data:</strong> Information that identifies an individual.</li>
        <li><strong>Service:</strong> Refers to the <?= esc(SITE_BRAND) ?> website.</li>
        <li><strong>Service Provider:</strong> A third-party entity processing data on behalf of the Company.</li>
        <li><strong>Usage Data:</strong> Information collected automatically like IP address, browser type, and session duration.</li>
        <li><strong>Website:</strong> Refers to <?= esc(SITE_WEBSITE) ?>.</li>
        <li><strong>You:</strong> The individual using our Service or any legal entity on whose behalf that individual is acting.</li>
    </ul>

    <h2>Collecting and Using Your Personal Data</h2>

    <h3>Types of Data Collected</h3>
    <h4>Personal Data</h4>
    <p>We may ask for personally identifiable information, such as:</p>
    <ul>
        <li>Email address</li>
    </ul>

    <h4>Usage Data</h4>
    <p>Collected automatically and may include:</p>
    <ul>
        <li>Your IP address, browser type/version</li>
        <li>Pages visited, time spent, and diagnostic data</li>
    </ul>

    <h3>Tracking Technologies and Cookies</h3>
    <p>We use Cookies and similar tools to enhance your experience. Disabling Cookies may impact site functionality. Types include:</p>
    <ul>
        <li>Essential Cookies: Enable core functions.</li>
        <li>Preference Cookies: Store your settings.</li>
        <li>Analytics Cookies: Help us improve our service.</li>
    </ul>

    <h3>Use of Your Personal Data</h3>
    <p>We use your data for purposes such as:</p>
    <ul>
        <li>Operating and maintaining our Service</li>
        <li>Managing user accounts</li>
        <li>Customer support</li>
        <li>Service updates and promotional content</li>
        <li>Site performance and feature improvements</li>
    </ul>

    <h3>Retention of Your Personal Data</h3>
    <p>We retain data only as long as necessary for stated purposes, legal obligations, or dispute resolution.</p>

    <h3>Transfer of Your Personal Data</h3>
    <p>Your information may be transferred and processed in other countries. By using our Service, you agree to such transfers.</p>

    <h3>Deleting Your Personal Data</h3>
    <p>You may request data deletion by contacting us at <a href="mailto:<?= esc(CONTACT_EMAIL) ?>"><?= esc(CONTACT_EMAIL) ?></a>. Certain data may be retained to meet legal requirements.</p>

    <h3>Disclosure of Your Personal Data</h3>
    <p>Your data may be disclosed:</p>
    <ul>
        <li>During business transfers (e.g., mergers or acquisitions)</li>
        <li>To comply with legal obligations</li>
        <li>To protect rights, property, or user safety</li>
    </ul>

    <h3>Children's Privacy</h3>
    <p>Our Service is not intended for users under the age of 13. We do not knowingly collect data from children. Please contact us if you believe your child has provided personal data.</p>

    <h3>Links to Other Websites</h3>
    <p>We may link to third-party sites. We are not responsible for their content or privacy practices.</p>

    <h3>Changes to This Privacy Policy</h3>
    <p>We may update this policy from time to time. Updates will be posted on this page with the new effective date. Please review it periodically.</p>

    <h3>Contact Us</h3>
    <p>If you have any questions about this Privacy Policy, contact us at:</p>
    <ul>
        <li>Email: <a href="mailto:<?= esc(CONTACT_EMAIL) ?>"><?= esc(CONTACT_EMAIL) ?></a></li>
    </ul>
</body>
</html>
