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
  <div class="container">
    <h1>Terminübersicht</h1>

    <div class="app-overview">
      <div class="app-item app-headlines">
        <div class="app-row">
          <div class="box-1">Datum</div>
          <div class="box-2">Beginn</div>
          <div class="box-3">Ende</div>
          <div class="box-4">Termin</div>
        </div>
      </div>

      <?php foreach ($appointments_for_user as $app) : ?>
        <div class="app-item">
          <div class="app-row">
            <div class="box-1"><span>Datum: </span><?php echo date('d.m.Y', strtotime($app['date'])) ?></div>
            <div class="box-2"><span>Beginn: </span><?php echo date('H:i', strtotime($app['begin_time'])) ?></div>
            <div class="box-3"><span>Ende: </span><?php echo date('H:i', strtotime($app['end_time'])) ?></div>
            <div class="box-4"><span>Termin: </span><?php echo $app['description']; ?></div>
          </div>
        </div>
      <?php endforeach ?>
    </div>



  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>