<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../controllers/appointments.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <div class="container">


    <h1>Termin bearbeiten</h1>

    <?php
    if (isset($_POST["edit-app"])) {
      $edit_app_id = intval($_POST["edit-app"]);
      $_SESSION["edit_app_id"] = $edit_app_id;
    }

    $edit_app = (get_appointment($edit_app_id))[0];
    ?>

    <form action="editAppStudent.php" method="post">
      <!-- Termintyp ändern -->
      <div>
        <label for="app-type-id">Termintyp wählen:</label>
        <select name="app-type-id" id="app-type-id">
          <?php foreach ($appointment_types as $app_t) {
            $type = strval($app_t["description"]);
            $type_id = intval($app_t["id_a_type"]);
            echo "<option value='$type_id'";
            if (intval($edit_app["appointment_types_id_a_type"]) === intval($type_id)) {
              echo "selected";
            }
            echo "> $type </option>";
          } ?>
        </select>
      </div>

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
        <input type="date" id="date" name="date" value="<?php echo $edit_app['date']; ?>" min="<?php echo date("Y-m-d", strtotime("+1 day")); ?>">
      </div>

      <!-- Dauer ändern -->
      <div>
        <label for="duration">Dauer angeben (in Min.): </label>
        <input type="number" id="duration" name="duration" value="30" step="30" min="30" max="780">
      </div>

      <!-- Klasse ändern -->
      <div>
        <label for="class-id">Klasse wählen:</label>
        <select name="class-id" id="class-id">
          <?php foreach ($classes as $class) {
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


      <input type="submit" value="Änderungen speichern"> <input type="reset">
    </form>
  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>