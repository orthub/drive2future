<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once '../controllers/appointments.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <div class="container">
    <h1>Termin löschen</h1>


  <?php if (isset($_SESSION["delete_app_id"])) {
    $app_delete_id = intval($_SESSION["delete_app_id"]);
  } 
  
  $sql = "DELETE";
  if (get_db()->query($sql)) {
    
  } else {
    echo "Termin konnte nicht gelöscht werden.";
  }
  ?>
    <form action="chooseAppTime.php" method="post">

      <input type="submit" value="Weiter"> <input type="reset">
    </form>
  </div>


  <a href="appointmentManagement.php"> Zurück zu Terminverwaltung </a>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>