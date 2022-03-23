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
    <h1>Termin löschen</h1>

    <form action="chooseAppTime.php" method="post">

      <input type="submit" value="Weiter"> <input type="reset">
    </form>
  </div>



  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>