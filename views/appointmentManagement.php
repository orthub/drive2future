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
    <h1>Terminverwaltung</h1>

    <h2><a href="createAppointment.php">Termin hinzufügen +</a></h2>

    <div class="app-item app-headlines">
      <div class="app-row">
        <div class="box-1">Datum</div>
        <div class="box-2">Beginn</div>
        <div class="box-3">Ende</div>
        <div class="box-4">Termin</div>
        <div class="box-5">Bearbeiten</div>
        <div class="box-6">Löschen</div>
      </div>
    </div>

    <?php foreach ($appointments_for_user as $app) : ?>
    <div class="app-item">
      <div class="app-row">
        <div class="box-1"><span>Datum: </span><?php echo date('d.m.Y', strtotime($app['date'])); ?></div>
        <div class="box-2"><span>Beginn: </span><?php echo date('H:i', strtotime($app['begin_time'])); ?></div>
        <div class="box-3"><span>Ende: </span><?php echo date('H:i', strtotime($app['end_time'])); ?></div>
        <div class="box-4"><span>Termin: </span><?php echo $app['description']; ?></div>
        <div class="box-5">
          <form action="editAppointment.php" method="post">
            <button <?php echo "name='edit-app' value='$app[id_appointment]'" ?>>
              <a href="/drive2future">
                <img src="/drive2future/assets/img/edit_icon.png" width="20" />
              </a>
            </button>
          </form>
        </div>
        <div class="box-6">
          <form action="deleteAppConfirmation.php" method="post">
            <button <?php echo "name='delete-app' value='$app[id_appointment]'" ?>>
              <a href="/drive2future">
                <img src="/drive2future/assets/img/delete_icon.png" width="20" />
              </a>
            </button>
          </form>
        </div>
      </div>
    </div>
    <?php endforeach ?>

  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>