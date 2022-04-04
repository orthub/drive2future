<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../lib/user_role.php';
require_once '../controllers/appointments.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <div class="container">

    <?php
    if ($user_employee) { ?>
      <!-- Fahrlehrer kann nur Fahrstunden hinzufügen -->
      <h1>Fahrstunde hinzufügen</h1>
    <?php } else if ($user_admin) {  ?>
      <h1>Termin hinzufügen</h1>
    <?php }
    ?>

    <?php
    if (isset($_POST["student-id"])) {
      $_SESSION["student_id"] = $_POST["student-id"];
      $user_ids = [$_SESSION['student_id'], $_SESSION['user_id']];
    } else {
      $sql = "SELECT users_id_user FROM drive2future.class_has_users "
        . "WHERE class_id_class = :class_id";
      $stmt = get_db()->prepare($sql);
      $stmt->execute([':class_id' => $_SESSION['class_id']]);
      $user_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    ?>

    <!-- Start- und Endzeit festlegen -->
    <form action="addAppConfirmation.php" method="post">
      <div>
        <label>Beginnzeit angeben:</label>
        <select name="begin-time" id="begin-time">
          <?php
          //verfügbare Startzeiten berechnen
          $start_times = get_valid_appointment_times($_SESSION['date'], $_SESSION['duration'], $user_ids);
          foreach ($start_times as $start_time) {
            //Startzeiten in Select ausgeben
            $value = sprintf('%02d:%02d', ...explode(':', $start_time));
            echo "<option value=\"{$start_time}\">{$value}</option>";
          }
          ?>
        </select>
      </div>
      <input type="submit" value="Termin hinzufügen"> <input type="reset">
    </form>

  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>