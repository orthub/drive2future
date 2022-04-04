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

    <?php
    $class_students = get_active_class_students(intval($_POST["class-id"]));

    if ($user_employee) {
      $app_type_id = 3;
      $_SESSION["app_type_id"] = $app_type_id;
    } else if ($user_admin) {
      if (isset($_POST["app-type-id"])) {
        $app_type_id = intval($_POST["app-type-id"]);
        $_SESSION["app_type_id"] = $app_type_id;
      }
    }

    // Eingegebene Werte in Session speichern

    if (isset($_POST["room-id"])) {
      $_SESSION["room_id"] = intval($_POST["room-id"]);
    }

    if (isset($_POST["date"])) {
      $_SESSION["date"] = $_POST["date"];
    }

    if (isset($_POST["duration"])) {
      $_SESSION["duration"] = $_POST["duration"];
    }

    if (isset($_POST["class-id"])) {
      $_SESSION["class_id"] = intval($_POST["class-id"]);
    }

    if (isset($_POST["app-description"]) && !empty($_POST["app-description"])) {
      $_SESSION["app_description"] = $_POST["app-description"];
    }
    ?>

    <!-- Termintyp überprüfen -->
    <?php if ($app_type_id === 3) { ?>
      <form action="addAppointment.php" method="post">
        <!-- FahrschülerIn wählen -->
        <div>
          <label for="student-id">FahrschülerIn wählen:</label>
          <select name="student-id" id="student-id">
            <?php foreach ($class_students as $student) {
              $student_name = strval($student["last_name"])
                . " " . strval($student["first_name"]);
              $student_id = $student["id_user"];
              echo "<option value='$student_id'> $student_name </option>";
            } ?>
          </select>
        </div>
        <input type="submit" value="Weiter"> <input type="reset">
      </form>

      <!-- Weiterleitung bei Übung und Vortrag -->
    <?php } else if ($app_type_id === 1 || $app_type_id === 2) {
      header("Location: addAppointment.php");
    } ?>
  </div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>