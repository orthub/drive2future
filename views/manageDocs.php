<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../controllers/files.php';
require_once __DIR__ . '/../lib/user_role.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
    <?php require_once __DIR__ . '/partials/navbar.php' ?>
    <div class="container">
        <h1>Unterlagen</h1>

        <?php if ($user_employee || $user_admin) : ?>
            <form action='..\controllers\files.php' method='POST' enctype="multipart/form-data">
                <label>Unterlagen hochladen</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                <input type="file" name="userfile">

                <input type="submit" value="Datei hinzufügen">
            </form>
        <?php endif ?>

        <?php
        if (isset($_SESSION['errors']['File']) && !empty($_SESSION['errors']['File'])) {
            echo "<p style='color:red'>" . $_SESSION['errors']['File'] . "</p>";
            unset($_SESSION['errors']['File']);
        }
        ?>

        <table>
            <thead>
                <th>Name</th>
                <th></th>
                <?php if ($user_employee || $user_admin) : ?> <th></th> <?php endif ?>
            </thead>
            <tbody>
                <?php foreach ($files as $file) : ?>
                    <tr>
                        <td><?php echo $file['path']; ?></td>
                        <td>
                            <form action='../controllers/files.php' method='POST'>
                                <input type='hidden' name="download" value="<?php echo $file['path'] ?>">
                                <input type="submit" value="Herunterladen" />
                            </form>

                        </td>
                        <?php if ($user_employee || $user_admin) : ?>
                            <td>
                                <form action='../controllers/files.php' method='POST'>
                                    <input type='hidden' name="delete" value="<?php echo $file['id_documents'] ?>">
                                    <input type="submit" value="Entfernen" />
                                </form>
                            </td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    </div>

    <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>