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

    <h1>Klassenübersicht</h1>

    <form action='../views/classAdd.php' method='POST'>
      <label>neue Klasse:</label>
      <input type="submit" value="hinzufügen">
    </form>

    <br>  
    
    <div class="app-item ">
      <div class="app-row">
        
          <div class="box-1"><b>Bezeichnung</b></div>
          <div class="box-2"><b>Status</b></div>
          <div class="box-3"><b>Beginn</b></div>
          <div class="box-4"><b>Ende</b></div>
        
      </div>
    </div>

    <?php foreach ($classes as $class) : ?>
      <div class="app-item">
        <div class="app-row">
          <div class="box-1"><span>Bezeichnung: </span><?php echo $class['class_label']; ?></div>
          <div class="box-2"><span>Status: </span><?php echo $class['status']; ?></div>
          <div class="box-3"><span>Beginn: </span><?php echo date('d.m.Y',strtotime($class['begin_date'])) ?></div>
          <div class="box-4"><span>Ende: </span><?php echo date('d.m.Y',strtotime($class['end_date'])) ?></div>
        </div>
      </div>
    <?php endforeach ?>
  </div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>