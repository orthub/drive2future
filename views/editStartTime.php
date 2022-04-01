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


        <h1>Termin bearbeiten</h1>

        <?php
        if (isset($_POST["student-id"])) {
            $_SESSION["student_id"] = intval($_POST["student-id"]);
        }

    print_r($_SESSION);

        ?>

        <!-- Start- und Endzeit festlegen -->
        <form action="editAppConfirmation.php" method="post">
            <div>
                <label>Beginnzeit angeben:</label>
                <select name="begin-time" id="begin-time">
                    <?php
                    $start_times = get_valid_appointment_times($_SESSION['date'], $_SESSION['duration'], [$_SESSION['user_id'], $_SESSION["student_id"]]);
                    foreach ($start_times as $start_time) {
                        $value = sprintf('%02d:%02d', ...explode(':', $start_time));
                        echo "<option value=\"{$start_time}\">{$value}</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="submit" value="Beginnzeit ändern"> <input type="reset">
        </form>

    </div>
    <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>