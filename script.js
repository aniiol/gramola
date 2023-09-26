let currentSongIndex = 0;
let randomMode = false;

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
    const song = playlistData.songs[index];

    document.getElementById("canco").textContent = song.title;
    document.getElementById("artista").textContent = song.artist;
    document.getElementById("images").src = song.cover;
    audio.src = song.url;
}

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

// Funcio pel funcionament de saltar a la seguent canço
function nextSong() {
    if (randomMode) {
        currentSongIndex = randomIndex(currentSongIndex, playlistData.songs.length);
    } else {
        currentSongIndex = (currentSongIndex + 1) % playlistData.songs.length;
    }

    updateSongInfo(currentSongIndex);

    if (audio.paused) {
        audio.play();
        playButton.classList.remove("fa-play");
        playButton.classList.add("fa-pause");
    }
}

// Funcio pel funcionament de saltar a l'anterior canço
function previousSong() {
    currentSongIndex = (currentSongIndex - 1) % playlistData.songs.length;
    updateSongInfo(currentSongIndex);

    if (audio.paused) {
        audio.play();
        playButton.classList.remove("fa-play");
        playButton.classList.add("fa-pause");
    }
}

// Funcio per canviar el color de aleatori per despres fer funcionar la funcio randomSong
function canviarColor() {
    const aleatori = document.getElementById("aleatori");
    const colorActual = window.getComputedStyle(aleatori).color;

    if (colorActual == "rgb(102, 102, 102)") {
        aleatori.style.color = "rgb(100, 189, 106)";
        randomMode = true;
    } else if (colorActual == "rgb(100, 189, 106)") {
        aleatori.style.color = "rgb(102, 102, 102)";
        randomMode = false;
    }

    // Poso els colors amb rgb perque hi han navagadors (com el que utilitzo) que si ho poses amb # no anira
}

// Funcio per crear un numero aleatori de la mida de l'array i mira que no concideixi amb la posicio actual
function randomIndex(currentIndex, playlistLength) {
    let randomIndex;

    do {
        randomIndex = Math.floor(Math.random() * playlistLength);
    } while (randomIndex == currentIndex);

    return randomIndex;
}

// Funcio pel funcionament del modo aleatori
function randomSong () {
    const newIndex = randomIndex(currentSongIndex, playlistData.length);

    if (colorActual == "rgb(0, 80, 0)") {
        currentSongIndex = newIndex;
        updateSongInfo(currentSongIndex);
      
        if (audio.paused) {
          audio.play();
          playButton.classList.remove("fa-play");
          playButton.classList.add("fa-pause");
        }
    }
} 

// Funcio pel funcionament del aturar canço
function stopSong () {
    if (audio.play) {
        audio.pause();
        playButton.classList.remove("fa-pause");
        playButton.classList.add("fa-play");
        audio.currentTime = 0;
    }
}

// Funcio per fer moure la barra de progres
function progresBarra () {
    const percentatgeProgressio = (audio.currentTime / audio.duration) * 100;

    progres.style.width = `${percentatgeProgressio}%`;
}


// Funcio per actualitzar el temps que porta i que dura la canço
function updateTime () {
    const currentTime = audio.currentTime;
    const duration = audio.duration;

    document.getElementById("temps-actual").textContent = formatTime(currentTime);
    document.getElementById("total-temps").textContent = formatTime(duration);
}

// Funcio per posar el format de la canço en minuts i segons
function formatTime(time) {
    const minutes = Math.floor(time / 60);
    const seconds = Math.floor(time % 60);

    return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
}


// Funcio per canviar l'informacio de canço a traves de l'index de la canço escollida del llistat de la playlist
function playlistSong(index) {
    currentSongIndex = index;
    updateSongInfo(currentSongIndex);
  
    if (audio.paused) {
        audio.play();
        playButton.classList.remove("fa-play");
        playButton.classList.add("fa-pause");
    }
}



// addEventListener per la funcio toggleAudio en el boto playButton
playButton.addEventListener("click", toggleAudio);

// addEventListener per la funcio nextSong en audio
audio.addEventListener("ended", nextSong);

// addEventListener per la funcio nextSong en el boto nextButton
nextButton.addEventListener("click", nextSong);

// addEventListener per la funcio randomSong en el boto randomButton
randomButton.addEventListener("click", canviarColor);

// addEventListener per la funcio randomSong en el boto nextButton
randomButton.addEventListener("click", randomSong);

// addEventListener per la funcio previousSong en el boto previousButton
previousButton.addEventListener("click", previousSong);

// addEventListener per la funcio stopSong en el boto stopButton
stopButton.addEventListener("click", stopSong);

// addEventListener per la funcio progresBarra en audio
audio.addEventListener("timeupdate", progresBarra);

// addEventListener per la funcio updateTime en audio
audio.addEventListener("timeupdate", updateTime);


// Inicia la primera canço de la llista amb la seva informacio
updateSongInfo(currentSongIndex);
