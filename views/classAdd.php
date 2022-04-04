<?php 
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../lib/user_role.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>

  <div class="container">
    <h1>Klasse hinzufügen</h1>

    <?php
        $now = time();
        $addDays = time() + (7);
        if (isset($_SESSION['errors']['class']) && !empty($_SESSION['errors']['class'])) {
            echo "<p style='color:red'>" . $_SESSION['errors']['class'] . "</p>";
            unset($_SESSION['errors']['class']);
        }
    ?>

    <form action='../controllers/classes.php' method='POST'>
      <input type="hidden" name="isNewClass" value="true">

      <label>Bezeichnung:</label>
      <input type="text" name="bezeichnung">
      <br>

      <label>Beginn Datum:</label>
      <input type="date" name="beginn_date" required value="<?php echo date("Y-m-d");?>" min="<?php echo date("Y-m-d"); ?>">
      <br>

      <label>End Datum:</label>
      <input type="date" name="end_date" required value="<?php echo date("Y-m-d", strtotime("+1 day"));?>" min="<?php echo date("Y-m-d", strtotime("+1 day")); ?>">
      <br>

      <input type="submit" value="Hinzufügen" class="smallbutton">


    </form>

  </div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>