<?php require_once __DIR__ . '/../lib/sessionHelper.php' ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>

  <?php foreach ($_SESSION['errors'] as $errors) : ?>
  <?php echo $errors . '<br />' ?>
  <?php endforeach ?>

  <form action="/controllers/register.php" method="POST">
    <label for="first_name">Vorname</label><br />
    <input id="first_name" type="text" name="first-name"><br /><br />
    <label for="last_name">Nachname</label><br />
    <input id="last_name" type="text" name="last-name"><br /><br />
    <label for="email">Email</label><br />
    <input id="email" type="email" name="email"><br /><br />
    <label for="passwd">Passwort</label><br />
    <input id="passwd" type="password" name="passwd"><br /><br />
    <label for="confirm_passwd">Passwort wiederholen</label><br />
    <input id="confirm_passwd" type="password" name="confirm-passwd"><br /><br />
    <input type="submit" value="Registrieren">
  </form>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>