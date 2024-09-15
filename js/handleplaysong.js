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

    const playerControl = document.querySelector('.player-control');
    const songNameControl = playerControl.querySelector('.song-name');
    const authorControl = playerControl.querySelector('.artists');
    const songImgFullScreen = document.querySelector('.fullscreen img');
    const songNameFullScreen = document.querySelector('.fullscreen .name-song');
    const songArtistsFullScreen = document.querySelector('.fullscreen .artists');

    // xử lý phát bài khi chọn ở sidebar
    const sideBar = document.querySelector('.sidebar');
    sideBar.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-play')) {
            const songItem = event.target.closest('.recommend-song');
            if (!songItem) {
                return;
            }
            document.querySelectorAll('.recommend-song').forEach(item => {
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

    // xử lý nút play/pause
    playPauseButtons.forEach(button => {
        button.addEventListener('click', playPause);
    });
    function playPause() {
        if (isPlaying) {
            audio.pause();
            playPauseButtons.forEach(button => {
                button.classList.remove('fa-pause');
                button.classList.add('fa-play');
            });
        } else {
            audio.play();
            playPauseButtons.forEach(button => {
                button.classList.remove('fa-play');
                button.classList.add('fa-pause');
            });
        }
        isPlaying = !isPlaying;
    }
    document.addEventListener('keydown', (event) => {
        const inputs = document.querySelectorAll('input, textarea, select');
        let isInputFocused = false;

        inputs.forEach((input) => {
            if (input.contains(event.target)) {
                isInputFocused = true;
            }
        });

        if (event.code === 'Space' && !isInputFocused) {
            event.preventDefault();
            playPause();
        }
    });

    // hẹn giờ
    const timeInput = document.getElementById('time');
    const startTimerButton = document.getElementById('start-timer');
    let timer;
    if (startTimerButton) {
        startTimerButton.addEventListener('click', () => {
            const minutes = parseInt(timeInput.value);
            if (isNaN(minutes) || minutes <= 0) {
                alert("Vui lòng nhập số phút hợp lệ!");
                return;
            }
            const timeInMilliseconds = minutes * 60 * 1000;
            clearTimeout(timer);
            timer = setTimeout(() => {
                audio.pause();
                playPauseButtons.forEach(button => {
                    button.classList.remove('fa-pause');
                    button.classList.add('fa-play');
                });
                alert("Hết giờ! Nhạc đã dừng.");
                timeInput.innerText = '0';
            }, timeInMilliseconds);

            alert(`Nhạc sẽ dừng sau ${minutes} phút.`);
        });
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