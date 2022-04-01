<?php
require_once __DIR__ . '/../lib/sessionHelper.php';

if (isset($_SESSION['errors'])) {
  unset($_SESSION['errors']);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/drive2future/views/register.php');
  exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $errors = [];
  $email_exists_in_database = true;
  $registerFirstname = filter_input(INPUT_POST, 'first-name', FILTER_SANITIZE_SPECIAL_CHARS);
  $registerLastname = filter_input(INPUT_POST, 'last-name', FILTER_SANITIZE_SPECIAL_CHARS);
  $registerEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $registerPassword = filter_input(INPUT_POST, 'passwd');
  $registerPasswordConfirm = filter_input(INPUT_POST, 'confirm-passwd');
  
  if((bool)$registerFirstname === false) {
    $_SESSION['errors']['register-firstname'] = 'Bitte Vornamen eingeben';
    $errors[] = 1;
  }
  if((bool)$registerLastname === false) {
    $_SESSION['errors']['register-lastname'] = 'Bitte Nachnamen eingeben';
    $errors[] = 1;
  }
  if((bool)$registerEmail === false) {
    $_SESSION['errors']['register-email'] = 'Bitte Email eingeben';
    $errors[] = 1;
  }
  if((bool)$registerPassword === false) {
    $_SESSION['errors']['register-password'] = 'Bitte Passwort eingeben';
    $errors[] = 1;
  }
  if((bool)$registerPasswordConfirm === false) {
    $_SESSION['errors']['register-password-confirm'] = 'Bestätigen sie ihr Passwort';
    $errors[] = 1;
  }

  if ((bool)$registerFirstname) {
    $_SESSION['registerFirstname'] = $registerFirstname;
  }
  if ((bool)$registerLastname) {
    $_SESSION['registerLastname'] = $registerLastname;
  }
  if ((bool)$registerEmail) {
    $_SESSION['registerEmail'] = $registerEmail;
  }
  if ((bool)$registerPassword) {
    $_SESSION['registerPassword'] = $registerPassword;
  }
  
  if (count($errors) > 0) {
    header('Location: ' . '/drive2future/views/register.php#reg-employee');
  }
  
  if (count($errors) === 0) {
    if (mb_strlen($registerPassword) < 8) {
      $_SESSION['errors']['register-password-length'] = 'Passwort muss mindestens 8 Zeichen lang sein';
      $errors[] = 1;
    }
    if ($registerPassword != $registerPasswordConfirm) {
      $_SESSION['errors']['password-not-confirmed'] = 'Passwörter stimmen nicht überein';
      $errors[] = 1;
    }
    
    if (count($errors) > 0) {
      header('Location: ' . '/drive2future/views/register.php#reg-employee');
    }
    
    if (count($errors) === 0) {
      
      require_once __DIR__ . '/../models/register.php';
      
      $email_exists_already = search_if_email_exists_already();
      
      foreach ($email_exists_already as $email) {
        if ($email['email'] === $registerEmail) {
          $email_exists_in_database = true;
          $_SESSION['errors']['can-not-use-email'] = 'Email kann nicht verwendet werden';
          $errors[] = 1;
        }
      }
      if (count($errors) > 0) {
        header('Location: ' . '/drive2future/views/register.php#reg-employee');
      }
      if (count($errors) === 0) {
        $create_new_user = create_new_employee($registerFirstname, $registerLastname, $registerEmail, $registerPassword);
        if ((bool)$create_new_user) {
          $_SESSION['new-employee'] = 'Account erfolgreich erstellt.';
          header('Location: ' . '/drive2future/views/appointments.php');
        }
      }  
    }
  }
}