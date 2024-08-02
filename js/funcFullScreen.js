// Fullscreen functionality
const fullscreenButton = document.getElementById('fullscreenButton');
const fullscreenContent = document.querySelector('.fullscreen');

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