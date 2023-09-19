

<!DOCTYPE html>
<html lang="ca">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" type="image/jpg" href="assets/gramola.png"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <title>La Gramola</title>

        <?php
            // Llegir el contingut del fitxer json
            $jsonData = file_get_contents('playlists.json');

            // Decodificar el json en una variable php
            $playlistData = json_decode($jsonData, true);
        ?>

    </head>
    

    <body>

        <!-- TITOL -->
        <div class="titol">
            <h1>LA GRAMOLA</h1>
        </div> 


        <!-- CONTAINER PLAYLISTS -->
        <div class="container-playlists">
            <nav>
                <ul>
                    <li><a href="#">Playlist 1</a></li>
                    <li><a href="#">Playlist 2</a></li>
                    <li><a href="#">Playlist 3</a></li>
                </ul>
            </nav>
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
            <div class="botons">
                <div class="progres"></div>
                <div class="duracio">
                    <span id="temps-actual">0:00</span>
                    <span id="total-temps">0:00</span>
                </div>
            </div>

            <!-- Controls principals -->
            <div class="controls">
                <i class="fa-solid fa-backward" title="Anterior" id="anterior"></i>
                <i class="fa-solid fa-shuffle" title="Aleatori" id="aleatori"></i>
                <i class="fa-solid fa-play boto-play" title="Pausa" id="play"></i>
                <i class="fa-solid fa-stop" title="Aturar" id="stop"></i>
                <i class="fa-solid fa-forward" title="Següent" id="seguent"></i>
            </div>


            <!-- Control de volum -->
            <i class="fa-solid fa-volume-low icona-volum" title="Volum"></i>
            <div class="master-volum">
                <div class="nivell-volum"></div>
            </div>

        </div>
        
        <!-- Donar informacio de html al js a traves de php -->
        <script>
            var playlistData = <?php echo json_encode($playlistData); ?>;
        </script>

        <script src="script.js"></script>
    </body>

</html>