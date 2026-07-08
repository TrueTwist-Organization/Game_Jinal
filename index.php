<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

$pageTitle = SITE_TAGLINE . ' | ' . SITE_NAME;
$pageDescription = SITE_DESCRIPTION;
$pageKeywords = 'Top Free Games for Phones, Popular Game Downloads, Action-Packed Mobile Titles, Strategic Gameplay Apps, Brain Teaser Games, High-Speed Racing Apps, Games for Kids and Teens, Cooking and Dress-Up Games, Thrilling Adventures, ' . SITE_NAME;
$bodyClass = 'home-page';
$extraCss = ['assets/css/home.css'];
$games = load_games_list();

require __DIR__ . '/includes/header.php';
?>
    <main class="index-content">
        <section class="icon-group" id="iconGroup">
            <div class="grid-warp">
                <div class="game-list-warp">
                    <ul class="game-list">
                        <?php foreach ($games as $game): ?>
                        <li>
                            <a class="game-link" href="<?= esc(site_url('explore/game/' . $game['slug'] . '.html')) ?>" title="<?= esc($game['title']) ?>">
                                <div class="relative" style="width: 100%; height: 100%">
                                    <img class="game-img lazy-load" alt="<?= esc($game['title']) ?>"
                                        data-load="<?= esc(img_url($game['image'])) ?>" />
                                    <h2 class="game-item-title"><?= esc($game['title']) ?></h2>
                                    <div class="game-item-shadow"></div>
                                </div>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
