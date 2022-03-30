<?php 
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../lib/user_role.php';
if (!$user_admin) {
  header('Location: ' . '/drive2future');
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>

  <div class="container">
    <?php require_once __DIR__ . '/../lib/register_errors.php' ?>

    <h1><a name="reg-employee">Lehrer hinzufügen</a></h1>

    <form action="/drive2future/controllers/registerEmployee.php" method="POST">
      <label for="first_name">Vorname</label>
      <input id="first_name" type="text" name="first-name"
        value="<?php echo (isset($_SESSION['registerFirstname'])) ? $_SESSION['registerFirstname'] : ''?>">
      <label for="last_name">Nachname</label>
      <input id="last_name" type="text" name="last-name"
        value="<?php echo (isset($_SESSION['registerLastname'])) ? $_SESSION['registerLastname'] : ''?>">
      <label for="email">Email</label>
      <input id="email" type="email" name="email"
        value="<?php echo (isset($_SESSION['registerEmail'])) ? $_SESSION['registerEmail'] : ''?>">
      <label for="passwd">Passwort</label>
      <input id="passwd" type="password" name="passwd"
        value="<?php echo (isset($_SESSION['registerPassword'])) ? $_SESSION['registerPassword'] : ''?>">
      <label for="confirm_passwd">Passwort wiederholen</label>
      <input id="confirm_passwd" type="password" name="confirm-passwd">
      <input type="submit" value="Registrieren">
    </form>

  </div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>