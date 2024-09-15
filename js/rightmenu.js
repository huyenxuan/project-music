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
    var menu = document.getElementById('menu');
    menu.style.display = 'none';
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