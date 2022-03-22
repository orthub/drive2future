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
  <h1>Termin löschen</h1>

  <form action="chooseAppTime.php" method="post">

    <input type="submit" value="Weiter"> <input type="reset">
  </form>


  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>