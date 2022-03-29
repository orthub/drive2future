<?php
require_once __DIR__ . '/../lib/sessionHelper.php';


if (isset($_SESSION['errors'])) {
  unset($_SESSION['errors']);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/views/login.php');
  exit();
}

$emailExist = false;
$matchPasswd = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $loginEmail = htmlspecialchars($_POST['login-mail']);
  $filteredEmail = filter_var($loginEmail, FILTER_VALIDATE_EMAIL);
  $loginPasswd = trim($_POST['login-passwd']);

  if (!isset($filteredEmail) || empty($loginEmail)) {
    $_SESSION['errors']['login-mail'] = 'Bitte Email eingeben';
    header('Location: ' . '/drive2future/views/login.php');
    exit();
  }

  if (!isset($loginPasswd) || empty($loginPasswd)) {
    $_SESSION['errors']['login-passwd'] = 'Bitte Passwort eingeben';
    header('Location: ' . '/drive2future/views/login.php');
    exit();
  }

  require_once __DIR__ . '/../models/login.php';

  $emailExist = search_mail($filteredEmail, $loginPasswd);

  if (!$emailExist) {
    $_SESSION['errors']['login-fail'] = 'Email oder Passwort stimmen nicht';
    header('Location: ' . '/drive2future/views/login.php');
    exit();
  }

  if ($emailExist) {
    $matchPasswd = match_mail_password($filteredEmail, $loginPasswd);

    if (!$matchPasswd) {
      $_SESSION['errors']['login-fail'] = 'Email oder Passwort stimmen nicht';
      header('Location: ' . '/drive2future/views/login.php');
      exit();
    }

    if ($matchPasswd) {
      $user_id = get_user_id($filteredEmail);
      // bitte drinnen lassen sonst geht der code von anderen nicht mehr
      $_SESSION['user_id'] = $user_id;
  
      $_SESSION['user_session'] = $user_id . '_loggedIn';
      header('Location: ' . '/drive2future/views/appointments.php');
      exit();
    }
  header('Location: ' . '/drive2future/views/login.php');
  exit();
  }
}