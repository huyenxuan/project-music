document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('myAudio');
    const audioSrc = audio.querySelector('source');
    const repeatButtons = document.querySelectorAll('.btn-repeat');
    const playPauseButtons = document.querySelectorAll('.btn-toggle-play');
    const progressBars = document.querySelectorAll('.progress');
    const timeElements = {
        left: document.querySelectorAll('.time.left'),
        right: document.querySelectorAll('.time.right')
    };
    const volumeControls = document.querySelectorAll('.volume');
    const playerControlImg = document.querySelector('.player-control img')

    let isPlaying = false;
    let isSeeking = false;
    let isRepeating = false;

    var songNameControl = document.querySelector('.player-control .song-name');
    var authorControl = document.querySelector('.player-control .artists');
    var songImgFullScreen = document.querySelector('.fullscreen img');
    var songNameFullScreen = document.querySelector('.fullscreen .name-song');
    var songArtistsFullScreen = document.querySelector('.fullscreen .artists');
    var lyricsFullScreen = document.querySelector('.fullscreen .lyrics');
    var btnPlays = document.querySelectorAll('.recommend-song .btn-play');

    btnPlays.forEach(btnPlay => {
        btnPlay.addEventListener('click', () => {
            const songItem = btnPlay.closest('.recommend-song');

            const songSrc = songItem.querySelector('audio source');
            const newSongSrc = songSrc.getAttribute('src');
            audioSrc.setAttribute('src', newSongSrc);
            console.log(audioSrc);

            const newImg = songItem.querySelector('.recommend-song img');
            const newImgSrc = newImg.getAttribute('src');
            playerControlImg.setAttribute('src', newImgSrc);
            songImgFullScreen.setAttribute('src', newImgSrc);

            const newSongName = songItem.querySelector('.recommend-song .song-name');
            songNameControl.innerText = newSongName.textContent;
            songNameFullScreen.innerText = newSongName.textContent;

            const newAuthor = songItem.querySelector('.recommend-song .author-name');
            authorControl.innerText = newAuthor.textContent;
            songArtistsFullScreen.innerText = newAuthor.textContent;

            const newLyrics = songItem.querySelector('.recommend-song .song-lyrics');
            lyricsFullScreen.innerText = newLyrics.textContent;

            audio.addEventListener('canplaythrough', () => {
                if (!isPlaying) {
                    playPause();
                }
            });

            audio.load();
            audio.play();
        })
    })

    playPauseButtons.forEach(button => {
        button.addEventListener('click', playPause);
    });

    function playPause() {
        if (isPlaying) {
            audio.pause();
            playPauseButtons.forEach(button => toggleIcon(button.querySelector('i'), 'fa-play', 'fa-pause'));
        } else {
            audio.play();
            playPauseButtons.forEach(button => toggleIcon(button.querySelector('i'), 'fa-pause', 'fa-play'));
        }
        isPlaying = !isPlaying;
        localStorage.setItem('audioIsPlaying', isPlaying);
    }


    function toggleIcon(element, class1, class2) {
        if (element.classList.contains(class1)) {
            element.classList.remove(class1);
            element.classList.add(class2);
        } else {
            element.classList.remove(class2);
            element.classList.add(class1);
        }
    }


    audio.addEventListener('timeupdate', () => {
        if (!isSeeking) {
            const progress = (audio.currentTime / audio.duration) * 100;
            progressBars.forEach(bar => bar.value = progress);
            updateDisplayTime();
        }
        localStorage.setItem('audioCurrentTime', audio.currentTime);
    });

    function updateDisplayTime() {
        const currentTime = formatTime(audio.currentTime);
        const duration = formatTime(audio.duration);

        timeElements.left.forEach(el => el.textContent = currentTime);
        timeElements.right.forEach(el => el.textContent = duration);
    }

    function formatTime(time) {
        const minutes = Math.floor(time / 60);
        const seconds = Math.floor(time % 60);
        return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    // Xử lý func lặp
    repeatButtons.forEach(button => {
        button.addEventListener('click', () => {
            isRepeating = !isRepeating;
            repeatButtons.forEach(btn => btn.classList.toggle('active', isRepeating));
        });
    });

    // Xử lý khi chạy hết bài
    audio.addEventListener('ended', () => {
        if (isRepeating) {
            audio.currentTime = 0;
            audio.play();
        } else {
            isPlaying = false;
            playPauseButtons.forEach(button => toggleIcon(button.querySelector('i'), 'fa-pause', 'fa-play'));
        }
    });

    volumeControls.forEach(control => {
        control.addEventListener('input', () => {
            audio.volume = control.value / 100;
        });
    });

    document.addEventListener('keydown', (event) => {
        const searchInput = document.getElementById('searchInput');

        if (event.code === 'Space' && searchInput && !searchInput.contains(event.target)) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định (cuộn trang)
            playPause();
        }
    });

    const savedCurrentTime = localStorage.getItem('audioCurrentTime');
    const savedIsPlaying = localStorage.getItem('audioIsPlaying') === 'true';

    if (savedCurrentTime !== null) {
        audio.currentTime = parseFloat(savedCurrentTime);
    }

    if (savedIsPlaying) {
        audio.play();
        isPlaying = true;
        togglePlayPauseIcons();
    }

    progressBars.forEach(bar => {
        bar.addEventListener('mousedown', () => isSeeking = true);
        bar.addEventListener('mouseup', (e) => {
            isSeeking = false;
            const newTime = (e.target.value / 100) * audio.duration;
            audio.currentTime = newTime;
            localStorage.setItem('audioCurrentTime', newTime);
        });
    });
});