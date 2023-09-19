let currentSongIndex = 0;

const nextButton = document.getElementById("seguent");
const stopButton = document.getElementById("stop");
const playButton = document.getElementById("play");
const previousButton = document.getElementById("anterior");
const randomButton = document.getElementById("aleatori");
const progres = document.getElementById("progres");
const barraProgres = document.getElementById("barra-progres");
const audio = new Audio();


// Funcio per canviar la foto, el nom de la canço i el de l'artista
function updateSongInfo(index) {
    const song = playlistData.playlist[index];
    document.getElementById("canco").textContent = song.title;
    document.getElementById("artista").textContent = song.artist;
    document.getElementById("images").src = song.cover;
    audio.src = song.url;
}


playButton.addEventListener("click", toggleAudio);

// Funcio que fa funcionar el boto de play/stop
function toggleAudio() {

    if (audio.paused) {
        audio.play();
        playButton.classList.remove("fa-play");
        playButton.classList.add("fa-pause");
    } else {
        audio.pause();
        playButton.classList.remove("fa-pause");
        playButton.classList.add("fa-play");
    }
}


// A fer click a l'icona de seguent salta a la seguent canço canviant l'informacio necessaria
nextButton.addEventListener("click", () => {

    currentSongIndex = (currentSongIndex + 1) % playlistData.playlist.length;
    updateSongInfo(currentSongIndex);

    if (audio.paused) {
        audio.play();
        playButton.classList.remove("fa-play");
        playButton.classList.add("fa-pause");
    }
});

// Al fer clcik a l'icona de anterior slata a l'anterior canço canviant l'informacio necessaria
previousButton.addEventListener("click", () => {
    currentSongIndex = (currentSongIndex - 1) % playlistData.playlist.length;
    updateSongInfo(currentSongIndex);

    if (audio.paused) {
        audio.play();
        playButton.classList.remove("fa-play");
        playButton.classList.add("fa-pause");
    }
})



// Al fer click a l'icona de parar, para la canço i cambia l'icona de pausa al de play
stopButton.addEventListener("click", () => {
    if (audio.play) {
        audio.pause();
        playButton.classList.remove("fa-pause");
        playButton.classList.add("fa-play");
        audio.currentTime = 0;
    }
});


// Anar al minut que tries clicant a la barra




// Actualitzar la barra de progrés quan la cançó estigui en curs
audio.addEventListener("timeupdate", () => {
    const currentTime = audio.currentTime;
    const duration = audio.duration;
    const percentatgeProgressio = (currentTime / duration) * 100;
    progres.style.width = `${percentatgeProgressio}%`;
});


//  Acutalizar el temps de la canço, la duracio i el temps que porta
audio.addEventListener("timeupdate", () => {

    // Actualitza barra de progres i el temps
    const currentTime = audio.currentTime;
    const duration = audio.duration;

    // Actualitza el temps actual i el temps total de la canço
    document.getElementById("temps-actual").textContent = formatTime(currentTime);
    document.getElementById("total-temps").textContent = formatTime(duration);
});

// Funcio per posar els segons que porta la canço i el que dura
function formatTime(time) {
    const minutes = Math.floor(time / 60);
    const seconds = Math.floor(time % 60);
    return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
}



// Inicia la primera canço de la llista amb la seva informacio
updateSongInfo(currentSongIndex);
