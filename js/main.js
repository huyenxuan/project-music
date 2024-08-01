document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('myAudio');

    const repeatButtons = document.querySelectorAll('.btn-repeat');
    const playPauseButtons = document.querySelectorAll('.btn-toggle-play');
    const progressBars = document.querySelectorAll('.progress');
    const leftTimeElements = document.querySelectorAll('.time.left');
    const rightTimeElements = document.querySelectorAll('.time.right');
    const fullscreenButton = document.getElementById('fullscreenButton');
    const fullscreenContent = document.querySelector('.fullscreen');
    const volumeAudio = document.querySelectorAll('.volume');
    let isPlaying = false;
    let isSeeking = false;
    let isRepeating = false;
    // xử lý âm lượng
    volumeAudio.forEach(button => {
        button.addEventListener('input', () => {
            audio.volume = button.value / 100;
        })
    })
    // xử lý repeat 
    repeatButtons.forEach(button => {
        button.addEventListener('click', () => {
            isRepeating = !isRepeating;
            repeatButtons.forEach(btn => btn.classList.toggle('active', isRepeating));
        });
    });
    // xử lý nút phát / tạm dừng
    playPauseButtons.forEach(button => {
        button.addEventListener('click', playPause);
    });
    // phát / tạm dừng
    function playPause() {
        if (isPlaying) {
            audio.pause();
        } else {
            audio.play();
        }
        isPlaying = !isPlaying;
        playPauseButtons.forEach(button => toggleClassName(button.querySelector('i'), 'fa-play', 'fa-pause'));
    }
    // thanh tiến trình nhạc
    progressBars.forEach(bar => {
        bar.addEventListener('mousedown', () => isSeeking = true);
        bar.addEventListener('mouseup', (e) => {
            isSeeking = false;
            const newTime = (e.target.value / 100) * audio.duration;
            audio.currentTime = newTime;
        });
    });
    // cập nhật thời gian
    audio.addEventListener('timeupdate', () => {
        if (!isSeeking) {
            const percentage = (audio.currentTime / audio.duration) * 100;
            progressBars.forEach(bar => bar.value = percentage);
        }
        updateDisplayTime();
    });
    // hiển thị thời gian
    function updateDisplayTime() {
        const currentTime = Math.floor(audio.currentTime);
        const duration = Math.floor(audio.duration);
        const currentMinutes = Math.floor(currentTime / 60);
        const currentSeconds = currentTime % 60;
        const durationMinutes = Math.floor(duration / 60);
        const durationSeconds = duration % 60;

        leftTimeElements.forEach(el => el.textContent = `${currentMinutes.toString().padStart(2, '0')}:${currentSeconds.toString().padStart(2, '0')}`);
        rightTimeElements.forEach(el => el.textContent = `${durationMinutes.toString().padStart(2, '0')}:${durationSeconds.toString().padStart(2, '0')}`);
    }
    // thay đổi tên class
    function toggleClassName(element, class1, class2) {
        if (element.classList.contains(class1)) {
            element.classList.remove(class1);
            element.classList.add(class2);
        } else {
            element.classList.remove(class2);
            element.classList.add(class1);
        }
    }
    // xử lý khi hết bài
    audio.addEventListener('ended', () => {
        if (isRepeating) {
            audio.currentTime = 0;
            audio.play();
        } else {
            toggleClassName(togglePlayPause, 'fa-pause', 'fa-play');
            isPlaying = false;
        }

    });

    // Thêm sự kiện keydown để phát/tạm dừng bài hát khi nhấn phím Space
    document.addEventListener('keydown', (event) => {
        if (event.code === 'Space') {
            event.preventDefault(); // Ngăn chặn hành động mặc định của phím Space
            playPause();
        }
    });

    // Fullscreen functionality
    function enterFullscreen() {
        if (fullscreenContent.requestFullscreen) {
            fullscreenContent.requestFullscreen();
        } else if (fullscreenContent.mozRequestFullScreen) { // Firefox
            fullscreenContent.mozRequestFullScreen();
        } else if (fullscreenContent.webkitRequestFullscreen) { // Chrome, Safari and Opera
            fullscreenContent.webkitRequestFullscreen();
        } else if (fullscreenContent.msRequestFullscreen) { // IE/Edge
            fullscreenContent.msRequestFullscreen();
        }
        fullscreenContent.classList.add('show');
        fullscreenButton.style.display = 'none';
    }

    function exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) { // Firefox
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) { // Chrome, Safari and Opera
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { // IE/Edge
            document.msExitFullscreen();
        }
        fullscreenContent.classList.remove('show');
        fullscreenButton.style.display = 'block';
    }

    document.addEventListener('fullscreenchange', checkFullscreen);
    document.addEventListener('webkitfullscreenchange', checkFullscreen);
    document.addEventListener('mozfullscreenchange', checkFullscreen);
    document.addEventListener('msfullscreenchange', checkFullscreen);

    function checkFullscreen() {
        if (!document.fullscreenElement && !document.webkitFullscreenElement && !document.mozFullScreenElement && !document.msFullscreenElement) {
            exitFullscreen();
        }
    }

    fullscreenButton.addEventListener('click', enterFullscreen);
});
