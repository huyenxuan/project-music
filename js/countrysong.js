function filterList() {
    const input = document.querySelector('.search-bar-container #searchInput');
    const filter = input.value.toLowerCase();
    const items = document.querySelectorAll('#itemList .recommend-song');

    items.forEach((item) => {
        const songName = item.querySelector('.song-name').textContent.toLowerCase();
        const authorName = item.querySelector('.author-name').textContent.toLowerCase();

        if (songName.indexOf(filter) > -1 || authorName.indexOf(filter) > -1) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}
