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


    <h1>Termin bearbeiten</h1>

    <?php

    if (isset($_SESSION["edit_app_id"])) {
      $edit_app_id = intval($_SESSION["edit_app_id"]);
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

    if (isset($_POST["start-time"])) {
      $start_time = $_POST["start-time"];
    }

    $end_time = "13:00";

    try {
      get_db()->beginTransaction();
      // Noch aktuelle Daten des Termines aus Datenbank holen
      $old_app = (get_appointment($edit_app_id))[0];

      // Bleibt der Termintyp bei "Fahrstunde" kann trotzdem ein anderer Schüler ausgewählt werden
      // Falls anderer Termintyp oder andere Klasse gewählt wurde, Datensätze aus anderen Tabellen auch aktualisieren
      if (
        intval($app_type_id === 3) ||
        intval($old_app["appointment_types_id_a_type"]) !== $app_type_id ||
        intval($old_app["class_id_class"]) !== $class_id
      ) {

        delete_class_appointment($old_app["class_id_class"], $edit_app_id);

        // Wurde ein Fahrschüler ausgewählt, wird der Termin für ihn hinzugefügt
        if ($app_type_id === 3) {
          // Eintrag in user_has_appointments speichern
          add_user_appointment($student_id, $edit_app_id);
        } else {
          // Termin für alle Schüler einer Klasse aktualisieren
          update_class_appointment($class_id, $edit_app_id);
        }
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
        unset($_SESSION["edit_app_id"]);
        unset($_SESSION["date"]);
        unset($_SESSION["start_time"]);
        unset($_SESSION["end_time"]);
        unset($_SESSION["app_description"]);
        unset($_SESSION["app_type_id"]);
        unset($_SESSION["app_description"]);
        unset($_SESSION["room_id"]);
        unset($_SESSION["class_id"]);
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