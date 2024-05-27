document.addEventListener('DOMContentLoaded', function() {
    const wavesContainer = document.getElementById('waves-wrapper');
    const waveImage = document.querySelector('.waves');
    const waveWidth = waveImage.width;
    const containerWidth = wavesContainer.offsetWidth;

    const numberOfWaves = Math.ceil(containerWidth / waveWidth);

    for (let i = 1; i < numberOfWaves; i++) {
        const clonedWave = waveImage.cloneNode(true);
        wavesContainer.appendChild(clonedWave);
    }
});

