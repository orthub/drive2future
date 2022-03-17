<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once '../controllers/appointments.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>


<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <h1>Termin hinzufügen</h1>

    <?php
    if (isset($_SESSION["app_type_id"])) {
        $app_type_id = intval($_SESSION["app_type_id"]);
    }

    if (isset($_SESSION["room_id"])) {
        $room_id = intval($_SESSION["room_id"]);
    }

    if (isset($_SESSION["date"])) {
        $date = strval($_SESSION["date"]);
    }

    if (isset($_SESSION["class_id"])) {
        $class_id = intval($_SESSION["class_id"]);
    }

    if (isset($_SESSION["appDescription"])) {
        $description = strval($_SESSION["appDescription"]);
    }

    if (isset($_POST["begin-time"])) {
        $begin_time = strval($_POST["begin-time"]);
    }

    if (isset($_POST["end-time"])) {
        $end_time = strval($_POST["end-time"]);
    }

    if (isset($_SESSION["student_id"])) {
        $student_id = intval($_SESSION["student_id"]);
    }

    try {
        get_db()->beginTransaction();
        // Eingegebene/Ausgewählte Termininfos in Tabelle appointments speichern
        add_appointment(
            $date,
            $begin_time,
            $end_time,
            $description,
            $app_type_id,
            $room_id,
            $class_id
        );

        // ID des neuen Termins in Variable speichern
        $app_id = get_db()->lastInsertId();

        // Wurde ein Fahrschüler ausgewählt, wird der Datensatz erstellt
        if ($app_type_id === 3) {
            // Eintrag in user_has_appointments speichern
            add_user_appointment($student_id, $app_id);
        } else {
            // Termin für alle Schüler einer Klasse speichern
            add_class_appointment($class_id, $app_id);
        }

        get_db()->commit();
        echo "Ihr Termin wurde erfolgreich gespeichert.<br>";

    } catch (PDOException $e) {
        get_db()->rollBack();
        echo "Ihr Termin konnte nicht gespeichert werden. Bitte versuchen Sie es erneut.<br>";
    }
    ?>

    <div>
        Zurück zur <a href="appointmentManagement.php"> Terminverwaltung</a>
    </div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>