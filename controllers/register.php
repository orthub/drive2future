<?php
require_once __DIR__ . '/../lib/sessionHelper.php';

// falls fehler in der session vorhanden sind, wird diese hier gelöscht
if (isset($_SESSION['errors'])) {
  unset($_SESSION['errors']);
}

// falls mit GET aufgerufen wird umgeleitet zur registrierung
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/drive2future/views/register.php');
  exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // setzen benötigter variablen für überprüfung und fehlermeldungen
  $errors = [];
  $email_exists_in_database = true;
  
  // filtern der übergebenen daten vom registrierungsformular
  $registerFirstname = filter_input(INPUT_POST, 'first-name', FILTER_SANITIZE_SPECIAL_CHARS);
  $registerLastname = filter_input(INPUT_POST, 'last-name', FILTER_SANITIZE_SPECIAL_CHARS);
  $registerEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $registerPassword = filter_input(INPUT_POST, 'passwd');
  $registerPasswordConfirm = filter_input(INPUT_POST, 'confirm-passwd');
  
  // falls eines der felder leer ist, wird eine entsprechende fehlermeldung in die passende
  // session gesetzt und dem $errors array ein feld hinzugefügt
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

  // setzen der übergebenen eingabe in die session um bei fehlern den inhalt der session
  // in die formularfelder schreiben zu können
  if ((bool)$registerFirstname) {
    $_SESSION['registerFirstname'] = $registerFirstname;
  }
  if ((bool)$registerLastname) {
    $_SESSION['registerLastname'] = $registerLastname;
  }
  
  // validierung ob die eingabe eine email ist
  if ((bool)$registerEmail) {
    if (!filter_var($registerEmail, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['errors']['register-email-not-valid'] = 'Bitte geben sie eine gültige email ein';
      $errors[] = 1;
    }
    $_SESSION['registerEmail'] = $registerEmail;
  }
  
  // setzen der übergebenen eingabe in die session um bei fehlern den inhalt der session
  // in die formularfelder schreiben zu können
  if ((bool)$registerPassword) {
    $_SESSION['registerPassword'] = $registerPassword;
  }
  
  // sollten fehler vorhanden sein, wird zur registrierung umgeleitet
  if (count($errors) > 0) {
    header('Location: ' . '/drive2future/views/register.php#reg_anker');
    exit();
  }
  
  // prüfung ob keine fehler bis hier sind
  if (count($errors) === 0) {
    
    // prüfung ob das eingegebene passwort mindestens 8 zeichen lang ist
    if (mb_strlen($registerPassword) < 8) {
      $_SESSION['errors']['register-password-length'] = 'Passwort muss mindestens 8 Zeichen lang sein';
      $errors[] = 1;
    }

    // überprüfung ob das eingegebene passwort mit dem bestätigten übereinstimmt
    if ($registerPassword != $registerPasswordConfirm) {
      $_SESSION['errors']['password-not-confirmed'] = 'Passwörter stimmen nicht überein';
      $errors[] = 1;
    }
    
    // falls fehler vorhanden sind, wird auf die registrierung umgeleitet
    if (count($errors) > 0) {
      header('Location: ' . '/drive2future/views/register.php#reg_anker');
      exit();
    }
    
    // überprüfung ob fehler vorhanden sind
    if (count($errors) === 0) {
      
      // datenbankfunktionen für registrierung einbinden
      require_once __DIR__ . '/../models/register.php';
      
      // alle emails der datenbank als array in die variable schreiben
      $all_emails = get_all_emails();
      
      // das array durchlaufen und jedes feld mit der eingegebenen email prüfen
      foreach ($all_emails as $email) {
        // falls die email in der datenbank vorhanden ist, wird eine fehler session gesetzt und das
        // $errors array um ein feld erweitert
        if ($email['email'] === $registerEmail) {
          $_SESSION['errors']['can-not-use-email'] = 'Email kann nicht verwendet werden';
          $errors[] = 1;
        }
      }

      // falls fehler vorhanden sind, wird auf die registrierung umgeleitet
      if (count($errors) > 0) {
        header('Location: ' . '/drive2future/views/register.php#reg_anker');
        exit();
      }

      // überprüfung ob keine fehler mehr vorhanden sind
      if (count($errors) === 0) {
        // falls keine fehler mehr vorhanden sind, wird der neue benutzer mit den parametern, vor-, nachname, email und passwort
        // welches in der funktion gehasht wird abgespeichert
        $create_new_user = create_new_user($registerFirstname, $registerLastname, $registerEmail, $registerPassword);
        
        // bei erfolgreichem anlegen des neuen benutzers wird eine erfolgsmeldung in die session geschrieben und
        // auf den login umgeleitet.
        // bei einem fehler wird wieder auf die registrierung umgeleitet 
        if ((bool)$create_new_user) {
          $_SESSION['new-user'] = 'Account erfolgreich erstellt. Sie können sich nun einloggen';
          header('Location: ' . '/drive2future/views/login.php');
          exit();
        } else {
          header('Location: ' . '/drive2future/views/register.php');
          exit();
        }
      }  
    }
  }
}