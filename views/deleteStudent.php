<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../lib/user_role.php';
if ($user_student || $user_employee) {
  header('Location: ' . '/drive2future/views/appointments.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>


  <div class="container">
    <h1>Löschen bestätigen</h1>
    <?php
    if (isset($_SESSION['errors']['student']) && !empty($_SESSION['errors']['student'])) {
      echo "<p style='color:red'>" . $_SESSION['errors']['student'] . "</p>";
      unset($_SESSION['errors']['student']);
    }
    ?>
    <?php if ($_SESSION['user-status'] === 'aktiv') : ?>
      <div class="app-item app-headlines">
        <div class="app-row">
          <div class="box-25">
            <p>Benutzer kann nicht gelöscht werden, da der Status noch "aktiv" ist</p>
            <br />
            <p><a href="students.php">Zurück zur Schülerverwaltung</a></p>
          </div>
        </div>
      </div>
    <?php endif ?>
    <?php if ($_SESSION['user-status'] === 'inaktiv') : ?>

      <div class="box-25"><p>Wollen Sie <?php echo $_SESSION['first-name'] . " " . $_SESSION['last-name'] ?> wirklich löschen?</p></div>

      <div class="">
        <form action='../controllers/confirmDeleteStudent.php' method='POST'>
          <input type="hidden" value="<?php echo $_SESSION['delete-id']; ?>" name="userId">
          <input class="toggle mb-20" type="submit" value="Endgültig löschen">
        </form>
        <p><a href="students.php">Zurück zur Schülerverwaltung</a></p>
      </div>
    <?php endif ?>

  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>