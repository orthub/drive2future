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
    $class_students = get_active_class_students(intval($_POST["class-id"]));

    if (isset($_SESSION["edit_app_id"])) {
      // Aktuellen Fahrschüler aus der Datenbank holen
      $driving_student_app = get_driving_student_appointment($_SESSION["edit_app_id"])[0];
    }

    // Termintyp je nach Benutzerrolle setzen
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
    if (isset($_POST["employee-id"])) {
      $_SESSION["employee_id"] = intval($_POST["employee-id"]);
    }

    if (isset($_POST["room-id"])) {
      $_SESSION["room_id"] = intval($_POST["room-id"]);
    }

    if (isset($_POST["date"])) {
      $_SESSION["date"] = $_POST["date"];
    }

    if (isset($_POST["duration"])) {
      $_SESSION["duration"] = intval($_POST["duration"]);
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
      <form action="editStartTime.php" method="post">
        <!-- FahrschülerIn wählen -->
        <div>
          <label for="student-id">FahrschülerIn wählen:</label>
          <select name="student-id" id="student-id">
            <?php foreach ($class_students as $student) {
              $student_name = strval($student["last_name"])
                . " " . strval($student["first_name"]);
              $student_id = $student["id_user"];
              echo "<option value='$student_id' ";
              if ($student_id === intval($driving_student_app["users_id_user"])) {
                echo "selected";
              }
              echo "> $student_name </option>";
            } ?>
          </select>
        </div>
        <input type="submit" value="Weiter"> <input type="reset">
      </form>

      <?php
      ?>

      <!-- Weiterleitung bei Übung und Vortrag -->
    <?php } else if ($app_type_id === 1 || $app_type_id === 2) {
      header("Location: editStartTime.php");
    } ?>
  </div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>