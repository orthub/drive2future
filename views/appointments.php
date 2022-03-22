<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../controllers/appointments.php';
require_once __DIR__ . '/../lib/user_role.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <h1>Terminübersicht</h1>

  <div class="container">
    <div class="app-item ">
      <div class="app-row">
        <div class="box-1">Datum</div>
        <div class="box-2">Beginn</div>
        <div class="box-3">Ende</div>
        <div class="box-4">Termin</div>
      </div>
    </div>

    <?php foreach ($appointments as $app) : ?>
      <div class="app-item">
        <div class="app-row">
          <div class="box-1"><span>Datum: </span><?php echo $app['date']; ?></div>
          <div class="box-2"><span>Beginn: </span><?php echo $app['begin_time']; ?></div>
          <div class="box-3"><span>Ende: </span><?php echo $app['end_time']; ?></div>
          <div class="box-4"><span>Termin: </span><?php echo $app['description']; ?></div>
        </div>
      </div>
    <?php endforeach ?>

  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>