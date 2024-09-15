function openTab(evt, tabName) {
    var tabContent = document.getElementsByClassName('tab-content');
    for (var i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = 'none';
    }

    var tabLink = document.getElementsByClassName('tab-link');
    for (var i = 0; i < tabLink.length; i++) {
        tabLink[i].className = tabLink[i].className.replace('active', '');
    }

    document.getElementById(tabName).style.display = 'block';
    evt.currentTarget.className += ' active';
}
document.getElementsByClassName('tab-link')[0].click();

function libTab(evt, tabName) {
    var tabContent = document.getElementsByClassName('lib-tab-content');
    for (var i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = 'none';
    }

    var tabLink = document.getElementsByClassName('lib-tab-btn');
    for (var i = 0; i < tabLink.length; i++) {
        tabLink[i].className = tabLink[i].className.replace('active', '');
    }

    document.getElementById(tabName).style.display = 'block';
    evt.currentTarget.className += ' active';
}
document.getElementsByClassName('lib-tab-btn')[0].click();

//follow btn
var btnFollow = document.getElementById('btnFollow');
btnFollow.addEventListener('click', () => {

})
function follow() {
    var btnFollow = document.getElementById('btnFollow');

    if (btnFollow.classList.contains('active')) {
        btnFollow.textContent = 'Theo dõi';
        btnFollow.classList.remove('active');
        btnFollow.querySelector('i').classList.remove('fa-check');
    } else {
        btnFollow.textContent = 'Đã theo dõi';
        btnFollow.classList.add('active');
        btnFollow.querySelector('i').classList.add('fa-check');
    }
}

//backHome btn
function backHome() {
    window.location.href = 'index.php';
}

