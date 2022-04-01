<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../lib/user_role.php';
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

    try {
      get_db()->beginTransaction();
      // Terrmine für die beteiligten Benutzer löschen
      delete_user_appointment($app_delete_id);

      // Termin aus der Tabelle appointments löschen
      delete_appointment($app_delete_id);

      get_db()->commit();
      echo "<p>Ihr Termin wurde erfolgreich gelöscht.</p><br>";
    } catch (PDOException $e) {
      get_db()->rollBack();
      echo "<p>Ihr Termin konnte nicht gelöscht werden. Bitte versuchen Sie es erneut.</p><br>";
    }
    ?>

    <div>
      <p><a href="appointmentManagement.php"> Zurück zur Terminverwaltung</a></p>
    </div>
  </div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>