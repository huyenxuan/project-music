const btnPlays = document.querySelectorAll('.btn-play');
const btnPLs = document.querySelectorAll('.btn-pl');
const boxTestMenuBtns = document.querySelectorAll('.btnAlbumPlaylist');
const btnList = document.querySelector('.btn-list');
const sidebar = document.querySelector('.sidebar');
const mainBody = document.querySelector('.mainBody');

if (btnPlays) {
    btnPlays.forEach(btnPlay => {
        btnPlay.addEventListener('click', () => {
            if (!sidebar.classList.contains('is-open')) {
                sidebar.classList.add('is-open');
                sidebar.style.right = '0';
                mainBody.style.paddingBottom = '75px';
            }
        });
    });
}

if (btnPLs) {
    btnPLs.forEach(btnPL => {
        btnPL.addEventListener('click', () => {
            if (!sidebar.classList.contains('is-open')) {
                sidebar.classList.add('is-open');
                sidebar.style.right = '0';
                mainBody.style.paddingBottom = '75px';
            }
        });
    });
}

boxTestMenuBtns.forEach(btnPlay => {
    btnPlay.addEventListener('click', () => {
        if (!sidebar.classList.contains('is-open')) {
            sidebar.classList.add('is-open');
            sidebar.style.right = '0';
            mainBody.style.paddingBottom = '75px';
        }
    });
});
btnList.addEventListener('click', () => {
    if (!sidebar.classList.contains('is-open')) {
        sidebar.classList.add('is-open');
        btnList.classList.add('list');
        sidebar.style.right = '0';
    } else {
        sidebar.classList.remove('is-open');
        btnList.classList.remove('list');
        sidebar.style.right = '-320px';
    }
    console.log(btnList);
});