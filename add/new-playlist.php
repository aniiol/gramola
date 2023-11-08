<?php
    $files = glob("../playlists/*.json");

    // Compta quantes playlists hi han
    $playlist_num = count($files);

    $playlistId = 0;
    if (isset($_POST["playlist_id"])) {
        $playlistId = (int)$_POST["playlist_id"];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name-song"];
        $description = $_POST["description"];

        $dades = array(
            "title" => $name,
            "description" => $description,
            "songs" => array()
        );

        // Sumar 1 al nom de la playlist (ex: Playlist3, doncs la playlist nova sera Playlist4)
        $playlist_num++;


        $json_dades = json_encode($dades);

        // Crea un nou nom d'arxiu basat en el nombre total de playlists
        $arxiu_json = "../playlists/Playlist{$playlist_num}.json";
        file_put_contents($arxiu_json, $json_dades);
    }

    header("Location: ../index.php?playlist_id={$playlistId}");
