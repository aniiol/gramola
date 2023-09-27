<html>
    <body>
        <form action="add.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="playlist_id" value="<?=$_GET["playlist_id"]?>" >
            <input type="file" name="image">
            <br>
            <input type="file" name="song">
            <br>
            <button>Submit</button>
        </form>
    </body>
</html>