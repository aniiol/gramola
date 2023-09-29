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
            <form action="add.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="playlist_id" value="<?=$_GET['playlist_id']?>">

                <h1>Nom de la cançó:</h1>
                <input type="text" name="name-song" class="text-input">

                <h1>Nom de l'artista/grup:</h1>
                <input type="text" name="name-artist" class="text-input">

                <h1>Portada del l'album/artista:</h1>
                <input type="file" name="images" accept = ".jpg, .jpeg, .png">
                
                <h1>Pista d'audio:</h1>
                <input type="file" name="songs" accept = ".mp3">
                
                <button>Submit</button>
            </form>
        </div>
    </body>

</html>