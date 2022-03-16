<?php 
    require_once __DIR__ . '/../lib/sessionHelper.php';
    require_once __DIR__ . '/../controllers/files.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

    <body>
    <?php require_once __DIR__ . '/partials/navbar.php' ?>

        <form action='..\controllers\files.php' method='POST' enctype="multipart/form-data">

            <label>neue Datei:</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
            <input type="file" name="userfile"> 
            <br> 
            <input type="submit" value="Datei hinzufügen" >
        </form>

        <table>
            <thead>
                <th>Name</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach ($files as $file) : ?>
                <tr>
                    <td><?php echo $file['path']; ?></td>
                    <td>
                        <form action='../controllers/files.php' method='POST'>
                            <input type='hidden' name="download" <?php echo $file['id_documents'] ?>>
                            <input type="submit" value="Herunterladen"/>
                        </form>
                    </td>
                    <td>
                        <form action='../controllers/files.php' method='POST'>
                            <input type='hidden' name="delete" value="<?php echo $file['id_documents'] ?>">
                            <input type="submit" value="Entfernen"/>
                        </form>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    <?php require_once __DIR__ . '/partials/footer.php' ?>
    </body>

</html>