<?php
    $files = glob("../playlists/*.json");

    $playlistId = 0;
    if (isset($_GET["playlist_id"])) {
        $playlistId = (int)$_GET["playlist_id"];
    }

    $data = file_get_contents($files[$playlistId]);
    $playlist = json_decode($data, true);


    $imgs = $playlist["songs"];

    array_splice($imgs, $_GET["song"],1);

    $playlist["songs"] = $imgs;
    $imagesJSON = json_encode($playlist);

    file_put_contents($files[$playlistId], $imagesJSON);

    header("Location: ../index.php?playlist_id={$playlistId}");
?>