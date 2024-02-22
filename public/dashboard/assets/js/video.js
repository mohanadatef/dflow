const player = document.querySelector('.player');
const video = document.querySelector('video');
const videoInput = document.getElementById('video-input');

const toggle = document.getElementById('toggle-video');
const progressBar = document.getElementById('progress-bar');
const volIcon = document.getElementById('toggle-mute');
const volSlider = document.getElementById('vol-slider');
const sliders = document.querySelectorAll('.player-slider');
const skipButtons = document.querySelectorAll('.playback-btn');
const fullscreen = document.getElementById('fullscreen');

videoInput.addEventListener('change', buildPlayer);
video.addEventListener('click', toggleVideo);
toggle.addEventListener('click', toggleVideo);
video.addEventListener('play', setToggleIcon);
video.addEventListener('pause', setToggleIcon);
sliders.forEach(slider => slider.addEventListener('input', setVideoProperty));
volIcon.addEventListener('click', toggleMute);
video.addEventListener('volumechange', updateVolSlider)
video.addEventListener('timeupdate', showProgress);
skipButtons.forEach(btn => btn.addEventListener('click', skipTo));
fullscreen.addEventListener('click', toggleFullscreen);

progressBar.max = video.duration;
let lastVolume = 0;


function buildPlayer() {
    if (videoInput.files && videoInput.files[0]) {
        $('.player').removeClass('d-none');
        const file = videoInput.files[0];
        const url = URL.createObjectURL(file);
        const reader = new FileReader();
        reader.onload = function() {
            video.src = url;
        }
        reader.readAsDataURL(file);
    }

    player.style.visibility = 'visible';
}

function toggleVideo() {
video.paused ? video.play() : video.pause();
}

function setToggleIcon() {
video.paused
    ? toggle.firstElementChild.classList.replace('fa-pause', 'fa-play')
    : toggle.firstElementChild.classList.replace('fa-play', 'fa-pause')
}

function showProgress() {
progressBar.value = video.currentTime;
}

function toggleMute() {
if (video.volume !== 0) {
    lastVolume = video.volume;
    video.volume = 0;
} else {
    video.volume = lastVolume;
}
}

function updateVolSlider() {
volSlider.value = video.volume;
if (video.volume === 0) {
    volIcon.firstElementChild.classList.replace('fa-volume-up', 'fa-volume-mute');
} else {
    volIcon.firstElementChild.classList.replace('fa-volume-mute', 'fa-volume-up');
}
}

function setVideoProperty() {
video[this.name] = this.value;
}

function skipTo() {
video.currentTime += (+this.dataset.skip);
}

function toggleFullscreen() {
    if (document.fullscreenElement) {
        document.exitFullscreen();
        player.style.border = '';
        player.style.borderRadius = '';
    } else {
        player.requestFullscreen();
        player.style.border = 'none';
        player.style.borderRadius = 'none';
    }
}

