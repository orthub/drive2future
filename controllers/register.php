<?php
require_once __DIR__ . '/../lib/sessionHelper.php';

if (isset($_SESSION['errors'])) {
  unset($_SESSION['errors']);
}

$valideEmail = false;
$validePassword = false;
$email_exists_in_database = false;
$password_confirmed = false;

$first_name = htmlspecialchars($_POST['first-name']);
$last_name = htmlspecialchars($_POST['last-name']);
$email = htmlspecialchars($_POST["email"]);
$validate_email = filter_var($email, FILTER_VALIDATE_EMAIL);
$password = htmlspecialchars($_POST['passwd']);
$password_match = htmlspecialchars($_POST['confirm-passwd']);

if (empty($email)) {
  $_SESSION['errors']['email'] = 'Email erforderlich';
  header('Location: ' . '/drive2future/views/register.php');
  exit();
}

if ($validate_email === 'false') {
  $_SESSION['errors']['email'] = 'Bitte eine Valide Email-Adresse eingeben';
  header('Location: ' . '/drive2future/views/login.php');
  exit();
}


if (empty($password)) {
  $_SESSION['errors']['password'] = 'Passwort erforderlich';
}

if (!empty($_SESSION['errors'])) {
  header('Location: ' . '/drive2future/views/register.php');
}


if (mb_strlen($password) < 6) {
  $_SESSION['errors']['email'] = 'Passwort muss mindestens 6 Zeichen lang sein';
  header('Location: ' . '/drive2future/views/register.php');
}


require_once __DIR__ . '/../models/register.php';

$email_exists_already = search_if_email_exists_already();

foreach ($email_exists_already as $email) {
  if ($email['email'] === $validate_email) {
    $email_exists_in_database = true;
  }
}

if ($email_exists_in_database) {
  $_SESSION['errors']['email'] = 'Email kann nicht verwendet werden';
  header('Location: ' . '/drive2future/views/register.php');
}

if ($password === $password_match) {
  $password_confirmed = true;
}

if ($email_exists_in_database === false && $password_confirmed === true) {
  $create_new_user = create_new_user($first_name, $last_name, $validate_email, $password);
  if ($create_new_user) {
    header('Location: ' . '/drive2future/views/appointments.php');
  }
}