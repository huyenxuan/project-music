document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('myAudio');
    const repeatButtons = document.querySelectorAll('.btn-repeat');
    const playPauseButtons = document.querySelectorAll('.btn-toggle-play');
    const progressBars = document.querySelectorAll('.progress');
    const leftTimeElements = document.querySelectorAll('.time.left');
    const rightTimeElements = document.querySelectorAll('.time.right');
    const volumeControls = document.querySelectorAll('.volume');

    let isPlaying = false;
    let isSeeking = false;
    let isRepeating = false;

    const bai2 = document.querySelector('.song-item-ctn');
    const audioClickSource = document.querySelector('.audioClick source');
    const myAudioSource = audio.querySelector('source');
    const songName = document.querySelector('.song-name');
    const songArtists = document.querySelector('.artists');
    const songImg = document.querySelector('.song-img img');
    const songNameItem = document.querySelector('.song-item-name');
    const songArtistsItem = document.querySelector('.song-item-artists');
    const songImgItem = document.querySelector('.song-item-img img');

    // Add click event to bai2 to change the audio source
    bai2.addEventListener('click', () => {
        audio.pause();

        const newSrcAudio = audioClickSource.getAttribute('src');
        const newSrcImg = songImgItem.getAttribute('src');

        myAudioSource.setAttribute('src', newSrcAudio);
        songImg.setAttribute('src', newSrcImg);
        audio.load();
        audio.currentTime = 0;
        audio.duration = 0;
        songName.innerText = songNameItem.textContent;
        songArtists.innerText = songArtistsItem.textContent;

        audio.addEventListener('canplaythrough', () => {
            if (!isPlaying) {
                playPause();
            }
        });
        audio.play();
    });

    // Handle the play/pause button
    playPauseButtons.forEach(button => {
        button.addEventListener('click', playPause);
    });

    function playPause() {
        if (isPlaying) {
            audio.pause();
            playPauseButtons.forEach(button => toggleIcon(button.querySelector('i'), 'fa-pause', 'fa-play'));
        } else {
            audio.play();
            playPauseButtons.forEach(button => toggleIcon(button.querySelector('i'), 'fa-play', 'fa-pause'));
        }
        isPlaying = !isPlaying;
        localStorage.setItem('audioIsPlaying', isPlaying);
    }

    // Update progress bar and time display
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

        leftTimeElements.forEach(el => el.textContent = currentTime);
        rightTimeElements.forEach(el => el.textContent = duration);
    }

    function formatTime(time) {
        const minutes = Math.floor(time / 60);
        const seconds = Math.floor(time % 60);
        return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    // Toggle icon class
    function toggleIcon(element, class1, class2) {
        if (element.classList.contains(class1)) {
            element.classList.remove(class1);
            element.classList.add(class2);
        } else {
            element.classList.remove(class2);
            element.classList.add(class1);
        }
    }

    // Handle repeat button
    repeatButtons.forEach(button => {
        button.addEventListener('click', () => {
            isRepeating = !isRepeating;
            repeatButtons.forEach(btn => btn.classList.toggle('active', isRepeating));
        });
    });

    // Handle audio end event
    audio.addEventListener('ended', () => {
        if (isRepeating) {
            audio.currentTime = 0;
            audio.play();
        } else {
            isPlaying = false;
            playPauseButtons.forEach(button => toggleIcon(button.querySelector('i'), 'fa-pause', 'fa-play'));
        }
    });

    // Handle volume control
    volumeControls.forEach(control => {
        control.addEventListener('input', () => {
            audio.volume = control.value / 100;
        });
    });

    // Handle spacebar to play/pause
    document.addEventListener('keydown', (event) => {
        if (event.code === 'Space') {
            event.preventDefault();
            playPause();
        }
    });

    // Save and restore audio state
    const savedCurrentTime = localStorage.getItem('audioCurrentTime');
    const savedIsPlaying = localStorage.getItem('audioIsPlaying') === 'true';

    if (savedCurrentTime !== null) {
        audio.currentTime = parseFloat(savedCurrentTime);
    }

    if (savedIsPlaying) {
        audio.play();
        isPlaying = true;
        playPauseButtons.forEach(button => toggleIcon(button.querySelector('i'), 'fa-play', 'fa-pause'));
    }

    // Handle progress bar seeking
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
