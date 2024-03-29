<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../lib/user_role.php';
require_once __DIR__ . '/../controllers/appointments.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <div class="container">

    <?php
    if ($user_employee) { ?>
      <h1>Fahrstunde bearbeiten</h1>
    <?php } else if ($user_admin) {  ?>
      <h1>Termin bearbeiten</h1>
    <?php }
    ?>

    <?php
    if (isset($_SESSION["edit_app_id"])) {
      $edit_app_id = intval($_SESSION["edit_app_id"]);
    }

    if (isset($_SESSION["employee_id"])) {
      $employee_id = intval($_SESSION["employee_id"]);
    }

    if (isset($_SESSION["user_id"])) {
      $user_id = intval($_SESSION["user_id"]);
    }

    if (isset($_SESSION["app_type_id"])) {
      $app_type_id = intval($_SESSION["app_type_id"]);
    }

    if (isset($_SESSION["room_id"])) {
      $room_id = intval($_SESSION["room_id"]);
    }

    if (isset($_SESSION["date"])) {
      $date = strval($_SESSION["date"]);
    }

    if (isset($_POST["begin-time"])) {
      $begin_time = strval($_POST["begin-time"]);
    }

    if (isset($_SESSION["class_id"])) {
      $class_id = intval($_SESSION["class_id"]);
    }

    if (isset($_SESSION["app_description"])) {
      $description = strval($_SESSION["app_description"]);
    } else {
      $description = "";
    }

    if (isset($_SESSION["student_id"])) {
      $student_id = intval($_SESSION["student_id"]);
    }

    //Endzeit berechnen
    $end_time = transform_minutes_to_time(transform_time_to_minutes($begin_time) + $_SESSION['duration']);

    try {
      get_db()->beginTransaction();
      // Noch aktuelle Daten des Termines aus Datenbank holen
      $old_app = (get_appointment($edit_app_id))[0];

      if ($user_employee) {
        $employee_id = $user_id;
      }

      // Alter Fahrlehrer wird gelöscht, neu ausgewählter hinzugefügt
      delete_user_appointment(intval($old_app["id_appointment"]));
      add_user_appointment($employee_id, $edit_app_id);

      // Bleibt der Termintyp bei "Fahrstunde" kann trotzdem ein anderer Schüler ausgewählt werden
      // Falls anderer Termintyp oder andere Klasse gewählt wurde, Datensätze aus anderen Tabellen auch aktualisieren
      if (
        intval($app_type_id === 3)
      ) {

        // Eintrag in user_has_appointments speichern
        add_user_appointment($student_id, $edit_app_id);
      } else if (intval($app_type_id) === 1 || intval($app_type_id) === 2) {
        // Termin für alle Schüler einer Klasse löschen
        delete_class_appointment($old_app["class_id_class"], $edit_app_id);
       
        // Termin für alle Schüler einer Klasse aktualisieren
        update_class_appointment($class_id, $edit_app_id);
      }

      // Geänderte Termininfos in Tabelle appointments speichern
      update_appointment(
        $edit_app_id,
        $date,
        $begin_time,
        $end_time,
        $description,
        $app_type_id,
        $room_id,
        $class_id
      );

      $was_successful = get_db()->commit();
      if ($was_successful) {
        unset($_SESSION["old_begin_time"]);
        unset($_SESSION["old_end_time"]);
        unset($_SESSION["duration"]);
        unset($_SESSION["student_id"]);
        unset($_SESSION["edit_app_id"]);
        unset($_SESSION["date"]);
        unset($_SESSION["app_description"]);
        unset($_SESSION["app_type_id"]);
        unset($_SESSION["room_id"]);
        unset($_SESSION["class_id"]);
        unset($_SESSION["employee_id"]);
      }

      echo "<p>Ihr Termin wurde erfolgreich aktualisiert.</p><br>";
    } catch (PDOException $e) {
      get_db()->rollBack();
      echo "<p>Ihr Termin konnte nicht aktualisiert werden. Bitte versuchen Sie es erneut.</p><br>";
    }
    ?>

    <div>
      <p>Zurück zur <a href="appointmentManagement.php"> Terminverwaltung</a></p>
    </div>

  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>