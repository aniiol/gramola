<!DOCTYPE html>
<html lang="ca">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="add-playlist.css">
        <title>Add Form</title>
    </head>

    <body>
        <div class="principal">
            <form action="new-playlist.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="playlist_id" value="<?=$_GET['playlist_id']?>">

                <h1>Nom de la playlist:</h1>
                <input type="text" name="name-song" class="text-input" required>

                <h1>Descripció de la playlist:</h1>
                <input type="text" name="description" class="text-input" required>
                
                <button>Enviar</button>
            </form>
        </div>
    </body>

</html>