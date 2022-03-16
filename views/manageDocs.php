<?php require_once __DIR__ . '/../lib/sessionHelper.php' ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

    <body>
    <?php require_once __DIR__ . '/partials/navbar.php' ?>

        <form action='..\controllers\newFile.php' method='POST' enctype="multipart/form-data">

            <label>neue Datei:</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
            <input type="file" name="userfile"> 
            <br> 
            <input type="submit" value="Datei hinzufügen" >
        </form>

    <?php require_once __DIR__ . '/partials/footer.php' ?>
    </body>

</html>