document.addEventListener('DOMContentLoaded', () => {
    console.log(123);
    const audio = document.getElementById('myAudio');
    const audioSrc = audio.querySelector('source');
    const repeatButtons = document.querySelectorAll('.btn-repeat');
    const playPauseButtons = document.querySelectorAll('.toggle-playPause');
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

    var playerControl = document.querySelector('.player-control');
    var songNameControl = playerControl.querySelector('.song-name');
    var authorControl = playerControl.querySelector('.artists');
    var songImgFullScreen = document.querySelector('.fullscreen img');
    var songNameFullScreen = document.querySelector('.fullscreen .name-song');
    var songArtistsFullScreen = document.querySelector('.fullscreen .artists');
    var lyricsFullScreen = document.querySelector('.fullscreen .lyrics');
    var btnPlays = document.querySelectorAll('.recommend-song .btn-play');

    var songSidebar = document.querySelector('.recommend-song1');
    var songNameSidebar = songSidebar.querySelector('.song-name');
    var authorNameSidebar = songSidebar.querySelector('.author-name');
    var songImgSidebar = songSidebar.querySelector('img');
    var songSrcSidebar = songSidebar.querySelector('audio source');

    btnPlays.forEach(btnPlay => {
        btnPlay.addEventListener('click', () => {
            playerControl.style.bottom = '0';
            const songItem = btnPlay.closest('.recommend-song');

            const dataId = songItem.getAttribute('data-id');
            songSidebar.setAttribute('data-id', dataId);

            console.log(dataId);

            const songSrc = songItem.querySelector('audio source');
            const newSongSrc = songSrc.getAttribute('src');
            audioSrc.setAttribute('src', newSongSrc);
            songSrcSidebar.setAttribute('src', newSongSrc);
            audio.load();
            console.log(audioSrc);

            const newImg = songItem.querySelector('.recommend-song img');
            const newImgSrc = newImg.getAttribute('src');
            playerControlImg.setAttribute('src', newImgSrc);
            songImgFullScreen.setAttribute('src', newImgSrc);
            songImgSidebar.setAttribute('src', newImgSrc);

            const newSongName = songItem.querySelector('.recommend-song .song-name');
            songNameControl.innerText = newSongName.textContent;
            songNameFullScreen.innerText = newSongName.textContent;
            songNameSidebar.innerText = newSongName.textContent;

            const newAuthor = songItem.querySelector('.recommend-song .author-name');
            authorControl.innerText = newAuthor.textContent;
            songArtistsFullScreen.innerText = newAuthor.textContent;
            authorNameSidebar.innerText = newAuthor.textContent;

            // const newLyrics = songItem.querySelector('.recommend-song .song-lyrics');
            // lyricsFullScreen.innerText = newLyrics.textContent;

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

            // Gọi hàm AJAX để truyền songId đến PHP
            if (!dataId) {
                console.error('No data-id found on the song item.');
                return;
            }

            // Send song_id to PHP via AJAX
            fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'song_id': dataId
                })
            })
                .then(response => response.text())
                .then(data => {
                    console.log('Sending song_id:', dataId);

                    //console.log(data); // Check what data PHP returns
                })
                .catch(error => console.error('Error:', error));
        })
    })

    playPauseButtons.forEach(button => {
        button.addEventListener('click', playPause);
    });

    function playPause() {
        if (isPlaying !== false) {
            audio.pause();
            playPauseButtons.forEach(button => toggleIcon(button, 'fa-play', 'fa-pause'));
        } else {
            audio.play();
            playPauseButtons.forEach(button => toggleIcon(button, 'fa-pause', 'fa-play'));
        }
        isPlaying = !isPlaying;
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
            // playPause();
            playPauseButtons.forEach(button => toggleIcon(button, 'fa-pause', 'fa-play'));
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
            event.preventDefault();
            playPause();
        }
    });

    progressBars.forEach(bar => {
        bar.addEventListener('mousedown', () => isSeeking = true);
        bar.addEventListener('mouseup', (e) => {
            isSeeking = false;
            const newTime = (e.target.value / 100) * audio.duration;
            audio.currentTime = newTime;
            console.log(isSeeking);
        });
    });
});
