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

    setcookie("playlist_id", $playlistId, strtotime("+7 days")); // guarda la cookie per 7 dies

    // Mirem que $files no estigui buit i que la ruta esta ben apuntada (si no es fa aixo, salta un error quan vull eliminar alguna playlist)
    if (isset($files[$playlistId]) && file_exists($files[$playlistId])) {
        $data = file_get_contents($files[$playlistId]);
        $playlist = json_decode($data, true);
    }
    
    // Funcio per saber el titol dels arxius json
    function playlistName ($file) {
        $data = file_get_contents($file);
        $playlist = json_decode($data, true);

        return $playlist["title"];
    }

    // Funcio per saber la descripcio dels arxius json
    function playlistDescription ($file) {
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
            <div class="titol">
                <h1>Gramola</h1>
            </div>

            <div class="session">
                <a href="login/login-form.php">
                    <button>Iniciar Sessió</button>
                </a>
            </div>
        </header>

        <div class="principal">

            <!-- CONTAINER PLAYLISTS -->
            <div class="container-playlists">
                <ul>
                    <?php 
                        foreach ($files as $i => $file) { ?>
                        <li>
                            <div class="playlist">
                                <div class="nom-playlist">
                                    <a href="index.php?playlist_id=<?= $i ?>"><?= playlistName($file);?></a>
                                    <p class="description"><?= playlistDescription($file);?></p>
                                </div>

                                <div class="eliminar-playlist">
                                    <a href="afegir/delete-playlist.php?playlist_id=<?= $i ?>">
                                        <i class="fa-solid fa-trash" title="Esborrar"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
                <div class="afegir-playlist">
                    <a href="afegir/add-playlist.php?playlist_id=<?= $playlistId ?>">
                        <button>Afegeix Nova Playlist</button>
                    </a>
                </div>
            </div> 


            <!-- CONTAINER REPRODUCTOR -->
            <div class="container-reproductor">

                <div class="img-canco">
                    <img src="" class="activa" id="images">
                </div>

                <!-- Nom canço/artista -->
                <h2 id="canco"></h2>
                <h3 id="artista"></h3>

                <!-- Barra del temps de la canço amb els minuts -->
                <div class="barra" id="barra-progres">
                    <div class="progres" id="progres"></div>
                    <div class="duracio">
                        <span id="temps-actual">0:00</span>
                        <span id="total-temps">0:00</span>
                    </div>
                </div>


                <!-- Controls principals -->
                <div class="controls">
                    <i class="fa-solid fa-backward" title="Anterior" id="anterior"></i>
                    <i class="fa-solid fa-shuffle" title="Aleatori" id="aleatori"></i>
                    <i class="fa-solid fa-play boto-play" title="Reprodueix" id="play"></i>
                    <i class="fa-solid fa-stop" title="Aturar" id="stop"></i>
                    <i class="fa-solid fa-forward" title="Següent" id="seguent"></i>
                </div>

                <div class="volum">
                    <div class="icona-volum">
                        <i class="fa-solid fa-volume-high" id="icona-volum"></i>
                    </div>

                    <div class="barra-volum">
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