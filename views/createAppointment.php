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


    <h1>Termin hinzufügen</h1>

    <form action="chooseAppTime.php" method="post">
      <!-- Termintyp wählen -->
      <div>
        <label for="app-type-id">Termintyp wählen:</label>
        <select name="app-type-id" id="app-type-id">
          <?php foreach ($appointment_types as $app_t) {
            $type = strval($app_t["description"]);
            $type_id = intval($app_t["id_a_type"]);
            echo "<option value='$type_id'> $type </option>";
          } ?>
        </select>
      </div>
      <!-- Raum wählen -->
      <div>
        <label for="room-id">Raum wählen:</label>
        <select name="room-id" id="room-id">
          <?php foreach ($rooms as $room) {
            $room_name = strval($room["room_name"]);
            $room_id = intval($room["id_room"]);
            echo "<option value='$room_id'> $room_name </option>";
          } ?>
        </select>
      </div>

      <!-- Datum wählen -->
      <div>
        <label for="date">Datum wählen: </label>
        <input type="date" id="date" name="date" required value="<?php echo date("Y-m-d", strtotime("+1 day")); ?>"
          min="<?php echo date("Y-m-d", strtotime("+1 day")); ?>">
      </div>

      <!-- Dauer wählen -->
      <div>
        <label for="duration">Dauer angeben (in Min.): </label>
        <input type="number" id="duration" name="duration" value="30" step="30" min="30" max="780">
      </div>

      <!-- Klasse wählen -->
      <div>
        <label for="class-id">Klasse wählen:</label>
        <select name="class-id" id="class-id">
          <?php foreach ($classes as $class) {
            $class_name = strval($class["class_label"]);
            $class_id = $class["id_class"];
            echo "<option value='$class_id'> $class_name </option>";
          } ?>
        </select>
      </div>

      <!-- Beschreibung eingeben -->
      <div>
        <label for="app-description">Beschreibung:</label>
        <textarea name="app-description" id="app-description"></textarea>
      </div>

      <input type="submit" value="Weiter"> <input type="reset">
    </form>

  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>