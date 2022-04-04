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
    <?php if (isset($_SESSION['new-employee'])) : ?>
      <?php echo '<p style="color: green"><b>' . $_SESSION['new-employee'] . '</b></p>';
      unset($_SESSION['new-employee']) ?>
    <?php endif ?>
    <h1>Terminübersicht</h1>

    <?php if ($user_employee || $user_student) : ?>
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
    <?php endif ?>

    <?php
    //print_r($allAppointments);
    ?>
    <?php if ($user_admin) : ?>
      
      <!--<div class="app-overview">hello
        <div class="app-item app-headlines">
          <div class="app-row">
            <div class="box-1">Datum</div>
            <div class="box-2">Beginn</div>
            <div class="box-3">Ende</div>
            <div class="box-4">Termin</div>
            <div class="box-5">Lehrer</div>
            <div class="box-6">Klasse/Schüler</div>
          </div>
        </div>

        <?php foreach ($allAppointments as $app) : ?>
          <div class="app-item">
            <div class="app-row">
              <div class="box-1"><span>Datum: </span><?php echo date('d.m.Y', strtotime($app['date'])) ?></div>
              <div class="box-2"><span>Beginn: </span><?php echo date('H:i', strtotime($app['begin_time'])) ?></div>
              <div class="box-3"><span>Ende: </span><?php echo date('H:i', strtotime($app['end_time'])) ?></div>
              <div class="box-4"><span>Termin: </span><?php echo $app['description']; ?></div>
              <div class="box-5"><span>Termin: </span><?php echo $app['description']; ?></div>
              <div class="box-6"><span>Termin: </span><?php echo $app['description']; ?></div>
            </div>
          </div>
        <?php endforeach ?>
      </div>-->

    <?php endif ?>

  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>