<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once '../controllers/appointments.php';
$appointment_types = get_appointment_types();
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
    
    <form action="addAppointment.php" method="post">
    <!-- Termintyp wählen -->
    <div>
        <label for="appointmentType">Termintyp wählen:</label>
        <select name="appointmentTypes" id="appointmentTypes">
            <?php foreach ($appointment_types as $app_t) {
                $type = strval($app_t["description"]);
                echo "<option value='$type'> $type </option>";
            } ?>
        </select>
    </div>
    
        <input type="submit" value="Weiter"> <input type="reset">
    </form>


    <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>