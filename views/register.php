<?php require_once __DIR__ . '/../lib/sessionHelper.php' ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>

  <?php if (!empty($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $errors) : ?>
      <?php echo $errors . '<br />' ?>
    <?php endforeach ?>
  <?php endif ?>

  <div class="container">


    <form action="/drive2future/controllers/register.php" method="POST">
      <label for="first_name">Vorname</label>
      <input id="first_name" type="text" name="first-name">
      <label for="last_name">Nachname</label>
      <input id="last_name" type="text" name="last-name">
      <label for="email">Email</label>
      <input id="email" type="email" name="email">
      <label for="passwd">Passwort</label>
      <input id="passwd" type="password" name="passwd">
      <label for="confirm_passwd">Passwort wiederholen</label>
      <input id="confirm_passwd" type="password" name="confirm-passwd">
      <input type="submit" value="Registrieren">
    </form>
  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>