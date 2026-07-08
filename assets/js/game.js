function openDownload(url) {
    window.open(url, '_blank', 'noopener,noreferrer');
}

document.addEventListener('DOMContentLoaded', function () {
    var leftBtn = document.getElementById('main-screenshots-left');
    var rightBtn = document.getElementById('main-screenshots-right');
    var container = document.getElementById('main-screenshots-content');

    if (!leftBtn || !rightBtn || !container) {
        return;
    }

    function updateButtons() {
        leftBtn.classList.toggle('disabled', container.scrollLeft <= 0);
        rightBtn.classList.toggle('disabled', container.scrollLeft + container.clientWidth >= container.scrollWidth - 5);
    }

    leftBtn.addEventListener('click', function () {
        container.scrollBy({ left: -320, behavior: 'smooth' });
    });

    rightBtn.addEventListener('click', function () {
        container.scrollBy({ left: 320, behavior: 'smooth' });
    });

    container.addEventListener('scroll', updateButtons);
    updateButtons();
});
