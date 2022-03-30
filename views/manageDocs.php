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

        <h1>Unterlagen verwalten</h1>

        <?php if ($user_employee || $user_admin) : ?>
            <form action='..\controllers\files.php' method='POST' enctype="multipart/form-data" class="upload">
                <label>Unterlagen hochladen</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
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
        <h1>Unterlagen-Übersicht</h1>

        <div class="doc-overview">
            <div class="doc-item doc-headlines">
                <div class="doc-row">
                    <div class="name">Name</div>
                    <div class="download">herunterladen</div>
                    <?php if ($user_employee || $user_admin) : ?><div class="delete">löschen</div><?php endif ?>
                </div>
            </div>

            <?php foreach ($files as $file) : ?>
                <div class="doc-item">
                    <div class="doc-row">
                        <div class="name"><span><?php echo $file['path']; ?></span></div>
                        <div class="download">
                            <form action='../controllers/files.php' method='POST'>
                                <input type='hidden' name="download" value="<?php echo $file['path'] ?>">
                                <button type="submit" value="herunterladen" class="fs-18"><img src="/drive2future/assets/img/download_icon.png" width="20" /></button>
                            </form>
                        </div>
                        <?php if ($user_employee || $user_admin) : ?><div class="delete">
                                <form action='../controllers/files.php' method='POST'>
                                    <input type='hidden' name="delete" value="<?php echo $file['id_documents'] ?>">
                                    <button type="submit" value="entfernen" class="fs-18"><img src="/drive2future/assets/img/delete_icon.png" width="20" /></button>
                                </form>
                            </div><?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

    </div>

    <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>