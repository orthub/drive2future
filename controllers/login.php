<?php
require_once __DIR__ . '/../lib/sessionHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/views/login.php');
  exit();
}

if (isset($_SESSION['errors'])) {
  unset($_SESSION['errors']);
}

$valideEmail = false;
$validePassword = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
require_once __DIR__ . '/../models/login.php';

$email = htmlspecialchars($_POST["login-mail"]);
$check_email = filter_var($email, FILTER_VALIDATE_EMAIL);

$password = htmlspecialchars($_POST['login-passwd']);


if (empty($email)) {
  $_SESSION['errors']['email'] = 'Email erforderlich';
  header('Location: ' . '/drive2future/views/login.php');
}

if ($check_email === false) {
  $_SESSION['errors']['email'] = 'Bitte eine Valide Email-Adresse eingeben';
  header('Location: ' . '/drive2future/views/login.php');
}

if (!empty($password)) {
  $validePassword = true;
}

if (empty($password)) {
  $_SESSION['errors']['password'] = 'Passwort erforderlich';
  $validePassword = false;
}

$check_mail_exist = search_mail($email);
if ($check_mail_exist) {
  $valideEmail = true;
}

if ($valideEmail === true && $validePassword === true) {
  $match_mail_passwd = match_mail_password($email);
  
  
  if ($match_mail_passwd === false) {
      $_SESSION['errors']['login-fail'] = 'Benutzer oder Passwort stimmen nicht.';
      header('Location: ' . '/drive2future/views/login.php');
    }

    if ($match_mail_passwd) {
      $user_id = get_user_id($email);
      
      // bitte drinnen lassen sonst geht der code von anderen nicht mehr
      $_SESSION['user_id'] = $user_id;
      
      $_SESSION['user_session'] = $user_id . '_loggedIn';
      header('Location: ' . '/drive2future/views/appointments.php');
    }
  }
  if (!empty($_SESSION['errors'])) {
    header('Location: ' . '/drive2future/views/login.php');
  }
}