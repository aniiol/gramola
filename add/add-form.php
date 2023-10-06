<!DOCTYPE html>
<html lang="ca">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="form.css">
        <title>Add Form</title>
    </head>

    <body>
        <div class="principal">
            <form action="add-song.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="playlist_id" value="<?=$_GET["playlist_id"]?>">

                <h1>Nom de la cançó:</h1>
                <input type="text" name="name-song" class="text-input" required>

                <h1>Nom de l'artista/grup:</h1>
                <input type="text" name="name-artist" class="text-input" required>

                <h1>Portada del l'album/artista:</h1>
                <input type="file" name="images" accept = ".jpg, .jpeg, .png" required>
                
                <h1>Pista d'audio:</h1>
                <input type="file" name="songs" accept = ".mp3" required>
                
                <button>Enviar</button>
            </form>
        </div>
    </body>

</html>