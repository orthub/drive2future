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
    <h1>Termin hinzufügen</h1>

    <?php

    if (isset($_SESSION["appType"])) {
        $app_type = $_SESSION["appType"];

        $app_types_id_type = intval(get_app_type_id($app_type));
    }


    print_r($_POST);

    $date = strval($_POST["date"]);
    $begin_time = "08:00";
    $end_time = "16:00";
    $description = strval($_POST["appointment-description"]);

    // $app_types_id_type = 0;

    $room_id = intval(get_room_id(strval($_POST["rooms"])));
    $class_id = intval(get_class_id(strval($_POST["classes"])));


    if (add_appointment($date, $begin_time, $end_time, $description,
    $app_types_id_type, $room_id, $class_id)) {
        echo "Ihr Termin wurde erfolgreich gespeichert.<br>";
    } else {
        echo "Ihr Termin konnte nicht gespeichert werden. Bitte versuchen Sie es erneut.<br>";
    }

    ?>




    <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>