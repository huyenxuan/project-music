document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('myAudio');
    const audioSrc = audio.querySelector('source');
    const playPauseButtons = document.querySelectorAll('.toggle-playPause');
    const playerControlImg = document.querySelector('.player-control img');

    const playerControl = document.querySelector('.player-control');
    const songNameControl = playerControl.querySelector('.song-name');
    const authorControl = playerControl.querySelector('.artists');
    const songImgFullScreen = document.querySelector('.fullscreen img');
    const songNameFullScreen = document.querySelector('.fullscreen .name-song');
    const songArtistsFullScreen = document.querySelector('.fullscreen .artists');
    const btnPlays = document.querySelectorAll('.recommend-song .btn-play');
    // xử lý nút khởi chạy bài hát
    btnPlays.forEach(btnPlay => {
        btnPlay.addEventListener('click', () => {
            playerControl.style.bottom = '0';
            const songItem = btnPlay.closest('.recommend-song');
            if (!songItem) {
                console.log('Không tìm thấy songItem');
                return;
            }
            const dataId = songItem.getAttribute('data-id');
            console.log(dataId);
            function fetchRelatedSongs(songId) {
                return fetch(`get_related_songs.php?song_id=${songId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Lỗi tìm bài hát cùng thể loại: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        const sidebarContainer = document.querySelector('.sidebar-container');
                        sidebarContainer.innerHTML = '';
                        data.forEach(song => {
                            const songItem = `
                                <div class="recommend-song sidebar-song" data-id="${song.song_id}">
                                    <audio hidden>
                                      <source src="admin/upload/song/${song.filePath}">
                                    </audio>
                                    <div class="recommend-cover">
                                      <img src="admin/upload/images/imagesong/${song.song_image}" alt="${song.song_name}">
                                      <div class="cover-overlay">
                                        <button class="btn-play"><i class="fa-solid fa-play"></i></button>
                                      </div>
                                    </div>
                                    <div class="recommend-name">
                                      <div class="song-name">${song.song_name}</div>
                                      <div class="author-name"><a href="">${song.author_name}</a></div>
                                    </div>
                                    <button class="boxtestMenuBtn btn-heart"><i class="${song.is_favorited ? 'fa-solid fa-heart' : 'fa-regular fa-heart'}"></i></button>
                                </div>`;
                            sidebarContainer.insertAdjacentHTML('beforeend', songItem);
                        });
                        loadSidebarSongs();
                    })
                    .catch(error => {
                        console.error('Lỗi tìm bài hát cùng thể loại:', error);
                    });
            }
            fetchRelatedSongs(dataId)
                .then(() => {
                    const firstSongInSidebar = document.querySelector('.sidebar-container .recommend-song:first-child');
                    if (firstSongInSidebar) {
                        firstSongInSidebar.classList.add('playing');
                        const firstSongSrc = firstSongInSidebar.querySelector('audio source').getAttribute('src');
                        const firstSongImg = firstSongInSidebar.querySelector('img').getAttribute('src');
                        const firstSongName = firstSongInSidebar.querySelector('.song-name').textContent;
                        const firstSongAuthor = firstSongInSidebar.querySelector('.author-name').textContent;
                        const firstDataId = firstSongInSidebar.getAttribute('data-id')

                        audioSrc.setAttribute('src', firstSongSrc);
                        audio.load();
                        audio.play();

                        playerControl.setAttribute('data-id', firstDataId);
                        playerControlImg.setAttribute('src', firstSongImg);
                        songImgFullScreen.setAttribute('src', firstSongImg);
                        songNameControl.innerText = firstSongName;
                        songNameFullScreen.innerText = firstSongName;
                        authorControl.innerText = firstSongAuthor;
                        songArtistsFullScreen.innerText = firstSongAuthor;

                        isPlaying = true;
                        playPauseButtons.forEach(button => {
                            button.classList.remove('fa-play');
                            button.classList.add('fa-pause');
                        });
                    }
                });
        })
    });

    // Khởi chạy album
    var btnAlbums = document.querySelectorAll('.album-box .btnAlbumPlaylist');
    btnAlbums.forEach(btnboxTestMenu => {
        btnboxTestMenu.addEventListener('click', () => {
            playerControl.style.bottom = '0';
            const albumItem = btnboxTestMenu.closest('.album-box');
            console.log(albumItem);
            if (!albumItem) {
                console.log('Không tìm thấy albumItem');
                return;
            }
            const album_id = albumItem.getAttribute('data-id');
            console.log(album_id);

            // Hàm lấy bài hát liên quan từ album hoặc danh sách yêu thích
            function fetchRelatedAlbums(album_id) {
                const url = album_id === '0' ? 'get_favorite.php' : `get_related_songs.php?album_id=${album_id}`;
                return fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Lỗi lấy nhạc: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        const sidebarContainer = document.querySelector('.sidebar-container');
                        sidebarContainer.innerHTML = '';

                        // Chèn bài hát mới vào sidebar
                        data.forEach(song => {
                            const songItem = `
                        <div class="recommend-song sidebar-song" data-id="${song.song_id}">
                            <audio hidden>
                                <source src="admin/upload/song/${song.filePath}">
                            </audio>
                            <div class="recommend-cover">
                                <img src="admin/upload/images/imagesong/${song.song_image}" alt="${song.song_name}">
                                <div class="cover-overlay">
                                    <button class="btn-play"><i class="fa-solid fa-play"></i></button>
                                </div>
                            </div>
                            <div class="recommend-name">
                                <div class="song-name">${song.song_name}</div>
                                <div class="author-name"><a href="">${song.author_name}</a></div>
                            </div>
                            <button class="boxtestMenuBtn btn-heart"><i class="${song.is_favorited ? 'fa-solid fa-heart' : 'fa-regular fa-heart'}></i></button>
                        </div>`;
                            sidebarContainer.insertAdjacentHTML('beforeend', songItem);
                        });

                        loadSidebarSongs();
                    })
                    .catch(error => {
                        console.error('Lỗi lấy nhạc:', error);
                    });
            }

            // Gọi hàm fetch dữ liệu
            fetchRelatedAlbums(album_id)
                .then(() => {
                    // Tự động phát bài hát đầu tiên trong sidebar
                    const firstSongInSidebar = document.querySelector('.sidebar-container .recommend-song:first-child');
                    if (firstSongInSidebar) {
                        firstSongInSidebar.classList.add('playing');
                        const firstSongSrc = firstSongInSidebar.querySelector('audio source').getAttribute('src');
                        const firstSongImg = firstSongInSidebar.querySelector('img').getAttribute('src');
                        const firstSongName = firstSongInSidebar.querySelector('.song-name').textContent;
                        const firstSongAuthor = firstSongInSidebar.querySelector('.author-name').textContent;

                        // Cập nhật giao diện phát nhạc
                        audioSrc.setAttribute('src', firstSongSrc);
                        audio.load();
                        audio.play();

                        playerControlImg.setAttribute('src', firstSongImg);
                        songImgFullScreen.setAttribute('src', firstSongImg);
                        songNameControl.innerText = firstSongName;
                        songNameFullScreen.innerText = firstSongName;
                        authorControl.innerText = firstSongAuthor;
                        songArtistsFullScreen.innerText = firstSongAuthor;

                        isPlaying = true;
                        playPauseButtons.forEach(button => {
                            button.classList.remove('fa-play');
                            button.classList.add('fa-pause');
                        });
                    }
                });
        });
    });

    // khởi chạy playlist
    var btnPlaylists = document.querySelectorAll('.playlist-box .btnAlbumPlaylist');
    btnPlaylists.forEach(btnboxTestMenu => {
        btnboxTestMenu.addEventListener('click', () => {
            playerControl.style.bottom = '0';
            const playlistItem = btnboxTestMenu.closest('.playlist-box'); // Find the playlist box
            if (!playlistItem) {
                console.log('Không tìm thấy playlistItem');
                return;
            }
            const playlist_id = playlistItem.getAttribute('data-id');
            function fetchRelatedPlaylists(playlist_id) {
                return fetch(`get_related_songs.php?playlist_id=${playlist_id} `)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Lỗi lấy nhạc: ${response.status} `);
                        }
                        return response.json();
                    })
                    .then(data => {
                        const sidebarContainer = document.querySelector('.sidebar-container');
                        sidebarContainer.innerHTML = '';
                        data.forEach(song => {
                            const songItem = `
                    <div class="recommend-song sidebar-song" data-id="${song.song_id}" >
                            <audio hidden>
                                <source src="admin/upload/song/${song.filePath}">
                            </audio>
                            <div class="recommend-cover">
                                <img src="admin/upload/images/imagesong/${song.song_image}" alt="${song.song_name}">
                                <div class="cover-overlay">
                                    <button class="btn-play"><i class="fa-solid fa-play"></i></button>
                                </div>
                            </div>
                            <div class="recommend-name">
                                <div class="song-name">${song.song_name}</div>
                                <div class="author-name"><a href="">${song.author_name}</a></div>
                            </div>
                            <button class="boxtestMenuBtn btn-heart"><i class="${song.is_favorited ? 'fa-solid fa-heart' : 'fa-regular fa-heart'}"></i></button>
                        </div> `;
                            sidebarContainer.insertAdjacentHTML('beforeend', songItem); // Insert new song into sidebar
                        });
                        loadSidebarSongs();
                    })
                    .catch(error => {
                        console.error('Lỗi lấy nhạc:', error);
                    });
            }
            fetchRelatedPlaylists(playlist_id)
                .then(() => {
                    const firstSongInSidebar = document.querySelector('.sidebar-container .recommend-song:first-child');
                    if (firstSongInSidebar) {
                        firstSongInSidebar.classList.add('playing');
                        const firstSongSrc = firstSongInSidebar.querySelector('audio source').getAttribute('src');
                        const firstSongImg = firstSongInSidebar.querySelector('img').getAttribute('src');
                        const firstSongName = firstSongInSidebar.querySelector('.song-name').textContent;
                        const firstSongAuthor = firstSongInSidebar.querySelector('.author-name').textContent;

                        audioSrc.setAttribute('src', firstSongSrc);
                        audio.load();
                        audio.play();

                        playerControlImg.setAttribute('src', firstSongImg);
                        songImgFullScreen.setAttribute('src', firstSongImg);
                        songNameControl.innerText = firstSongName;
                        songNameFullScreen.innerText = firstSongName;
                        authorControl.innerText = firstSongAuthor;
                        songArtistsFullScreen.innerText = firstSongAuthor;

                        isPlaying = true;
                        playPauseButtons.forEach(button => {
                            button.classList.remove('fa-play');
                            button.classList.add('fa-pause');
                        });
                    }
                });
        });
    });
    // Load songs
    function loadSidebarSongs() {
        sidebarSongs = [...document.querySelectorAll('.sidebar .recommend-song')];
        console.log(sidebarSongs);
    }
});