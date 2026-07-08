<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

$slug = $_GET['slug'] ?? '';
$slug = preg_replace('/[^a-zA-Z0-9._\-]/', '', $slug);

if ($slug === '') {
    http_response_code(404);
    echo 'Game not found';
    exit;
}

$game = load_game($slug);
if ($game === null) {
    $games = load_games_list();
    foreach ($games as $item) {
        if ($item['slug'] === $slug) {
            $game = [
                'slug' => $item['slug'],
                'title' => $item['title'],
                'cover' => $item['image'],
                'category' => 'Game',
                'age' => '3+',
                'rating' => '4.5',
                'platform' => 'Android',
                'price' => 'Free',
                'installs' => '',
                'updated' => '',
                'size' => '',
                'description' => 'Download ' . $item['title'] . ' for free on your mobile device.',
                'editor_review' => '',
                'how_to_play' => [],
                'apple_url' => '',
                'google_url' => '',
                'screenshots' => [],
                'histogram' => [],
                'featured' => array_slice(array_values(array_filter($games, static fn($g) => $g['slug'] !== $slug)), 0, 10),
                'you_may_like' => array_slice(array_values(array_filter($games, static fn($g) => $g['slug'] !== $slug)), 10, 10),
            ];
            break;
        }
    }
}

if ($game === null) {
    http_response_code(404);
    echo 'Game not found';
    exit;
}

$pageTitle = 'Get ' . $game['title'] . ' for Free | ' . SITE_NAME;
$pageDescription = $game['description'] ?? '';
$bodyClass = 'game-page';
$extraCss = ['assets/css/game.css', 'assets/css/ads.css'];
$extraJs = ['assets/js/game.js'];
$themeColor = '#0BCBFF';

require dirname(__DIR__) . '/includes/game-header.php';
?>
    <div id="page-loader">
        <div class="spinner"></div>
        <div class="loader-text">Loading...</div>
    </div>
    <div class="detail-main-container">
        <div class="main-container">
            <div class="detail-info-main-cointainer">
                <div class="info-card">
                    <div class="info-img relative">
                        <img class="lazy-load cover-img" data-load="<?= esc(img_url($game['cover'])) ?>" alt="<?= esc($game['title']) ?>" />
                        <div class="loader"></div>
                    </div>
                    <div class="info-info">
                        <div class="info-name">
                            <h1><?= esc($game['title']) ?></h1>
                        </div>
                        <div class="info-developer pc">
                            <div class="info-downloads info-developer-item">
                                <img class="icon" src="<?= esc(img_url('category.svg')) ?>" alt="category" />
                                <div class="number"><?= esc($game['category']) ?></div>
                            </div>
                            <div class="line"></div>
                            <div class="info-size info-developer-item">
                                <img class="icon" src="<?= esc(img_url('age.svg')) ?>" alt="age" />
                                <div class="number"><?= esc($game['age']) ?></div>
                            </div>
                        </div>
                        <div class="info-rating">
                            <div class="rating-container">
                                <?= render_stars((float) $game['rating']) ?>
                                <span class="rating-score"><?= esc($game['rating']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <?php render_display_ad('div-gpt-ad-display-top'); ?>

                <div class="about-game">
                    <ul class="game-info-table">
                        <li class="phone"><span class="info-key">Category</span><span class="info-value"><?= esc($game['category']) ?></span></li>
                        <li><span class="info-key">Platform</span><span class="info-value"><?= esc($game['platform']) ?></span></li>
                        <li class="phone"><span class="info-key">Age</span><span class="info-value"><?= esc($game['age']) ?></span></li>
                        <li><span class="info-key">Price</span><span class="info-value"><?= esc($game['price']) ?></span></li>
                        <?php if (!empty($game['installs'])): ?>
                        <li><span class="info-key">Installs</span><span class="info-value"><?= esc($game['installs']) ?></span></li>
                        <?php endif; ?>
                        <?php if (!empty($game['updated'])): ?>
                        <li><span class="info-key">Updated</span><span class="info-value"><?= esc($game['updated']) ?></span></li>
                        <?php endif; ?>
                        <?php if (!empty($game['size'])): ?>
                        <li><span class="info-key">Size</span><span class="info-value"><?= esc($game['size']) ?></span></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <?php render_display_ad('div-gpt-ad-display-mid'); ?>

                <?php if (!empty($game['editor_review'])): ?>
                <div class="editor-review">
                    <div class="editor-review-title"><span>Editor's Review</span></div>
                    <div class="desc"><span><?= esc($game['editor_review']) ?></span></div>
                </div>
                <?php endif; ?>

                <?php if (!empty($game['how_to_play'])): ?>
                <div class="how-to-play">
                    <div class="how-to-play-title"><span>How To Play?</span></div>
                    <div class="how-to-play-info">
                        <?php foreach ($game['how_to_play'] as $step): ?>
                        <p><?= esc($step) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php render_display_ad('div-gpt-ad-display-bottom'); ?>

                <div class="download-link">
                    <div class="get-the-game-down">
                        <?php if (!empty($game['apple_url'])): ?>
                        <div class="down-link-item t-play" onclick="reward(event,'<?= esc($game['apple_url']) ?>','apple')">
                            <img alt="apple" src="<?= esc(img_url('apple-white.png')) ?>" /><span>App Store</span>
                        </div>
                        <?php else: ?>
                        <div class="down-link-item t-play down-link-item-ban gray">
                            <img alt="apple" src="<?= esc(img_url('apple-white.png')) ?>" /><span>App Store</span>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($game['google_url'])): ?>
                        <div class="down-link-item t-play" onclick="reward(event,'<?= esc($game['google_url']) ?>','google')">
                            <img alt="google" src="<?= esc(img_url('google.png')) ?>" /><span>Google Play</span>
                        </div>
                        <?php else: ?>
                        <div class="down-link-item t-play down-link-item-ban gray">
                            <img alt="google" src="<?= esc(img_url('google.png')) ?>" /><span>Google Play</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!empty($game['screenshots'])): ?>
                <div class="screenshots">
                    <div class="screenshots-title"><span>Screenshots</span></div>
                    <div class="main-screenshots">
                        <div class="disabled" id="main-screenshots-left"></div>
                        <div id="main-screenshots-right"></div>
                        <div id="main-screenshots-content">
                            <div class="main-screenshots-sub-container visible-horizontal" id="screenshots_container">
                                <?php foreach ($game['screenshots'] as $shot): ?>
                                <div class="main-screenshots-item border-radius shadow relative">
                                    <img class="main-screenshots-img lazy-load cs-lazy"
                                        data-load="<?= esc(img_url($shot)) ?>" alt="<?= esc($game['title']) ?>" />
                                    <div class="loader"></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="rating-histogram">
                    <div class="rating-histogram-title"><span>Ratings</span></div>
                    <div class="rating-box-container">
                        <div class="rating-info">
                            <span><?= esc($game['rating']) ?></span>
                            <div class="rating-container"><?= render_stars((float) $game['rating']) ?></div>
                        </div>
                        <div class="histogram-info">
                            <ul class="rating-detail">
                                <?php
                                $histogram = $game['histogram'] ?? [];
                                usort($histogram, static fn($a, $b) => $b['stars'] <=> $a['stars']);
                                foreach ($histogram as $row):
                                ?>
                                <li>
                                    <span><?= esc((string) $row['stars']) ?></span>
                                    <p class="score-progress"><b style="--width: <?= esc($row['width']) ?>"></b></p>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php if (!empty($game['featured'])): ?>
                <div class="rec-game">
                    <div class="rec-game-title">Featured App</div>
                    <div class="rec-game-container">
                        <div class="game-list">
                            <?php foreach ($game['featured'] as $item): ?>
                            <a class="game-item t-image" href="<?= esc(site_url('explore/game/' . $item['slug'] . '.html')) ?>">
                                <div class="item-img relative">
                                    <img class="game-item-img lazy-load" data-load="<?= esc(img_url($item['image'])) ?>" alt="<?= esc($item['title']) ?>" />
                                    <div class="loader"></div>
                                </div>
                                <div class="item-info"><h2><?= esc($item['title']) ?></h2></div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($game['you_may_like'])): ?>
        <div class="right-rec-container">
            <div class="you-may-like">
                <div class="you-may-like-title">You May Also Like</div>
                <div class="game-list">
                    <?php foreach ($game['you_may_like'] as $item): ?>
                    <a class="game-item t-image" href="<?= esc(site_url('explore/game/' . $item['slug'] . '.html')) ?>">
                        <div class="item-img relative">
                            <img class="game-item-img lazy-load" data-load="<?= esc(img_url($item['image'])) ?>" alt="<?= esc($item['title']) ?>" />
                            <div class="loader"></div>
                        </div>
                        <div class="item-info">
                            <h2><?= esc($item['title']) ?></h2>
                            <span><?= esc($item['developer'] ?? '') ?></span>
                            <div class="rating-container" style="border: none">
                                <span class="rating-score" style="font-size: 12px"><?= esc($item['rating'] ?? '4.5') ?></span>
                                <img class="start" src="<?= esc(img_url('rate-no.svg')) ?>" alt="Rating" />
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
<?php render_download_overlay(); ?>
<?php require dirname(__DIR__) . '/includes/game-footer.php'; ?>
