<?php
require_once __DIR__ . '/../lib/sessionHelper.php';

if (isset($_SESSION['errors'])) {
  unset($_SESSION['errors']);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/views/register.php');
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
    header('Location: ' . '/drive2future/views/register.php');
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
      header('Location: ' . '/drive2future/views/register.php');
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
        header('Location: ' . '/drive2future/views/register.php');
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
  /*



  if ($email_exists_in_database === false && $password_confirmed === true) {
    $create_new_user = create_new_user($first_name, $last_name, $filteredEmail, $password);
  
    if ($create_new_user) {
      $errors[] = 'Benutzer erfolgreich erstellt. Sie können sich nun einloggen.';
      // header('Location: ' . '/drive2future/views/login.php');
      // exit();
    }
    $errors[] = 'Fehler bei der Registrierung, bitte versuchen sie es später wieder';
    // header('Location: ' . '/drive2future/views/register.php');
    // exit();
  }
  if (isset($_SESSION['errors'])) {
    header('Loscation: ' . '/drive2future/views/register.php');
    exit();
  }

  $hasErrors = count($errors) > 0;
  

}

*/

// $valideEmail = false;
// $validePassword = false;
// $email_exists_in_database = false;
// $password_confirmed = false;

// $first_name = htmlspecialchars($_POST['first-name']);
// $last_name = htmlspecialchars($_POST['last-name']);
// $email = htmlspecialchars($_POST["email"]);
// $validate_email = filter_var($email, FILTER_VALIDATE_EMAIL);
// $password = htmlspecialchars($_POST['passwd']);
// $password_match = htmlspecialchars($_POST['confirm-passwd']);

// if (empty($email)) {
//   $_SESSION['errors']['email'] = 'Email erforderlich';
//   header('Location: ' . '/drive2future/views/register.php');
//   exit();
// }

// if ($validate_email === 'false') {
//   $_SESSION['errors']['email'] = 'Bitte eine Valide Email-Adresse eingeben';
//   header('Location: ' . '/drive2future/views/login.php');
//   exit();
// }


// if (empty($password)) {
//   $_SESSION['errors']['password'] = 'Passwort erforderlich';
// }

// if (!empty($_SESSION['errors'])) {
//   header('Location: ' . '/drive2future/views/register.php');
// }


// if (mb_strlen($password) < 6) {
//   $_SESSION['errors']['email'] = 'Passwort muss mindestens 6 Zeichen lang sein';
//   header('Location: ' . '/drive2future/views/register.php');
// }


// require_once __DIR__ . '/../models/register.php';

// $email_exists_already = search_if_email_exists_already();

// foreach ($email_exists_already as $email) {
//   if ($email['email'] === $validate_email) {
//     $email_exists_in_database = true;
//   }
// }

// if ($email_exists_in_database) {
//   $_SESSION['errors']['email'] = 'Email kann nicht verwendet werden';
//   header('Location: ' . '/drive2future/views/register.php');
// }

// if ($password === $password_match) {
//   $password_confirmed = true;
// }

// if ($email_exists_in_database === false && $password_confirmed === true) {
//   $create_new_user = create_new_user($first_name, $last_name, $validate_email, $password);
//   if ($create_new_user) {
//     header('Location: ' . '/drive2future/views/login.php');
//   }
// }