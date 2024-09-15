// slide banner
let listBanner = document.querySelector('.banner .list-banner');
let items = document.querySelectorAll('.banner .item-banner');
let dots = document.querySelectorAll('.banner .dots-banner li');
let active = 0;
let lengthItems = items.length - 1;
let refreshSlider;
// set chiều rộng của banner theo số phần tử
listBanner.style.width = listBanner.children.length * 100 + '%';
function reloadSlider() {
    let checkLeft = items[active].offsetLeft;
    listBanner.style.left = -checkLeft + 'px';

    let lastActiveDot = document.querySelector('.banner .dots-banner li.active');
    if (lastActiveDot) {
        lastActiveDot.classList.remove('active');
    }
    dots[active].classList.add('active');
}

function startSlider() {
    refreshSlider = setInterval(() => {
        if (active + 1 > lengthItems) {
            active = 0;
        } else {
            active += 1;
        }
        reloadSlider();
    }, 3000);
}

function stopSlider() {
    clearInterval(refreshSlider);
}

dots.forEach((li, key) => {
    li.addEventListener('click', function () {
        active = key;
        reloadSlider();
        stopSlider();
        startSlider();
    });
});

reloadSlider();
startSlider();
