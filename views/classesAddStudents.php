<?php 
require_once __DIR__ . '/../lib/sessionHelper.php';
if(isset($_POST['id']) && isset($_POST['label'])){
    $_SESSION['classid'] = $_POST['id'];
    $_SESSION['lable'] = $_POST['label'];
}

require_once __DIR__ . '/../controllers/classes.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>

    <div class="container">

        <h1><a name="Anker1">Klassenübersicht Klasse: <?php echo $_SESSION['lable']?></h1>

        <?php
        if (isset($_SESSION['errors']['class']) && !empty($_SESSION['errors']['class'])) {
            echo "<p style='color:red'>" . $_SESSION['errors']['class'] . "</p>";
            unset($_SESSION['errors']['class']);
        }
        ?>

        <h2>Schüler in Klasse</h2>
        <div class="app-item ">
            <div class="app-row">
        
                <div class="box-1"><b>Nachname</b></div>
                <div class="box-2"><b>Vorname</b></div>
                <div class="box-3"><b>Entfernen</b></div>
        
            </div>
        </div>

        <?php foreach ($studentsFromClass as $student) : ?>
            <div class="app-item">
                <div class="app-row">
                    <div class="box-1"><span>Nachname: </span><?php echo $student['first_name']; ?></div>
                    <div class="box-2"><span>Vorname: </span><?php echo $student['last_name']; ?></div>
                    <div class="box-3"><span>hinzufügen: </span>

                        <form action='../controllers/classes.php' method='POST'>  
                            <input type="submit" value="Schüler entfernen">
                            <input type="hidden" value="<?php echo $student['id_user']; ?>" name="userId">
                            <input type="hidden" value="<?php echo $_SESSION['classid'] ?>" name="classId">
                            <input type="hidden" name="isDelete">
                        </form>

                    </div>
                </div>
            </div>
        <?php endforeach ?>

        <h2>alle Schüler</h2>
        <div class="app-item">
            <div class="app-row">
        
                <div class="box-1"><b>Nachname</b></div>
                <div class="box-2"><b>Vorname</b></div>
                <div class="box-3"><b>hinzufügen</b></div>
        
            </div>
        </div>

        <?php foreach ($students as $student) : ?>
            <div class="app-item">
                <div class="app-row">
                    <div class="box-1"><span>Nachname: </span><?php echo $student['first_name']; ?></div>
                    <div class="box-2"><span>Vorname: </span><?php echo $student['last_name']; ?></div>
                    <div class="box-3"><span>hinzufügen: </span>

                        <?php $flag = true; ?>

                        <?php foreach ($studentsFromClass as $student2) : ?>

                        <?php if($student2['id_user'] ==  $student['id_user']) {
                            $flag = false;
                        } ?>

                        <?php endforeach ?>
                        
                        <?php if($flag) :?> 
                            <form action='../controllers/classes.php' method='POST'>  
                                <input type="submit" value="Schüler hinzufügen">
                                <input type="hidden" name="addSchuler">
                                <input type="hidden" value="<?php echo $_SESSION['classid'] ?>" name="classId">
                                <input type="hidden" value="<?php echo $student['id_user'] ?>" name="userId">
                            </form>
                        <?php endif?> 
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>

<?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>