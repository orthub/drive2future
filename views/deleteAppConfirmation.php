<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once '../controllers/appointments.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<head>
  <link rel="stylesheet" href="/drive2future/assets/css/style.css">
</head>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <h1>Termin löschen</h1>


  <?php if (isset($_POST["delete-app"]) && !empty($_POST["delete-app"])) {
    $_SESSION["delete_app_id"] = intval($_POST["delete-app"]);
  } ?>

  <div>
    Möchten Sie den Termin entgültig löschen?
  </div>

  <form action="deleteAppConfirmation.php">
    <input type="submit" value="Löschen">
  </form>

  <a href="appointmentManagement.php"> Zurück zu Terminverwaltung </a>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>