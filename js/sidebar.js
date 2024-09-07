const btnPlays = document.querySelectorAll('.btn-play');
const boxTestMenuBtns = document.querySelectorAll('.btnAbumPlaylist');
const btnList = document.querySelector('.btn-list');
const sidebar = document.querySelector('.sidebar');

btnPlays.forEach(btnPlay => {
    btnPlay.addEventListener('click', () => {
        if (!sidebar.classList.contains('is-open')) {
            sidebar.classList.add('is-open');
            sidebar.style.right = '0';
        }
    });
});
boxTestMenuBtns.forEach(btnPlay => {
    btnPlay.addEventListener('click', () => {
        if (!sidebar.classList.contains('is-open')) {
            sidebar.classList.add('is-open');
            sidebar.style.right = '0';
        }
    });
});
btnList.addEventListener('click', () => {
    if (!sidebar.classList.contains('is-open')) {
        sidebar.classList.add('is-open');
        btnList.classList.add('.list');
        sidebar.style.right = '0';
    } else {
        sidebar.classList.remove('is-open');
        btnList.classList.remove('.list');
        sidebar.style.right = '-320px';
    }
    console.log(btnList);
});