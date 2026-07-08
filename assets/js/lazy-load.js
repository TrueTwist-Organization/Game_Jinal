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
