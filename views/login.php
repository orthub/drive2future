<?php require_once __DIR__ . '/../lib/sessionHelper.php' ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <?php require_once __DIR__ . '/../lib/login_helper.php' ?>
  <div class="container">
    <h1>Login</h1>
    <form action="/drive2future/controllers/login.php" method="POST">
      <label for="login-mail">E-Mail</label><br />
      <input id="login-mail" type="email" name="login-mail"><br />
      <label for="login-passwd">Passwort</label><br />
      <input id="login-passwd" type="password" name="login-passwd"><br />
      <input type="submit" value="Anmelden">
    </form>
    <p>Noch keinen Account? Hier geht's zur <a href="/drive2future/views/register.php">Registrierung</a></p>
  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>