<!DOCTYPE html>
<html lang="ca">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="login-form.css">
        <title>Login</title>
    </head>

    <body>
        <div class="principal">
            <form action="info.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="playlist_id" value="<?=$_GET["playlist_id"]?>">


                <h1>Nom:</h1>
                <input type="text" name="name" class="text-input">
                
                <button>Submit</button>
            </form>
        </div>
    </body>

</html>