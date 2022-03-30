<?php require_once __DIR__ . '/../lib/sessionHelper.php' ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <div class="container">
    <?php require_once __DIR__ . '/../lib/login_errors.php' ?>
    <h1>Login</h1>
    <form action="/drive2future/controllers/login.php" method="POST">
      <label for="login-mail">E-Mail</label>
      <input id="login-mail" type="email" name="login-mail"
        value="<?php echo (isset($_SESSION['loginEmail'])) ? $_SESSION['loginEmail'] : ''?>">
      <label for=" login-passwd">Passwort</label>
      <input id="login-passwd" type="password" name="login-passwd"
        value="<?php echo (isset($_SESSION['loginPasswd'])) ? $_SESSION['loginPasswd'] : ''?>">
      <input type="submit" value="Anmelden">
    </form>
    <p>Noch keinen Account? Hier geht's zur <a href="/drive2future/views/register.php">Registrierung</a></p>
  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>