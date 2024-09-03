// slide banner
let list = document.querySelector('.banner .list-banner');
let items = document.querySelectorAll('.banner .item-banner');
let dots = document.querySelectorAll('.banner .dots-banner li');
let active = 0;
let lengthItems = items.length - 1;
let refreshSlider;
// set chiều rộng của banner theo số phần tử
list.style.width = list.children.length * 100 + '%';
function reloadSlider() {
    let checkLeft = items[active].offsetLeft;
    list.style.left = -checkLeft + 'px';

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

// btn add playlist
document.querySelectorAll('.btn_menu').forEach(button => {
    button.addEventListener('click', function (event) {
        event.stopPropagation();
        document.querySelectorAll('.add-playlist').forEach(box => {
            if (box !== this.nextElementSibling) {
                box.style.display = 'none';
            }
        });

        const addPlaylist = this.nextElementSibling;
        if (addPlaylist.style.display === 'block') {
            addPlaylist.style.display = 'none';
        } else {
            addPlaylist.style.display = 'block';
        }
    });
});

// Đóng hộp khi nhấp ra ngoài nó
document.addEventListener('click', function (event) {
    if (!event.target.closest('.btn_menu') && !event.target.closest('.add-playlist')) {
        document.querySelectorAll('.add-playlist').forEach(box => {
            box.style.display = 'none';
        });
    }
});

//right-click menu
document.addEventListener('contextmenu', function (event) {
    event.preventDefault();
    var menu = document.getElementById('custom-menu');
    menu.style.display = 'block';
    menu.style.left = event.pageX + 'px';
    menu.style.top = event.pageY + 'px';
});

document.addEventListener('click', function (event) {
    var menu = document.getElementById('custom-menu');
    if (event.button !== 2) { // Hide menu on left click
        menu.style.display = 'none';
    }
});

document.addEventListener('scroll', function () {
    var menu = document.getElementById('custom-menu');
    menu.style.display = 'none'; // Hide menu when scroll
});

function menuAction(action) {
    switch (action) {
        case 'Action 1':
            window.history.back();
            break;
        case 'Action 2':
            window.history.forward();
            break;
        case 'Action 3':
            location.reload();
            break;
        case 'Action 4':
            window.location.href = 'Discovery.html';
            break;
        case 'Action 5':
            window.location.href = 'Library.html';
            break;
    }
};