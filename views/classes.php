<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../lib/user_role.php';
require_once __DIR__ . '/../controllers/classes.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>

  <div class="container">

    <h1><a name="Anker1">Klassenübersicht</h1>

    <?php
    if (isset($_SESSION['errors']['class']) && !empty($_SESSION['errors']['class'])) {
      echo "<p style='color:red'>" . $_SESSION['errors']['class'] . "</p>";
      unset($_SESSION['errors']['class']);
    }
    ?>
    <h2><a href="classAdd.php">Klasse hinzufügen +</a></h2>

    <div class="cl-item cl-headlines">
      <div class="cl-row">

        <div class="box-1">Bezeichnung</div>
        <div class="box-2">Status</div>
        <div class="box-3">Beginn</div>
        <div class="box-4">Ende</div>
        <div class="box-5">Schüler hinzufügen</div>

      </div>
    </div>

    <?php foreach ($classes as $class) : ?>
    <div class="cl-item">
      <div class="cl-row">
        <div class="box-1"><span>Bezeichnung: </span><?php echo $class['class_label']; ?></div>
        <div class="box-2"><span>Status: </span>
          <div class="status"><?php echo $class['status']; ?></div>
          <form action='../controllers/classes.php' method='POST'>
            <input type="submit" value="ändern" class="toggle">
            <input type="hidden" value="<?php echo $class['status']; ?>" name="status">
            <input type="hidden" value="<?php echo $class['id_class']; ?>" name="id">
          </form>

        </div>

        <div class="box-3"><span>Beginn: </span><?php echo date('d.m.Y', strtotime($class['begin_date'])) ?></div>
        <div class="box-4"><span>Ende: </span><?php echo date('d.m.Y', strtotime($class['end_date'])) ?></div>
        <div class="box-5">

          <span>Schüler hinzufügen: </span>
          <form action='../views/classesAddStudents.php#Anker1' method='POST'>
            <button type="submit" value="Schüler hinzufügen"><img src="/drive2future/assets/img/add_icon.png"
                width="20" /></button>
            <input type="hidden" value="<?php echo $class['id_class']; ?>" name="id">
            <input type="hidden" value="<?php echo $class['class_label']; ?>" name="label">
          </form>

        </div>
      </div>
    </div>
    <?php endforeach ?>
  </div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>