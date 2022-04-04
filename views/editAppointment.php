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


    <?php
    if ($user_employee) { ?>
      <h1>Fahrstunde bearbeiten</h1>
    <?php } else if ($user_admin) {  ?>
      <h1>Termin bearbeiten</h1>
    <?php }
    ?>

    <?php
    $active_classes = get_active_classes();
    $employees = get_all_employees();

    if (isset($_POST["employee-id"])) {
      $_SESSION["employee_id"] = intval($_POST["employee-id"]);
    }

    if (isset($_POST["edit-app"])) {
      $edit_app_id = intval($_POST["edit-app"]);
      $_SESSION["edit_app_id"] = $edit_app_id;
    }

    // Fahrlehrer des zu bearbeitenden Termines aus der Datenbank holen
    $employee_appointment = get_employee_appointment($edit_app_id)[0];

    $edit_app = (get_appointment($edit_app_id))[0];
    $_SESSION["old_begin_time"] = $edit_app['begin_time'];
    $_SESSION["old_end_time"] = $edit_app['end_time'];

    $old_duration = transform_time_to_minutes($edit_app['end_time']) - transform_time_to_minutes($edit_app['begin_time']);
    ?>

    <form action="editAppStudent.php" method="post">
      <!-- FahrlehrerIn ändern -->
      <?php
      // Admin kann eine/n anderen Fahrlehrer für Vortrag und Übung auswählen
      if ($user_admin) { ?>
        <div>
          <label for="employee-id">FahrlehrerIn wählen:</label>
          <select name="employee-id" id="employee-id">
            <?php foreach ($employees as $employee) {
              $employee_name = strval($employee["last_name"])
                . " " . strval($employee["first_name"]);
              $employee_id = intval($employee["id_user"]);
              echo "<option value='$employee_id'";
              if ($employee_id === intval($employee_appointment["users_id_user"])) {
                echo "selected";
              }
              echo "> $employee_name </option>";
            } ?>
          </select>
        </div>
      <?php } ?>

      <!-- Termintyp wählen -->
      <?php
      // Admin kann Vorträge und Übungen hinzufügen
      if ($user_admin) { ?>
        <div>
          <label for="app-type-id">Termintyp wählen:</label>
          <select name="app-type-id" id="app-type-id">
            <?php foreach ($appointment_types as $app_t) {
              $type = strval($app_t["description"]);
              $type_id = intval($app_t["id_a_type"]);
              if ($type_id !== 3) {
                echo "<option value='$type_id'> $type </option>";
              }
            } ?>
          </select>
        </div>
      <?php } ?>

      <!-- Raum ändern -->
      <div>
        <label for="room-id">Raum wählen:</label>
        <select name="room-id" id="room-id">
          <?php foreach ($rooms as $room) {
            $room_name = strval($room["room_name"]);
            $room_id = intval($room["id_room"]);
            echo "<option value='$room_id'";
            if ($room_id === intval($edit_app["rooms_id_room"])) {
              echo "selected";
            }
            echo "> $room_name </option>";
          } ?>
        </select>
      </div>

      <!-- Datum ändern -->
      <div>
        <label for="date">Datum wählen: </label>
        <input type="date" id="date" name="date" required value="<?php echo $edit_app['date']; ?>" min="<?php echo date("Y-m-d"); ?>">
      </div>

      <!-- Dauer ändern -->
      <div>
        <label for="duration">Dauer angeben (in Min.): </label>
        <input type="number" id="duration" name="duration" value="<?php echo $old_duration; ?>" step="30" min="30" max="780">
      </div>

      <!-- Klasse ändern -->
      <div>
        <label for="class-id">Führerscheinklasse wählen:</label>
        <select name="class-id" id="class-id">
          <?php foreach ($active_classes as $class) {
            $class_name = strval($class["class_label"]);
            $class_id = $class["id_class"];
            echo "<option value='$class_id'";
            if (intval($edit_app["class_id_class"]) === intval($class_id)) {
              echo "selected";
            }
            echo "> $class_name </option>";
          } ?>
        </select>
      </div>

      <!-- Beschreibung ändern -->
      <div>
        <label for="app-description">Beschreibung:</label>
        <textarea name="app-description" id="app-description"><?php echo strval($edit_app["description"]); ?></textarea>
      </div>


      <input type="submit" value="Weiter"> <input type="reset">
    </form>
  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>