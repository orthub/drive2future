<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../controllers/appointments.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<head>
    <link rel="stylesheet" href="/drive2future/assets/css/style.css">
</head>

<body>
    <?php require_once __DIR__ . '/partials/navbar.php' ?>
    <h1>Terminverwaltung</h1>

    <a href="createAppointment.php">
        <h3>Termin hinzufügen</h3>
    </a>
    <table>
        <thead>
            <th>Datum</th>
            <th>Beginn</th>
            <th>Ende</th>
            <th>Termin</th>
            <th></th>
            <th></th>

        </thead>
        <tbody>

            <?php foreach ($appointments as $app) : ?>
                <form action="editAppointment.php" method="post">
                    <tr>
                        <td><?php echo $app['date']; ?></td>
                        <td><?php echo $app['begin_time']; ?></td>
                        <td><?php echo $app['end_time']; ?></td>
                        <td><?php echo $app['description']; ?></td>
                        <td><?php echo "<button name='edit-app' 
                        value='$app[id_appointment]'> edit </button>" ?></td>
                        <td><?php echo "delete"; ?></td>
                    </tr>
                </form>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>