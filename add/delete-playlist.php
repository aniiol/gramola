<?php
    $files = glob("../playlists/*.json");
    
    if (isset($_GET["playlist_id"])) {
        $playlistId = (int)$_GET["playlist_id"];


        // Comprovem si el "playlistId" esta dins de la carpeta playlist
        if ($playlistId >= 0 && $playlistId < count($files)) {
            // Obtenir el nom del fitxer que volem eliminar
            $fileToDelete = $files[$playlistId];

            // Eliminar arxiu json
            if (unlink($fileToDelete)) {
                header("Location: ../index.php?playlist_id=0");
            }
        }
    }
?>
