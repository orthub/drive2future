<?php 
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../lib/user_role.php';
require_once __DIR__ . '/../controllers/classes.php';
if($user_student){
    header('Location: ' . '/drive2future/views/index.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>


  <div class="container">
    <h1><a name="Anker1">Schüler verwalten </a></h1>

    <?php
        if (isset($_SESSION['errors']['student']) && !empty($_SESSION['errors']['student'])) {
            echo "<p style='color:red'>" . $_SESSION['errors']['student'] . "</p>";
            unset($_SESSION['errors']['student']);
        }
    ?>

    <div class="app-item app-headlines">
        <div class="app-row">
            <div class="box-25"><b>Nachname</b></div>
            <div class="box-25"><b>Vorname</b></div>
            <div class="box-25"><b>Email</b></div>
            <div class="box-25"><b>Status</b></div>
        </div>
    </div>

    <?php foreach ($students as $student) : ?>
            <div class="app-item">
                <div class="app-row">
                    <div class="box-25"><span>Nachname: </span><?php echo $student['first_name']; ?></div>
                    <div class="box-25"><span>Vorname: </span><?php echo $student['last_name']; ?></div>
                    <div class="box-25"><span>Email: </span><?php echo $student['email']; ?></div>
                    <div class="box-25"><span>Status: </span><?php echo $student['status']; ?> 
                    
                    <form action='../controllers/students.php' method='POST'>  
                        <input type="hidden" value="<?php echo $student['id_user']; ?>" name="userId">
                        <?php if($student['status'] == "aktiv") : ?>
                            <input type="submit" value="ändern" class="toggle">
                            <input type="hidden" value="inaktiv" name="status">
                        <?php elseif($student['status'] == "inaktiv") :?>  
                            <input type="submit" value="ändern" class="toggle">
                            <input type="hidden" value="aktiv" name="status">   
                        <?php else : ?>
                            status fehlerhaft
                        <?php endif ?>
                    </form>

                    </div>


                </div>
            </div>
    <?php endforeach ?>

  </div>


  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>