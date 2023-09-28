<?php
    // Llegir el contingut del fitxer json
    $files = glob("playlists/*.json");

    $playlistId = 0;
    if (isset($_GET["playlist_id"])) {
        $playlistId = (int)$_GET["playlist_id"];
    }

    $data = file_get_contents($files[$playlistId]);
    $playlist = json_decode($data, true);

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
        </header>

        <div class="principal">


            <!-- CONTAINER PLAYLISTS -->
            <div class="container-playlists">
                <ul>
                    <?php 
                        foreach ($files as $i => $file) { ?>
                            <li> 
                                <span>
                                    <a href="index.php?playlist_id=<?= $i ?>"><?= playlistName($file);?></a>
                                    <p class="description"><?= playlistDescription($file);?></p>
                                </span>
                            </li>
                    <?php } ?>
                </ul>
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
                        <i class="fa-solid fa-volume-low"></i>
                    </div>
                    <div class="barra-volum">
                        <div class="progres-volum" id="progres-volum"></div>
                    </div>
                </div>


            </div>

            <!-- CONTAINER ENSENYAR CANÇONS DE LES PLAYLIST -->
            <div class="container-songs">
                    <?php
                        for ($i = 0; $i < count($playlist["songs"]); $i++) {
                            $name = $playlist["songs"][$i]["title"];
                        ?>
                        <div class="cancons-playlist">
                            <div class="icona-play-canco">
                                <i class="fa-solid fa-play reprodueix-llista" title="Reprodueix" id="canco<?php echo $i ?>" onclick="playlistSong(<?php echo $i ?>)"></i>
                            </div>

                            <div class="nom-canco">   
                                <p><?php echo $name; ?></p>
                            </div>

                            <div class="eliminar-canco">
                                <a href="delete.php?song=<?= $i?>&playlist_id=<?= $playlistId ?>">
                                    <i class="fa-solid fa-trash" title="Esborrar"></i>
                                </a>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="afegir-canco">
                        <a href="add-form.php?playlist_id=<?= $playlistId ?>">
                            <button class="afegir-canco">Afegeix Nova Cançó</button>
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