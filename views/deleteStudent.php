<?php 
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../lib/user_role.php';
if($user_student || $user_employee){
    header('Location: ' . '/drive2future/views/appointments.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>


  <div class="container">
    <h1>Löschen Bestätigen</h1>
    <?php
        if (isset($_SESSION['errors']['student']) && !empty($_SESSION['errors']['student'])) {
            echo "<p style='color:red'>" . $_SESSION['errors']['student'] . "</p>";
            unset($_SESSION['errors']['student']);
        }
    ?>
    <div class="app-item app-headlines">
      <div class="app-row">
        <div class="box-25"><b>Wollen Sie <?php echo $_SESSION['first-name'] ?> wirklich löschen?</b></div>

      </div>
    </div>
    <div class="app-item">
      <div class="app-row">
        <div class="box-25">
          <form action='../controllers/confirmDeleteStudent.php' method='POST'>
            <input type="hidden" value="<?php echo $_SESSION['delete-id']; ?>" name="userId">
            <input class="toggle" type="submit" value="Endgültig löschen">
          </form>
          <form action="/drive2future/views/students.php" method="POST">
            <input type="submit" value="Abbrechen">
          </form>
        </div>
      </div>
    </div>

  </div>


  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>