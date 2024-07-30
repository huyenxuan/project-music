// khai báo
const audio = document.getElementById('myAudio');
const togglePlayPause = document.querySelector('.toggle-playPause');
const progress = document.getElementById('progress');
const repeatButton = document.querySelector('.btn-repeat');
const content = document.querySelector('.fullscreen');
const fullscreenButton = document.getElementById('fullscreenButton');
const leftTime = document.querySelector('.time.left');
const rightTime = document.querySelector('.time.right');
let isPlaying = false;
let isSeeking = false;
let isRepeating = false;


// func ẩn hiện classname
function toggleClassName(obj, classOld, classNew) {
    obj.className = obj.className.replace(classOld, classNew);
}

// ẩn hiện yêu thích
const toggleHeart = document.querySelector('.toggle-heart');
toggleHeart.addEventListener('click', () => {
    toggleClassName(toggleHeart, 'fa-regular fa-heart', 'fa-solid fa-heart');
});

// func play / pause nhạc
function playPause() {
    if (isPlaying) {
        audio.pause();
        toggleClassName(togglePlayPause, 'fa-pause', 'fa-play');
    } else {
        audio.play();
        toggleClassName(togglePlayPause, 'fa-play', 'fa-pause');
    }
    isPlaying = !isPlaying;
}

// thay đổi icon play / pause
togglePlayPause.addEventListener('click', playPause);
document.addEventListener('keydown', (event) => {
    if (event.code === 'Space') {
        event.preventDefault();
        playPause();
    }
});

// lưu tiến trình nhạc
function saveState() {
    localStorage.setItem('isPlaying', isPlaying);
    localStorage.setItem('currentTime', audio.currentTime);
}
// lấy tiến trình nhạc
function restoreState() {
    const savedIsPlaying = localStorage.getItem('isPlaying');
    const savedCurrentTime = localStorage.getItem('currentTime');
    if (savedIsPlaying === 'true') {
        audio.play();
        audio.currentTime = savedCurrentTime;
        toggleClassName(togglePlayPause, 'fa-play', 'fa-pause');
    }
    isPlaying = savedIsPlaying === 'true';
}

window.onbeforeunload = saveState;
window.onload = restoreState;

// cập nhật tiến trình 
audio.addEventListener('timeupdate', () => {
    if (!isSeeking) {
        const percentage = (audio.currentTime / audio.duration) * 100;
        progress.value = percentage;
    }
    updateDisplayTime();
});

// cập nhật tgian
function updateDisplayTime() {
    const currentTime = Math.floor(audio.currentTime);
    const duration = Math.floor(audio.duration);
    const currentMinutes = Math.floor(currentTime / 60);
    const currentSeconds = currentTime % 60;
    const durationMinutes = Math.floor(duration / 60);
    const durationSeconds = duration % 60;

    leftTime.textContent = `${currentMinutes.toString().padStart(2, '0')}:${currentSeconds.toString().padStart(2, '0')}`;
    rightTime.textContent = `${durationMinutes.toString().padStart(2, '0')}:${durationSeconds.toString().padStart(2, '0')}`;
}

// tua nhạc
progress.addEventListener('mousedown', () => {
    isSeeking = true;
});
progress.addEventListener('mouseup', (e) => {
    isSeeking = false;
    const newTime = (e.target.value / 100) * audio.duration;
    audio.currentTime = newTime;
});

// lặp bài
repeatButton.addEventListener('click', () => {
    isRepeating = !isRepeating;
    if (isRepeating) {
        repeatButton.classList.add('active');
    } else {
        repeatButton.classList.remove('active');
    }
});

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

// func full màn hình
function enterFullscreen() {
    content.classList.add('show');
    fullscreenButton.style.display = 'none';

    if (content.requestFullscreen) {
        content.requestFullscreen();
    } else if (content.mozRequestFullScreen) { // Firefox
        content.mozRequestFullScreen();
    } else if (content.webkitRequestFullscreen) { // Chrome, Safari, Opera
        content.webkitRequestFullscreen();
    } else if (content.msRequestFullscreen) { // IE/Edge
        content.msRequestFullscreen();
    }
}

function exitFullscreen() {
    content.classList.remove('show');
    fullscreenButton.style.display = 'block';
}
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        exitFullscreen();
    }
});
document.addEventListener('fullscreenchange', () => {
    if (!document.fullscreenElement) {
        exitFullscreen();
    }
});
document.addEventListener('mozfullscreenchange', () => {
    if (!document.mozFullScreenElement) {
        exitFullscreen();
    }
});
document.addEventListener('webkitfullscreenchange', () => {
    if (!document.webkitFullscreenElement) {
        exitFullscreen();
    }
});
document.addEventListener('msfullscreenchange', () => {
    if (!document.msFullscreenElement) {
        exitFullscreen();
    }
});


