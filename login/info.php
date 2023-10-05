<?php
    // Llegir el contingut del fitxer json
    $files = glob("../playlists/*.json");

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

    function playlistName($file) {
        $data = file_get_contents($file);
        $playlist = json_decode($data, true);

        return $playlist["title"];
    }


    // Obtenir data ultima visita
    // esta amb miniscula per mostrar els dies amb numeros, perque si ho poses amb majusucla et surt amb dies de la setmana
    $ultimaVisita = date("d/m/Y");

    setcookie("ultima_visita", $ultimaVisita, strtotime("+1 year"));
?>


<!DOCTYPE html>
<html lang="ca">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="info.css">
        <title>Informació Tècnica</title>
    </head>

    <body>
        <header>
            <div class="tornar">
                <a href="../index.php">
                    <button>Tornar a la pàgina principal</button>
                </a>
            </div>
        </header>


        <div class="principal">
            <div class="container-ranking">
                <div class="top-playlist">
                    <h1>Ordre de les playlist que més has reproduit</h1>
                    <ul>
                        <li><?php echo $nomMesReproduida; ?></li>
                    </ul>
                </div>
            </div>

            <div class="container-recentment">
                <div class="recentment">
                    <h1>Última playlist reproduida</h1>
                    <ul>
                        <li></li>
                    </ul>

                    <br>
                    
                    <h1>Data de l'última vegada visitada:</h1>
                    <ul>
                        <li><?php echo $ultimaVisita; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
    
</html>