<?php require_once __DIR__ . '/../lib/sessionHelper.php' ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <h1>Login</h1>
  <form action="/controllers/login.php" method="POST">
    <label for="login-mail">Email</label><br />
    <input id="login-mail" type="email" name="login-mail"><br />
    <label for="login-passwd">Passwort</label><br />
    <input id="login-passwd" type="password" name="login-passwd"><br />
    <input type="submit" value="Anmelden">
  </form>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>