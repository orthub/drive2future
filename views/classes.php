<?php 
require_once __DIR__ . '/../lib/sessionHelper.php';
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

    <form action='../views/classAdd.php' method='POST'>
      <input type="submit" value="Klasse hinzufügen">
    </form>

    <br>  
    
    <div class="app-item ">
      <div class="app-row">
        
          <div class="box-1"><b>Bezeichnung</b></div>
          <div class="box-2"><b>Status</b></div>
          <div class="box-3"><b>Beginn</b></div>
          <div class="box-5"><b>Ende</b></div>
          <div class="box-5" style="width: auto"><b>Schüler hinzufügen</b></div>
        
      </div>
    </div>

    <?php foreach ($classes as $class) : ?>
      <div class="app-item">
        <div class="app-row">
          <div class="box-1"><span>Bezeichnung: </span><?php echo $class['class_label']; ?></div>
          <div class="box-2" style="float:left"><span>Status: </span><?php echo $class['status']; ?>

            <span>ändern: </span>
            <form action='../controllers/classes.php' method='POST' style="float:right; margin-right:15px">  
              <input type="submit" value="ändern">
              <input type="hidden" value="<?php echo $class['status']; ?>" name="status">
              <input type="hidden" value="<?php echo $class['id_class']; ?>" name="id">
            </form>

          </div>

          <div class="box-5"><span>Beginn: </span><?php echo date('d.m.Y',strtotime($class['begin_date'])) ?></div>
          <div class="box-5"><span>Ende: </span><?php echo date('d.m.Y',strtotime($class['end_date'])) ?></div>
          <div>

          <span>hinzufügen: </span>
            <form action='../views/classesAddStudents.php#Anker1' method='POST'>  
              <input type="submit" value="Schüler hinzufügen">
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