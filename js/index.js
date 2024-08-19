// slide banner
let list = document.querySelector('.banner .list-banner');
let items = document.querySelectorAll('.banner .item-banner');
let dots = document.querySelectorAll('.banner .dots-banner li');
let prev = document.getElementById('prev');
let next = document.getElementById('next');
let active = 0;
let lengthItems = items.length - 1;
next.onclick = function () {
    if (active + 1 > lengthItems) {
        active = 0;
    }
    else
        active += 1;
    reloadSlider();

}
prev.onclick = function () {
    if (active - 1 < 0)
        active = lengthItems;
    else
        active -= 1;
    reloadSlider();
}
function reloadSlider() {
    let checkLeft = items[active].offsetLeft;
    list.style.left = -checkLeft + 'px';

    let lastActiveDot = document.querySelector('.banner .dots-banner li.active');
    lastActiveDot.classList.remove('active');
    dots[active].classList.add('active');

    clearInterval(refreshSlider);
    refreshSlider = setInterval(() => {
        next.click();
    }, 3000);
}
dots.forEach((li, key) => {
    li.addEventListener('click', function () {
        active = key;
        reloadSlider();
    })
});
let refreshSlider = setInterval(() => {
    next.click();
}, 3000);