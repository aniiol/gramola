<?php
    $files = glob("../playlists/*.json");

    $playlistId = 0;
    if (isset($_POST["playlist_id"])) {
        $playlistId = (int)$_POST["playlist_id"];
    }

    $data = file_get_contents($files[$playlistId]);
    $playlist = json_decode($data, true);

    // Obtenir dades del formulari
    $name_song = $_POST["name-song"];
    $name_artist = $_POST["name-artist"];
    $imageName = $_FILES["images"]["name"];
    $songName = $_FILES["songs"]["name"];

    // Crear una altre array per afegir informacio de la canço
    $newSong = [
        "title" => $name_song,
        "artist" => $name_artist,
        "url" => "../assets/audio/{$songName}",
        "cover" => "../assets/{$imageName}"
    ];

    $playlist["songs"][] = $newSong;

    $updatedPlaylistJSON = json_encode($playlist);
    file_put_contents($files[$playlistId], $updatedPlaylistJSON);

    move_uploaded_file($_FILES["images"]["tmp_name"], "../assets/{$imageName}");
    move_uploaded_file($_FILES["songs"]["tmp_name"], "../assets/audio/{$songName}");

    header("Location: ../index.php?playlist_id={$playlistId}");
?>