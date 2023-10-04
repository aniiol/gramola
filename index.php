<?php
    // Llegir el contingut del fitxer json
    $files = glob("playlists/*.json");

    $playlistId = 0;
    if (isset($_GET["playlist_id"])) {
        $playlistId = (int)$_GET["playlist_id"];
    } else {
        // si no tenim playlist_id amb el get comprovem si esta a la cookie
        if (isset($_COOKIE["playlist_id"])) {
            $playlistId = (int)$_COOKIE["playlist_id"];
        }
    }

    setcookie("playlist_id", $playlistId, strtotime("+1 year")); // guarda la cookie per 1 any

    // Mirem que $files no estigui buit i que la ruta esta ben apuntada (si no es fa aixo, salta un error quan vull eliminar alguna playlist)
    if (isset($files[$playlistId]) && file_exists($files[$playlistId])) {
        $data = file_get_contents($files[$playlistId]);
        $playlist = json_decode($data, true);
        
       // Verifiquem si la cookie existeix i la descodifiquem amb decode
        if (isset($_COOKIE["playlist_reproducciones"])) {
            $playlistReproducciones = json_decode($_COOKIE["playlist_reproducciones"], true);
        } else {
            $playlistReproducciones = array();
        }

        // Incrementa el contador de reproducciones de la playlist actual
        if (isset($playlistReproducciones[$playlistId])) {
            $playlistReproducciones[$playlistId]++;
        } else {
            $playlistReproducciones[$playlistId] = 1;
        }

        setcookie("playlist_reproducciones", json_encode($playlistReproducciones), strtotime("+1 year"));
    }

    if (isset($_COOKIE["playlist_reproducciones"])) {
        $playlistReproducciones = json_decode($_COOKIE["playlist_reproducciones"], true);
    } else {
        $playlistReproducciones = array();
    }
    
    // Trobar l'index de la mes reproduiad
    $playlistMesReproduida = array_search(max($playlistReproducciones), $playlistReproducciones);

    // Assignar el nom de la canço mes reproduida
    $nomMesReproduida = playlistName($files[$playlistMesReproduida]);

    
    // Funcio per saber el titol dels arxius json
    function playlistName($file) {
        $data = file_get_contents($file);
        $playlist = json_decode($data, true);

        return $playlist["title"];
    }

    // Funcio per saber la descripcio dels arxius json
    function playlistDescription($file) {
        $data = file_get_contents($file);
        $playlist = json_decode($data, true);
        
        return $playlist["description"];
    }
?>

<!DOCTYPE html>
<html lang="ca">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="assets/gramola.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <title>Gramola</title>
    </head>
    
    <body>
        <header>
            <div class="page-title">
                <h1>Gramola</h1>
            </div>

            <div class="burger">
                <i class="fa-solid fa-bars"></i>

                <nav>
                    <ul>
                        <?php 
                            foreach ($files as $i => $file) { ?>
                            <li><a href="index.php?playlist_id=<?= $i ?>"><?= playlistName($file);?></a>
                                <ul>
                                    <?php
                                        for ($i = 0; $i < count($playlist["songs"]); $i++) {
                                            $name = $playlist["songs"][$i]["title"];
                                            $artist = $playlist["songs"][$i]["artist"];
                                    ?>
                                    <li>
                                        <p id="canco<?php echo $i ?>" onclick="playlistSong(<?php echo $i ?>)"><?php echo $name; ?></p>
                                        <p class="description"><?php echo $artist;?></p>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>

            <h2>Playlist Més Reproduïda: 
                <p><?php echo $nomMesReproduida; ?></p>
            </h2>

        </header>

        <div class="principal">

            <!-- CONTAINER PLAYLISTS -->
            <div class="container-playlists">
                <ul>
                    <?php 
                        foreach ($files as $i => $file) { ?>
                        <li>
                            <div class="playlist">
                                <div class="name-playlist">
                                    <a href="index.php?playlist_id=<?= $i ?>"><?= playlistName($file);?></a>
                                    <p class="description"><?= playlistDescription($file);?></p>
                                </div>

                                <div class="delete-playlist">
                                    <a href="afegir/delete-playlist.php?playlist_id=<?= $i ?>">
                                        <i class="fa-solid fa-trash" title="Esborrar"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
                <div class="add-playlist">
                    <a href="afegir/add-playlist.php?playlist_id=<?= $playlistId ?>">
                        <button>Afegeix Nova Playlist</button>
                    </a>
                </div>
            </div> 


            <!-- CONTAINER REPRODUCTOR -->
            <div class="container-reproductor">

                <div class="img-song">
                    <img src="" class="active" id="images">
                </div>

                <!-- Nom canço/artista -->
                <h2 id="canco"></h2>
                <h3 id="artista"></h3>

                <!-- Barra del temps de la canço amb els minuts -->
                <div class="bar" id="barra-progres">
                    <div class="progres" id="progres"></div>
                    <div class="duration">
                        <span id="temps-actual">0:00</span>
                        <span id="total-temps">0:00</span>
                    </div>
                </div>


                <!-- Controls principals -->
                <div class="controls">
                    <i class="fa-solid fa-backward" title="Anterior" id="anterior"></i>
                    <i class="fa-solid fa-shuffle" title="Aleatori" id="aleatori"></i>
                    <i class="fa-solid fa-play play-button" title="Reprodueix" id="play"></i>
                    <i class="fa-solid fa-stop" title="Aturar" id="stop"></i>
                    <i class="fa-solid fa-forward" title="Següent" id="seguent"></i>
                </div>

                <div class="volum">
                    <div class="icona-volum">
                        <i class="fa-solid fa-volume-high" id="icona-volum"></i>
                    </div>

                    <div class="volume-bar">
                        <div class="progres-volum" id="progres-volum"></div>
                    </div>
                    
                    <i class="fa-solid fa-minus" id="less-volume"></i>
                    <i class="fa-solid fa-plus" id="more-volume"></i>
                </div>


            </div>

            <!-- CONTAINER ENSENYAR CANÇONS DE LES PLAYLIST -->
            <div class="container-songs">
                    <?php
                        for ($i = 0; $i < count($playlist["songs"]); $i++) {
                            $name = $playlist["songs"][$i]["title"];
                            $artist = $playlist["songs"][$i]["artist"];
                        ?>
                        <div class="cancons-playlist">
                            <div class="icona-play-canco">
                                <i class="fa-solid fa-play reprodueix-llista" title="Reprodueix" id="canco<?php echo $i ?>" onclick="playlistSong(<?php echo $i ?>)"></i>
                            </div>

                            <div class="nom-canco">   
                                <p><?php echo $name; ?></p>
                                <p class="description"><?php echo $artist;?></p>
                            </div>

                            <div class="eliminar-canco">
                                <a href="afegir/delete.php?song=<?= $i?>&playlist_id=<?= $playlistId ?>">
                                    <i class="fa-solid fa-trash" title="Esborrar"></i>
                                </a>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="afegir-canco">
                        <a href="afegir/add-form.php?playlist_id=<?= $playlistId ?>">
                            <button>Afegeix Nova Cançó</button>
                        </a>
                    </div>
            </div>
        </div>                   

        <!-- Dona informacio de html al js a traves de php -->
        <script>
            var playlistData = <?php echo json_encode($playlist); ?>;
        </script>

        <script src="script.js"></script>
    </body>

</html>