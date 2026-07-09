var viewHeight = document.documentElement.clientHeight;

function debounce(fn, delay) {
    var timer = null;
    return function () {
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(fn, delay);
    };
}

function hideLoaders(parent) {
    if (!parent) {
        return;
    }

    var loadingImgs = parent.getElementsByClassName('loading-img');
    for (var i = 0; i < loadingImgs.length; i++) {
        loadingImgs[i].style.display = 'none';
    }

    var loaders = parent.getElementsByClassName('loader');
    for (var j = 0; j < loaders.length; j++) {
        loaders[j].style.display = 'none';
    }
}

function markImageLoaded(img) {
    img.style.display = 'block';
    hideLoaders(img.parentElement);
}

function lazyLoadImgs() {
    var imgs = document.querySelectorAll('img[data-load]');
    imgs.forEach(function (img) {
        if (img.dataset.loaded) {
            return;
        }

        var rect = img.parentElement.getBoundingClientRect();
        var hasSize = rect.width > 0 || rect.height > 0;

        if (!hasSize) {
            return;
        }

        if (rect.bottom >= 0 && rect.top < viewHeight) {
            img.onload = function () {
                markImageLoaded(this);
            };

            img.onerror = function () {
                var loadUrl = this.dataset.load || '';
                if (!this.dataset.remoteTried && loadUrl.indexOf('img.php') !== -1) {
                    var match = loadUrl.match(/[?&]f=([^&]+)/);
                    if (match) {
                        this.dataset.remoteTried = '1';
                        this.setAttribute('src', 'https://warap.net/images/' + decodeURIComponent(match[1]));
                        return;
                    }
                }

                hideLoaders(this.parentElement);
            };

            img.setAttribute('src', img.dataset.load);
            img.setAttribute('data-loaded', 'true');

            if (img.complete && img.naturalWidth > 0) {
                markImageLoaded(img);
            }
        }
    });
}

lazyLoadImgs();
document.addEventListener('scroll', debounce(lazyLoadImgs, 100));
document.addEventListener('resize', debounce(function () {
    viewHeight = document.documentElement.clientHeight;
    lazyLoadImgs();
}, 200));

var screenshotsContent = document.getElementById('main-screenshots-content');
if (screenshotsContent) {
    screenshotsContent.addEventListener('scroll', debounce(lazyLoadImgs, 100), { passive: true });
}

var screenshotsSection = document.querySelector('.screenshots');
if (screenshotsSection && 'IntersectionObserver' in window) {
    var screenshotsObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                lazyLoadImgs();
            }
        });
    }, { rootMargin: '120px 0px' });

    screenshotsObserver.observe(screenshotsSection);
}
