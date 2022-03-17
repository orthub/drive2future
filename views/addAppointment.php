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
    if (isset($_POST["student-id"])) {
        $_SESSION["student_id"] = $_POST["student-id"];
    }
    ?>

    <!-- Start- und Endzeit festlegen -->
    <form action="addAppConfirmation.php" method="post">
        <div>
            <label>Beginnzeit angeben:</label>
            <input type="time" id="begin-time" name="begin-time"
            min="07:00" max="19:30">
        </div>
        
        <div>
            <label>Endzeit angeben:</label>
            <input type="time" id="end-time" name="end-time"
            min="07:30" max="20:00">
        </div>
    <input type="submit" value="Termin hinzufügen"> <input type="reset">
    </form>


    <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>