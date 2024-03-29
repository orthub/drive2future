<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../lib/user_role.php';
require_once __DIR__ . '/../controllers/appointments.php';
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

    <?php if ($user_admin) : ?>
      
      <div class="admin-overview">
        <div class="app-item app-headlines">
          <div class="app-row">
            <div class="box-1"><p>Datum</p></div>
            <div class="box-2"><p>Beginn</p></div>
            <div class="box-3"><p>Ende</p></div>
            <div class="box-4"><p>Termin</p></div>
            <div class="box-5"><p>Lehrer</p></div>
            <div class="box-6"><p>Klasse/Schüler</p></div>
          </div>
        </div>

        <?php foreach (fetch_appointments_overview() as $app) : ?>
          <div class="app-item">
            <div class="app-row">
              <div class="box-1"><span>Datum: </span><?php echo date('d.m.Y', strtotime($app['date'])) ?></p></div>
              <div class="box-2"><span>Beginn: </span><p><?php echo date('H:i', strtotime($app['begin_time'])) ?></p></div>
              <div class="box-3"><span>Ende: </span><p><?php echo date('H:i', strtotime($app['end_time'])) ?></p></div>
              <div class="box-4"><span>Termin: </span><p><?php echo $app['description']; ?></p></div>
              <div class="box-5"><span>Lehrer: </span><p><?php echo "${app['teacher_first_name']} ${app['teacher_last_name']}"; ?></p></div>
              <div class="box-6"><span>Schüler/Klasse: </span><p><?php 
                if($app['appointment_types_id_a_type'] == 3 ){
                  echo "${app['student_first_name']} ${app['student_last_name']}";
                } else{
                  echo $app['class_label'];
                }
              ?></p></div>
            </div>
          </div>
        <?php endforeach ?>
      </div>

    <?php endif ?>

  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>