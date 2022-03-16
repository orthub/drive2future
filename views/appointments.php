<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../controllers/appointments.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <h1>Terminübersicht</h1>
  <table>
    <thead>
      <th>Datum</th>
      <th>Beginn</th>
      <th>Ende</th>
      <th>Termin</th>
    </thead>
    <tbody>
      <?php foreach ($appointments as $app) : ?>
        <tr>
          <td><?php echo $app['date']; ?></td>
          <td><?php echo $app['begin_time']; ?></td>
          <td><?php echo $app['end_time']; ?></td>
          <td><?php echo $app['description']; ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>