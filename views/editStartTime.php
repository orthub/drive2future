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
      <h1>Fahrstunde bearbeiten</h1>
    <?php } else if ($user_admin) {  ?>
      <h1>Termin bearbeiten</h1>
    <?php }
    ?>

    <?php
    if ($user_admin) {
      $sql = "SELECT users_id_user FROM drive2future.class_has_users "
        . "WHERE class_id_class = :class_id";
      $stmt = get_db()->prepare($sql);
      $stmt->execute([':class_id' => $_SESSION['class_id']]);
      $user_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
      $user_ids[] = $_SESSION["employee_id"];
    } else {
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
    }
    ?>

    <!-- Start- und Endzeit festlegen -->
    <form action="editAppConfirmation.php" method="post">
      <div>
        <label>Beginnzeit angeben:</label>
        <select name="begin-time" id="begin-time" selected="<?php $_SESSION["old_begin_time"] ?>">
          <?php
          //verfügbare Startzeiten berechnen
          $start_times = get_valid_appointment_times($_SESSION['date'], $_SESSION['duration'], $user_ids, $_SESSION["old_begin_time"]);
          foreach ($start_times as $start_time) {
            //Startzeiten in Select ausgeben
            $value = sprintf('%02d:%02d', ...explode(':', $start_time));
            //Wenn Startzeit der ursprünglichen Startzeit entspricht, Parameter selected zu option hinzufügen (vorausgewählt)
            if ($start_time ==  $_SESSION["old_begin_time"]) {
              echo "<option value=\"{$start_time}\" selected>{$value}</option>";
            }
            //Startzeit als option ausgeben
            else {
              echo "<option value=\"{$start_time}\">{$value}</option>";
            }
          }
          ?>
        </select>
      </div>
      <input type="submit" value="Änderungen speichern"> <input type="reset">
    </form>

  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>