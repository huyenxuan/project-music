document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('myAudio');
    const audioSrc = audio.querySelector('source');
    const repeatButtons = document.querySelectorAll('.btn-repeat');
    const prevButtons = document.querySelectorAll('.btn-prev');
    const nextButtons = document.querySelectorAll('.btn-next');
    const randomButtons = document.querySelectorAll('.btn-random');
    const playPauseButtons = document.querySelectorAll('.toggle-playPause');
    const progressBars = document.querySelectorAll('.progress');
    const timeElements = {
        left: document.querySelectorAll('.time.left'),
        right: document.querySelectorAll('.time.right')
    };
    const volumeControls = document.querySelectorAll('.volume');
    const playerControlImg = document.querySelector('.player-control img');

    let isPlaying = false;
    let isSeeking = false;
    let isRepeating = false;
    let isRandom = false;

    let currentIndex = 0;
    let sidebarSongs = [];

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
                            throw new Error(`Error fetching related songs: ${response.status}`);
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
                                      <div class="song-name"><?php echo '123' ?>${song.song_name}</div>
                                      <div class="author-name"><a href="">${song.author_name}</a></div>
                                    </div>
                                    <button class="boxtestMenuBtn btn-heart"><i class="fa-regular fa-heart"></i></button>
                                    <button class="boxtestMenuBtn btn_menu"><i class="fa-solid fa-ellipsis"></i></button>
                                    <!-- submenu -->
                                    <div class="add-playlist">
                                      <p>Thêm vào playlist:</p>
                                      <ul>
                                        <li>Playlist 1</li>
                                        <li>Playlist 2</li>
                                        <li>Playlist 3</li>
                                      </ul>
                                    </div>
                                </div>`;
                            sidebarContainer.insertAdjacentHTML('beforeend', songItem);
                        });
                        loadSidebarSongs();
                    })
                    .catch(error => {
                        console.error('Error fetching related songs:', error);
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

                        audioSrc.setAttribute('src', firstSongSrc);
                        console.log('hello' + audioSrc);
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
        })
    });

    // khởi chạy album
    var btnAlbum = document.querySelectorAll('.album-box .boxtestMenuBtn');
    btnAlbum.forEach(btnboxTestMenu => {
        btnboxTestMenu.addEventListener('click', () => {
            playerControl.style.bottom = '0';
            const albumItem = btnboxTestMenu.closest('.album-box'); // Find the album box
            if (!albumItem) {
                console.log('Không tìm thấy albumItem');
                return;
            }
            const album_id = albumItem.getAttribute('data-id');
            function fetchRelatedAlbums(album_id) {
                return fetch(`get_related_songs.php?album_id=${album_id}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Error fetching related albums: ${response.status}`);
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
                            <button class="boxtestMenuBtn btn-heart"><i class="fa-regular fa-heart"></i></button>
                            <button class="boxtestMenuBtn btn_menu"><i class="fa-solid fa-ellipsis"></i></button>
                        </div>`;
                            sidebarContainer.insertAdjacentHTML('beforeend', songItem); // Insert new song into sidebar
                        });
                        loadSidebarSongs();
                    })
                    .catch(error => {
                        console.error('Error fetching related albums:', error);
                    });
            }
            fetchRelatedAlbums(album_id)
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

    // khởi chạy playlist
    var btnPlaylist = document.querySelectorAll('.playlist-box .boxtestMenuBtn');
    btnPlaylist.forEach(btnboxTestMenu => {
        btnboxTestMenu.addEventListener('click', () => {
            playerControl.style.bottom = '0';
            const playlistItem = btnboxTestMenu.closest('.playlist-box'); // Find the playlist box
            if (!playlistItem) {
                console.log('Không tìm thấy playlistItem');
                return;
            }
            const playlist_id = playlistItem.getAttribute('data-id');
            function fetchRelatedPlaylists(playlist_id) {
                return fetch(`get_related_songs.php?playlist_id=${playlist_id}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Error fetching related playlists: ${response.status}`);
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
                            <button class="boxtestMenuBtn btn-heart"><i class="fa-regular fa-heart"></i></button>
                            <button class="boxtestMenuBtn btn_menu"><i class="fa-solid fa-ellipsis"></i></button>
                        </div>`;
                            sidebarContainer.insertAdjacentHTML('beforeend', songItem); // Insert new song into sidebar
                        });
                        loadSidebarSongs();
                    })
                    .catch(error => {
                        console.error('Error fetching related albums:', error);
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

    // xử lý phát bài khi chọn ở sidebar
    const sideBar = document.querySelector('.sidebar');
    sideBar.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-play')) {
            const songItem = event.target.closest('.sidebar-song');
            if (!songItem) {
                return;
            }
            document.querySelectorAll('.sidebar-song').forEach(item => {
                item.classList.remove('playing');
            });
            songItem.classList.add('playing');

            // lấy vị trí trong dsach
            currentIndex = Array.from(sidebarSongs).indexOf(songItem);

            const songSrc = songItem.querySelector('audio source');
            const newSongSrc = songSrc.getAttribute('src');
            audioSrc.setAttribute('src', newSongSrc);
            audio.load();
            console.log(audioSrc);

            const newImg = songItem.querySelector('img');
            const newImgSrc = newImg.getAttribute('src');
            playerControlImg.setAttribute('src', newImgSrc);
            songImgFullScreen.setAttribute('src', newImgSrc);

            const newSongName = songItem.querySelector('.song-name');
            songNameControl.innerText = newSongName.textContent;
            songNameFullScreen.innerText = newSongName.textContent;

            const newAuthor = songItem.querySelector('.author-name');
            authorControl.innerText = newAuthor.textContent;
            songArtistsFullScreen.innerText = newAuthor.textContent;

            audio.currentTime = 0;
            audio.play();
            audio.addEventListener('canplaythrough', () => {
                isPlaying = true;
                playPauseButtons.forEach(button => {
                    if (isPlaying === false) {
                        button.classList.remove('fa-pause');
                        button.classList.add('fa-play');
                    } else {
                        button.classList.remove('fa-play');
                        button.classList.add('fa-pause');
                    }
                });
            });
            isPlaying = !isPlaying;
        }
    });

    // Load songs
    function loadSidebarSongs() {
        sidebarSongs = [...document.querySelectorAll('.sidebar .recommend-song')];
    }
    loadSidebarSongs();

    // xử lý nút play/pause
    playPauseButtons.forEach(button => {
        button.addEventListener('click', playPause);
    });
    function playPause() {
        if (isPlaying) {
            audio.pause();
            playPauseButtons.forEach(button => toggleIcon(button, 'fa-play', 'fa-pause'));
        } else {
            audio.play();
            playPauseButtons.forEach(button => toggleIcon(button, 'fa-pause', 'fa-play'));
        }
        isPlaying = !isPlaying;
    }
    document.addEventListener('keydown', (event) => {
        const searchInput = document.getElementById('searchInput');
        if (event.code === 'Space' && searchInput && !searchInput.contains(event.target)) {
            event.preventDefault();
            playPause();
        }
    });
    function toggleIcon(element, class1, class2) {
        if (element.classList.contains(class1)) {
            element.classList.remove(class1);
            element.classList.add(class2);
        } else {
            element.classList.remove(class2);
            element.classList.add(class1);
        }
    }

    // upd thời gian
    audio.addEventListener('timeupdate', () => {
        if (!isSeeking) {
            const progress = (audio.currentTime / audio.duration) * 100;
            progressBars.forEach(bar => bar.value = progress);
            updateDisplayTime();
        }
    });
    function updateDisplayTime() {
        const currentTime = formatTime(audio.currentTime);
        const duration = formatTime(audio.duration);
        timeElements.left.forEach(el => el.textContent = currentTime);
        timeElements.right.forEach(el => el.textContent = duration);
    }
    function formatTime(time) {
        if (isNaN(time)) {
            return '00:00';
        }
        const minutes = Math.floor(time / 60);
        const seconds = Math.floor(time % 60);
        return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    // Xử lý volume
    volumeControls.forEach(volume => {
        volume.addEventListener('input', () => {
            audio.volume = volume.value / 100;
        });
    });

    // xử lý tua bài 
    progressBars.forEach(bar => {
        bar.addEventListener('input', () => {
            isSeeking = true;
            audio.currentTime = (bar.value / 100) * audio.duration;
        });

        bar.addEventListener('change', () => {
            isSeeking = false;
        });
    });

    // xử lý khi hết thời gian bài hát
    audio.addEventListener('ended', () => {
        if (isRepeating) {
            audio.currentTime = 0;
            audio.play();
        } else {
            playNextSong();
        }
    })

    // xử lý lặp bài
    repeatButtons.forEach(button => {
        button.addEventListener('click', () => {
            isRepeating = !isRepeating;
            repeatButtons.forEach(btn => btn.classList.toggle('btnActive', isRepeating));
        });
    });

    // random
    randomButtons.forEach(button => {
        button.addEventListener('click', () => {
            isRandom = !isRandom;
            randomButtons.forEach(btn => btn.classList.toggle('btnActive', isRandom));
        });
    });
    function playRandomSong() {
        currentIndex = Math.floor(Math.random() * sidebarSongs.length);
        playSongAtIndex(currentIndex);
    }

    // prev bài
    prevButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (isRandom) {
                playRandomSong();
            } else {
                playPrevSong();
            }
        });
    });
    function playPrevSong() {
        currentIndex = currentIndex <= 0 ? sidebarSongs.length - 1 : currentIndex - 1;
        playSongAtIndex(currentIndex);
    }

    // next bài
    nextButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (isRandom) {
                playRandomSong();
            } else {
                playNextSong();
            }
        });
    });
    function playNextSong() {
        currentIndex = currentIndex >= sidebarSongs.length - 1 ? 0 : currentIndex + 1;
        playSongAtIndex(currentIndex);
    }

    // phát bài theo index
    function playSongAtIndex(index) {
        sidebarSongs.forEach(songItem => songItem.classList.remove('playing'));
        const songItem = sidebarSongs[index];
        const songSrc = songItem.querySelector('audio source');
        const newSongSrc = songSrc.getAttribute('src');
        audioSrc.setAttribute('src', newSongSrc);
        audio.load();
        songItem.classList.add('playing');

        const newImg = songItem.querySelector('img');
        const newImgSrc = newImg.getAttribute('src');
        playerControlImg.setAttribute('src', newImgSrc);
        songImgFullScreen.setAttribute('src', newImgSrc);

        const newSongName = songItem.querySelector('.song-name');
        songNameControl.innerText = newSongName.textContent;
        songNameFullScreen.innerText = newSongName.textContent;

        const newAuthor = songItem.querySelector('.author-name');
        authorControl.innerText = newAuthor.textContent;
        songArtistsFullScreen.innerText = newAuthor.textContent;

        audio.currentTime = 0;
        audio.play();
        isPlaying = true;

        playPauseButtons.forEach(button => {
            button.classList.remove('fa-play');
            button.classList.add('fa-pause');
        });
    }
});