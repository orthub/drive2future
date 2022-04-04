<?php
// wenn keine session läuft, wird automatisch eine gestartet
require_once __DIR__ . '/../lib/sessionHelper.php';

// falls fehler session existiert, wird sie hier gelöscht
if (isset($_SESSION['errors'])) {
  unset($_SESSION['errors']);
}

// umleitung auf login, falls manuell versucht wird auf den controller zuzugreifen
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/drive2future/views/login.php');
  exit();
}

// wenn vom formular übermittelt wird diese bedingung ausgeführt
// wenn die eingaben fehler aufweisen, wird in das errors array eine 1 gesetzt für jeden
// gefundenen fehler. 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // setzen von benötigten variablen
  $errors = [];
  $emailExist = false;
  $matchPasswd = false;
  // filtern der übertragenen daten
  $loginEmail = filter_input(INPUT_POST, 'login-mail', FILTER_SANITIZE_EMAIL);
  $loginPasswd = filter_input(INPUT_POST, 'login-passwd');

  // validierung ob die email ein gültiges format hat
  if (!filter_var($loginEmail, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['errors']['login-mail-not-valid'] = 'Bitte geben sie eine gültige email ein';
    $errors[] = 1;
  }

  if ((bool)$loginEmail === false) {
    $_SESSION['errors']['login-mail'] = 'Bitte Email eingeben';
    $errors[] = 1;
  }
  if ((bool)$loginPasswd === false) {
    $_SESSION['errors']['login-passwd'] = 'Bitte Passwort eingeben';
    $errors[] = 1;
  }

  if ((bool)$loginEmail) {
    $_SESSION['loginEmail'] = $loginEmail;
  }
  if ((bool)$loginPasswd) {
    $_SESSION['loginPasswd'] = $loginPasswd;
  }

  if (count($errors) > 0) {
    header('Location: ' . '/drive2future/views/login.php#login_anker');
  }

  if (count($errors) === 0) {
    require_once __DIR__ . '/../models/login.php';
    
    $emailExist = search_mail($loginEmail, $loginPasswd);

    if ((bool)$emailExist === false) {
      $_SESSION['errors']['login-fail'] = 'Email oder Passwort stimmt nicht';
      $errors[] = 1;
    }
    
    if (count($errors) > 0) {
      header('Location: ' . '/drive2future/views/login.php#login_anker');
    }

    if ((bool)$emailExist) {
      $match = get_password_from_email($loginEmail);
      $isValidLogin = password_verify($loginPasswd, $match);
      
      if (!$isValidLogin) {
        $_SESSION['errors']['login-fail'] = 'Email oder Passwort stimmt nicht';
        header('Location: ' . '/drive2future/views/login.php#login_anker');
      }
  
      if ($isValidLogin) {
        $user_id = get_user_id($loginEmail);
        // bitte drinnen lassen sonst geht der code von anderen nicht mehr
        $_SESSION['user_id'] = $user_id;
    
        $_SESSION['user_session'] = $user_id . '_loggedIn';
        unset($_SESSION['loginEmail']);
        unset($_SESSION['loginPassword']);
        header('Location: ' . '/drive2future/views/appointments.php');
        exit();
      }
    }
  }
}