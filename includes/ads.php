<?php

declare(strict_types=1);

const ADS_DEMO_INTERSTITIAL = '/6355419/Travel/Europe';
// Official GPT rewarded demo path — keep it free of other display slots.
const ADS_DEMO_REWARDED = '/6355419/Travel/Europe/France';
const ADS_DISPLAY_SIZES = '[[336, 280], [728, 90], \'fluid\']';
const ADS_DISPLAY_UNITS = [
    'div-gpt-ad-display-top' => '/6355419/Travel/Asia',
    // Must not reuse ADS_DEMO_ANCHOR (/6355419/Travel) — anchor wins SRA and mid stays empty.
    // Must not reuse ADS_DEMO_REWARDED (/6355419/Travel/Europe/France) — conflicts with rewarded overlay.
    'div-gpt-ad-display-mid' => '/6355419/Travel/Europe/France/Paris',
    'div-gpt-ad-display-bottom' => '/6355419/Travel/Europe/France/Paris',
];
const ADS_DEMO_ANCHOR = '/6355419/Travel';
// Homepage: after 2.5 min with zero activity, show rewarded ad on next cursor move.
const ADS_HOME_IDLE_MS = 150000;

function ads_enabled(): bool
{
    return defined('ADS_ENABLED') && ADS_ENABLED;
}

function ads_gpt_tag(): void
{
    if (!ads_enabled()) {
        return;
    }

    echo '<script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js" crossorigin="anonymous"></script>' . "\n";
}

function ads_rewarded_nav_script(): void
{
    if (!ads_enabled()) {
        return;
    }
    ?>
    <script>
        (function () {
            window.__pageAdLock = window.__pageAdLock || {
                active: null,
                done: false,
            };

            function markAdFinished() {
                window.__pageAdLock.active = null;
                window.__pageAdLock.done = true;
            }

            function canStartAd(type) {
                var lock = window.__pageAdLock;
                return !lock.done && !lock.active;
            }

            function beginAd(type) {
                if (!canStartAd(type)) {
                    return false;
                }
                window.__pageAdLock.active = type;
                return true;
            }

            window.__cancelGameAutoReward = function () {
                if (window.__gameAutoRewardTimer) {
                    clearTimeout(window.__gameAutoRewardTimer);
                    window.__gameAutoRewardTimer = null;
                }
            };

            function ensureDemoOverlay() {
                var overlay = document.getElementById('demo-reward-overlay');
                if (overlay) {
                    return overlay;
                }

                if (!document.getElementById('demo-reward-style')) {
                    var style = document.createElement('style');
                    style.id = 'demo-reward-style';
                    style.textContent = '' +
                        '.demo-reward-overlay{position:fixed;inset:0;z-index:2147483646;background:rgba(0,0,0,.88);display:none;align-items:center;justify-content:center;font-family:Arial,sans-serif}' +
                        '.demo-reward-overlay.is-open{display:flex}' +
                        '.demo-reward-card{width:min(420px,92vw);background:#111;border-radius:12px;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,.5);color:#fff;position:relative}' +
                        '.demo-reward-video{width:100%;aspect-ratio:9/16;max-height:70vh;background:linear-gradient(160deg,#1b2a4a,#0d1117 55%,#20304f);display:flex;align-items:center;justify-content:center;text-align:center;padding:24px;box-sizing:border-box}' +
                        '.demo-reward-video strong{font-size:28px;line-height:1.2;display:block;margin-bottom:12px}' +
                        '.demo-reward-meta{display:flex;justify-content:space-between;align-items:center;padding:10px 14px;background:#000;font-size:13px}' +
                        '.demo-reward-bar{height:3px;background:#333}' +
                        '.demo-reward-bar>span{display:block;height:100%;width:0;background:#fff;transition:width .2s linear}' +
                        '.demo-reward-close{position:absolute;top:10px;right:10px;width:28px;height:28px;border-radius:50%;border:0;background:rgba(255,255,255,.2);color:#fff;font-size:16px;cursor:pointer}';
                    document.head.appendChild(style);
                }

                overlay = document.createElement('div');
                overlay.className = 'demo-reward-overlay';
                overlay.id = 'demo-reward-overlay';
                overlay.setAttribute('aria-hidden', 'true');
                overlay.innerHTML = '' +
                    '<div class="demo-reward-card">' +
                    '<button type="button" class="demo-reward-close" id="demo-reward-close" aria-label="Close">×</button>' +
                    '<div class="demo-reward-video"><div><strong>DEMO REWARD AD</strong><div>Google demo inventory was empty.<br>This is the localhost fallback video reward UI.</div></div></div>' +
                    '<div class="demo-reward-bar"><span id="demo-reward-progress"></span></div>' +
                    '<div class="demo-reward-meta"><span id="demo-reward-timer">Reward in 15 seconds</span><span>▶</span></div>' +
                    '</div>';
                document.body.appendChild(overlay);
                return overlay;
            }

            window.__showDemoRewardedFallback = function (onDone) {
                var overlay = ensureDemoOverlay();
                var progress = document.getElementById('demo-reward-progress');
                var timer = document.getElementById('demo-reward-timer');
                var closeBtn = document.getElementById('demo-reward-close');
                var seconds = 15;
                var elapsed = 0;
                var finished = false;
                var interval = null;

                function finish() {
                    if (finished) {
                        return;
                    }
                    finished = true;
                    if (interval) {
                        clearInterval(interval);
                    }
                    overlay.classList.remove('is-open');
                    overlay.setAttribute('aria-hidden', 'true');
                    if (typeof onDone === 'function') {
                        onDone();
                    }
                }

                overlay.classList.add('is-open');
                overlay.setAttribute('aria-hidden', 'false');
                progress.style.width = '0%';
                timer.textContent = 'Reward in ' + seconds + ' seconds';

                interval = setInterval(function () {
                    elapsed += 1;
                    var left = Math.max(seconds - elapsed, 0);
                    progress.style.width = Math.min((elapsed / seconds) * 100, 100) + '%';
                    if (left > 0) {
                        timer.textContent = 'Reward in ' + left + ' seconds';
                    } else {
                        timer.textContent = 'Reward unlocked';
                        setTimeout(finish, 600);
                    }
                }, 1000);

                closeBtn.onclick = finish;
            };

            window.__showRewardedAd = function (onDone, options) {
                options = options || {};
                var lock = window.__pageAdLock;

                if (lock.active) {
                    if (typeof onDone === 'function') {
                        onDone();
                    }
                    return;
                }

                if (options.force) {
                    lock.done = false;
                } else if (lock.done) {
                    if (typeof onDone === 'function') {
                        onDone();
                    }
                    return;
                }

                if (!beginAd('rewarded')) {
                    if (typeof onDone === 'function') {
                        onDone();
                    }
                    return;
                }

                var done = false;
                var usingFallback = false;
                var gptTimeout = null;

                function finish() {
                    if (done) {
                        return;
                    }
                    done = true;
                    if (gptTimeout) {
                        clearTimeout(gptTimeout);
                    }
                    markAdFinished();
                    if (typeof onDone === 'function') {
                        onDone();
                    }
                }

                function showFallback() {
                    if (usingFallback || done) {
                        return;
                    }
                    usingFallback = true;
                    if (gptTimeout) {
                        clearTimeout(gptTimeout);
                    }
                    window.__showDemoRewardedFallback(finish);
                }

                if (!window.googletag || !googletag.cmd) {
                    showFallback();
                    return;
                }

                googletag.cmd.push(function () {
                    var rewardedSlot = googletag.defineOutOfPageSlot(
                        <?= json_encode(ADS_DEMO_REWARDED, JSON_UNESCAPED_SLASHES) ?>,
                        googletag.enums.OutOfPageFormat.REWARDED
                    );

                    if (!rewardedSlot) {
                        showFallback();
                        return;
                    }

                    rewardedSlot.addService(googletag.pubads());
                    googletag.enableServices();
                    googletag.display(rewardedSlot);

                    googletag.pubads().addEventListener('rewardedSlotReady', function (event) {
                        if (event.slot !== rewardedSlot || done || usingFallback) {
                            return;
                        }
                        var shown = event.makeRewardedVisible();
                        if (!shown) {
                            try {
                                googletag.destroySlots([rewardedSlot]);
                            } catch (e) {}
                            showFallback();
                        }
                    });

                    googletag.pubads().addEventListener('rewardedSlotClosed', function (event) {
                        if (event.slot === rewardedSlot) {
                            try {
                                googletag.destroySlots([rewardedSlot]);
                            } catch (e) {}
                            finish();
                        }
                    });

                    googletag.pubads().addEventListener('slotRenderEnded', function (event) {
                        if (event.slot === rewardedSlot && event.isEmpty) {
                            try {
                                googletag.destroySlots([rewardedSlot]);
                            } catch (e) {}
                            showFallback();
                        }
                    });

                    gptTimeout = setTimeout(function () {
                        if (!done && !usingFallback) {
                            try {
                                googletag.destroySlots([rewardedSlot]);
                            } catch (e) {}
                            showFallback();
                        }
                    }, 3500);
                });
            };

            window.showRewardedThenNavigate = function (url) {
                window.__showRewardedAd(function () {
                    window.location.href = url;
                });
            };

            window.bindRewardedLinks = function (selector) {
                document.querySelectorAll(selector).forEach(function (link) {
                    if (link.dataset.rewardBound === '1') {
                        return;
                    }
                    link.dataset.rewardBound = '1';
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        if (typeof window.__cancelGameAutoReward === 'function') {
                            window.__cancelGameAutoReward();
                        }
                        window.showRewardedThenNavigate(link.href);
                    });
                });
            };

            window.bindGameBackButtonReward = function () {
                if (!window.history || !history.pushState) {
                    return;
                }

                history.pushState({ gameBackAd: true }, document.title, location.href);

                window.addEventListener('popstate', function () {
                    if (window.__gameBackAdExit) {
                        return;
                    }

                    history.pushState({ gameBackAd: true }, document.title, location.href);

                    if (typeof window.__cancelGameAutoReward === 'function') {
                        window.__cancelGameAutoReward();
                    }

                    if (typeof window.__showRewardedAd !== 'function') {
                        window.__gameBackAdExit = true;
                        history.back();
                        return;
                    }

                    window.__showRewardedAd(function () {
                        window.__gameBackAdExit = true;
                        history.back();
                    }, { force: true });
                });
            };
        })();
    </script>
    <?php
}

function ads_head_home(): void
{
    if (!ads_enabled()) {
        return;
    }

    ads_gpt_tag();
    ads_rewarded_nav_script();
    ?>
    <script>
        function initHomeRewardedLinks() {
            window.bindRewardedLinks('.game-link');
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initHomeRewardedLinks);
        } else {
            initHomeRewardedLinks();
        }
    </script>
    <?php
}

function ads_head_game(): void
{
    if (!ads_enabled()) {
        return;
    }

    ads_gpt_tag();
    ?>
    <script type="text/javascript">
        function reward(event, url, type) {
            document.querySelector('.body-loading').style.display = 'flex';
            setTimeout(function () {
                showTip(url, type);
            }, 5000);
        }

        function showTip(url, type) {
            document.querySelector('.body-loading .loader').style.display = 'none';
            document.querySelector('.tooltip').style.display = 'block';
            var text = type === 'apple' ? 'App Store' : 'Google Play';
            document.querySelector('.tooltip .tooltip-text p span').innerHTML = text;
            document.querySelector('.tooltip-button-continue').href = url;

            document.querySelector('.tooltip-button-cancel').addEventListener('click', function () {
                document.querySelector('.body-loading').style.display = 'none';
                window.location.reload();
            });

            document.querySelector('.tooltip-button-continue').addEventListener('click', function () {
                document.querySelector('.body-loading').style.display = 'none';
            });
        }
    </script>
    <script>
        window.addEventListener('load', function () {
            setTimeout(function () {
                var loader = document.getElementById('page-loader');
                if (loader) {
                    loader.style.display = 'none';
                }
            }, 800);
        });
    </script>
    <?php
}

function ads_head_static(): void
{
    if (!ads_enabled()) {
        return;
    }

    ads_gpt_tag();
    ?>
    <script>
        window.googletag = window.googletag || { cmd: [] };
        var interstitialSlot;
        var interShown = false;

        googletag.cmd.push(function () {
            interstitialSlot = googletag.defineOutOfPageSlot(
                <?= json_encode(ADS_DEMO_INTERSTITIAL, JSON_UNESCAPED_SLASHES) ?>,
                googletag.enums.OutOfPageFormat.INTERSTITIAL
            );

            if (interstitialSlot) {
                interstitialSlot.addService(googletag.pubads());
            }

            googletag.pubads().enableSingleRequest();
            googletag.pubads().collapseEmptyDivs();
            googletag.enableServices();
        });

        function showInterstitialOnce(callback) {
            if (interShown) {
                if (callback) {
                    callback();
                }
                return;
            }

            interShown = true;

            googletag.cmd.push(function () {
                if (interstitialSlot) {
                    googletag.display(interstitialSlot);
                }

                setTimeout(function () {
                    if (callback) {
                        callback();
                    }
                }, 700);
            });
        }
    </script>
    <?php
}

function ads_body_first_click_listener(): void
{
    if (!ads_enabled()) {
        return;
    }
    ?>
    <script>
        document.addEventListener(
            'click',
            function (event) {
                var target = event.target;
                if (!target || typeof target.closest !== 'function') {
                    return;
                }

                // Rewarded-link flows handle their own single ad — don't stack interstitial.
                if (target.closest('a.game-link, .down-link-item.t-play, .right-rec-container a.game-item')) {
                    return;
                }

                if (typeof window.__cancelGameAutoReward === 'function') {
                    window.__cancelGameAutoReward();
                }

                if (typeof showInterstitialOnce === 'function') {
                    showInterstitialOnce();
                }
            },
            { once: true, capture: true }
        );
    </script>
    <?php
}

function render_display_ad(string $slotId): void
{
    if (!ads_enabled()) {
        return;
    }
    ?>
    <div class="ads">
        <div id="<?= esc($slotId) ?>" style="min-width: 300px; min-height: 90px;"></div>
    </div>
    <?php
}

function render_download_overlay(): void
{
    if (!ads_enabled()) {
        return;
    }
    ?>
    <div class="body-loading">
        <div class="loader"></div>
        <div class="tooltip">
            <div class="tooltip-text">
                <p>Coming soon to the <span>App Store</span></p>
                <p>Are you sure you want to continue?</p>
            </div>
            <div class="tooltip-button">
                <div class="tooltip-button-cancel">CANCEL</div>
                <a class="tooltip-button-continue" target="_blank" rel="noopener noreferrer">CONTINUE</a>
            </div>
        </div>
    </div>
    <?php
}

function ads_footer_game(): void
{
    if (!ads_enabled()) {
        return;
    }

    $displayUnits = ADS_DISPLAY_UNITS;
    ?>
    <script>
        window.googletag = window.googletag || { cmd: [] };

        var interstitialSlot;
        var interShown = false;
        var anchorSlot;

        function showInterstitialOnce(callback) {
            if (interShown || (window.__pageAdLock && (window.__pageAdLock.done || window.__pageAdLock.active))) {
                if (callback) {
                    callback();
                }
                return;
            }

            interShown = true;
            if (window.__pageAdLock) {
                window.__pageAdLock.active = 'interstitial';
            }

            googletag.cmd.push(function () {
                if (interstitialSlot) {
                    googletag.display(interstitialSlot);
                }

                setTimeout(function () {
                    if (window.__pageAdLock) {
                        window.__pageAdLock.active = null;
                        window.__pageAdLock.done = true;
                    }
                    if (callback) {
                        callback();
                    }
                }, 700);
            });
        }

        googletag.cmd.push(function () {
            var sizes = <?= ADS_DISPLAY_SIZES ?>;
            var displayMap = <?= json_encode($displayUnits, JSON_UNESCAPED_SLASHES) ?>;

            Object.keys(displayMap).forEach(function (slotId) {
                googletag.defineSlot(displayMap[slotId], sizes, slotId).addService(googletag.pubads());
            });

            interstitialSlot = googletag.defineOutOfPageSlot(
                <?= json_encode(ADS_DEMO_INTERSTITIAL, JSON_UNESCAPED_SLASHES) ?>,
                googletag.enums.OutOfPageFormat.INTERSTITIAL
            );
            if (interstitialSlot) {
                interstitialSlot.addService(googletag.pubads());
            }

            anchorSlot = googletag.defineOutOfPageSlot(
                <?= json_encode(ADS_DEMO_ANCHOR, JSON_UNESCAPED_SLASHES) ?>,
                document.body.clientWidth <= 500
                    ? googletag.enums.OutOfPageFormat.TOP_ANCHOR
                    : googletag.enums.OutOfPageFormat.BOTTOM_ANCHOR
            );
            if (anchorSlot) {
                anchorSlot.setTargeting('test', 'anchor').addService(googletag.pubads());
            }

            googletag.pubads().enableSingleRequest();
            googletag.pubads().collapseEmptyDivs();
            googletag.enableServices();

            Object.keys(displayMap).forEach(function (slotId) {
                googletag.display(slotId);
            });

            if (anchorSlot) {
                googletag.display(anchorSlot);
            }

            googletag.pubads().addEventListener('slotRenderEnded', function (event) {
                if (event.isEmpty && displayMap[event.slot.getSlotElementId()]) {
                    setTimeout(function () {
                        googletag.pubads().refresh([event.slot]);
                    }, 2000);
                }
            });
        });
    </script>
    <?php ads_rewarded_nav_script(); ?>
    <script>
        // Match original: auto reward ~2s after load, but only if no click ad already ran.
        window.__gameAutoRewardTimer = setTimeout(function () {
            window.__gameAutoRewardTimer = null;
            if (window.__pageAdLock && (window.__pageAdLock.done || window.__pageAdLock.active)) {
                return;
            }
            if (typeof window.__showRewardedAd === 'function') {
                window.__showRewardedAd();
            }
        }, 2000);

        if (typeof window.bindGameBackButtonReward === 'function') {
            window.bindGameBackButtonReward();
        }

        function initSidebarRewardedLinks() {
            if (typeof window.bindRewardedLinks === 'function') {
                window.bindRewardedLinks('.right-rec-container a.game-item');
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSidebarRewardedLinks);
        } else {
            initSidebarRewardedLinks();
        }
    </script>
    <?php
}

function ads_footer_home(): void
{
    if (!ads_enabled()) {
        return;
    }
    ?>
    <script>
        (function () {
            var idleMs = <?= ADS_HOME_IDLE_MS ?>;
            var checkEveryMs = 5000;
            var lastActivity = Date.now();
            var idleRewardReady = false;
            var idleCheckTimer = null;

            function showHomeIdleRewardedAd() {
                if (window.__pageAdLock && window.__pageAdLock.active) {
                    return;
                }

                if (typeof window.__showRewardedAd !== 'function') {
                    return;
                }

                lastActivity = Date.now();
                idleRewardReady = false;
                window.__showRewardedAd(function () {
                    lastActivity = Date.now();
                    idleRewardReady = false;
                }, { force: true });
            }

            function resetIdleClock() {
                lastActivity = Date.now();
                idleRewardReady = false;
            }

            function pollIdleState() {
                if (idleRewardReady) {
                    return;
                }

                if (Date.now() - lastActivity >= idleMs) {
                    idleRewardReady = true;
                }
            }

            function onMovementAfterIdle() {
                if (!idleRewardReady) {
                    resetIdleClock();
                    return;
                }

                showHomeIdleRewardedAd();
            }

            function startIdleWatcher() {
                if (idleCheckTimer) {
                    clearInterval(idleCheckTimer);
                }

                idleCheckTimer = setInterval(pollIdleState, checkEveryMs);
            }

            // Any action during the wait period resets the 2.5 min idle clock.
            var resetEvents = ['mousedown', 'keydown', 'scroll', 'wheel', 'click'];

            resetEvents.forEach(function (eventName) {
                document.addEventListener(eventName, resetIdleClock, { passive: true });
            });

            // After 2.5 min of zero activity, the next cursor move shows rewarded ad.
            document.addEventListener('mousemove', onMovementAfterIdle, { passive: true });

            // Mobile: first touch after idle period shows rewarded ad.
            document.addEventListener('touchstart', onMovementAfterIdle, { passive: true });

            startIdleWatcher();
        })();
    </script>
    <?php
}

function ads_head(): void
{
    ads_head_home();
}

function ads_footer_script(string $page): void
{
    if (!ads_enabled()) {
        return;
    }

    if ($page === 'game') {
        ads_footer_game();
    }
}
