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
        <h1>Termin hinzufügen</h1>

        <?php
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

        if (isset($_SESSION["class_id"])) {
            $class_id = intval($_SESSION["class_id"]);
        }

        if (isset($_SESSION["app_description"])) {
            $description = strval($_SESSION["app_description"]);
        } else {
            $description = "";
        }

        if (isset($_POST["begin-time"])) {
            $begin_time = strval($_POST["begin-time"]);
        }
        if (isset($_SESSION["student_id"])) {
            $student_id = intval($_SESSION["student_id"]);
        }

        //Endzeit berechnen
        $end_time = transform_minutes_to_time(transform_time_to_minutes($begin_time) + $_SESSION['duration']);

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

            // Termin für Lehrer speichern
            add_user_appointment($user_id, $app_id);

            // Wurde ein Fahrschüler ausgewählt, wird der Datensatz erstellt
            if ($app_type_id === 3) {
                // Eintrag in user_has_appointments speichern
                add_user_appointment($student_id, $app_id);
            } else {
                // Termin für alle Schüler einer Klasse speichern
                add_class_appointment($class_id, $app_id);
            }

            $was_successful = get_db()->commit();
            if ($was_successful) {
                unset($_SESSION["date"]);
                unset($_SESSION["begin_time"]);
                unset($_SESSION["end_time"]);
                unset($_SESSION["description"]);
                unset($_SESSION["app_type_id"]);
                unset($_SESSION["room_id"]);
                unset($_SESSION["class_id"]);
            }

            echo "<p>Ihr Termin wurde erfolgreich gespeichert.</p><br>";
        } catch (PDOException $e) {
            get_db()->rollBack();
            echo "<p>Ihr Termin konnte nicht gespeichert werden. Bitte versuchen Sie es erneut.</p><br>";
        }
        ?>

        <div>
            <p>Zurück zur <a href="appointmentManagement.php"> Terminverwaltung</a></p>
        </div>
    </div>
    <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>