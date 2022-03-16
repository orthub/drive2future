<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once '../controllers/appointments.php';
$rooms = get_rooms();
$classes = get_classes();
$students = get_students();
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
    if (isset($_POST["appointmentTypes"])) {
        $app_type = strval($_POST["appointmentTypes"]);
        $_SESSION["appType"] = $app_type;
    } ?>

    <form action="addAppConfirmation.php" method="post">

        <!-- Raum wählen -->
        <div>
            <label for="rooms">Raumbezeichnung wählen:</label>
            <select name="rooms" id="rooms">
                <?php foreach ($rooms as $room) {
                    $room = strval($room["room_name"]);
                    echo "<option value='$room'> $room </option>";
                } ?>
            </select>
        </div>

        <!-- Zeit wählen -->
        <div>
            <label for="date">Tag wählen: </label>
            <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>">
        </div>

        <!-- Klasse wählen -->
        <div>
            <label for="classes">Klasse wählen:</label>
            <select name="classes" id="classes">
                <?php foreach ($classes as $class) {
                    $class = strval($class["class_label"]);
                    echo "<option value='$class'> $class </option>";
                } ?>
            </select>
        </div>

        <?php if ($app_type === "Fahrstunde") { ?>
            <!-- FahrschülerIn wählen -->
            <div>
                <label for="students">FahrschülerIn wählen:</label>
                <select name="students" id="students">
                    <?php foreach ($students as $student) {
                        $student = strval($student["last_name"])
                            . " " . strval($student["first_name"]);
                        echo "<option value='$student'> $student </option>";
                    } ?>
                </select>
            </div>
        <?php } ?>

        <!-- Beschreibung eingeben -->
        <div>
            <label for="app-description">Beschreibung:</label>
            <textarea name="appointment-description" id="app-description"></textarea>
        </div>

        <input type="submit" value="Termin hinzufügen"> <input type="reset">
    </form>


    <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>