<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../controllers/appointments.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<head>
  <link rel="stylesheet" href="/drive2future/assets/css/style.css">
</head>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <h1>Termin bearbeiten</h1>

  <?php
  if (isset($_POST["edit-app"])) {
    $edit_app_id = intval($_POST["edit-app"]);
  }

  $edit_app = (get_appointment($edit_app_id))[0];
  ?>

  <form action="editAppConfirmation.php" method="post">

    <!-- Datum ändern -->
    <div>
      <label for="date">Datum wählen: </label>
      <input type="date" id="date" name="date" value="<?php echo $edit_app["date"]; ?>" min="<?php echo $edit_app["date"]; ?>">
    </div>

    <!-- Beginnzeit ändern -->
    <div>
      <label>Beginnzeit angeben:</label>
      <input type="time" id="begin-time" name="begin-time" min="07:00" max="19:30" value="<?php echo $edit_app["begin_time"]; ?>">
    </div>

    <!-- Endzeit ändern -->
    <div>
      <label>Endzeit angeben:</label>
      <input type="time" id="end-time" name="end-time" min="07:30" max="20:00" value="<?php echo $edit_app["end_time"]; ?>">
    </div>

    <!-- Beschreibung ändern -->
    <div>
      <label for="app-description">Beschreibung:</label>
      <textarea name="app-description" id="app-description"><?php echo strval($edit_app["description"]); ?></textarea>
    </div>

    <!-- Raum wählen -->
    <div>
      <label for="room-id">Raum wählen:</label>
      <select name="room-id" id="room-id">
        <?php foreach ($rooms as $room) {
          $room_name = strval($room["room_name"]);
          $room_id = intval($room["id_room"]);
        ?>
          <option value='$room_id' <?php if ($room_id === intval($edit_app["rooms_id_room"])) { ?> 
            selected <?php } ?>> <?php $room_name ?> </option>";
        <?php } ?>
      </select>
    </div>

    <input type="submit" value="Änderungen speichern"> <input type="reset">
  </form>


  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>