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
// wenn die eingaben fehler aufweisen, wird in das $errors array eine 1 gesetzt für jeden
// gefundenen fehler und erweitert
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  // setzen von benötigten variablen für fehler
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

  // wenn das email feld leer ist wird in die session eine fehlermeldung geschrieben und ein
  // array feld hinzugefügt
  if ((bool)$loginEmail === false) {
    $_SESSION['errors']['login-mail'] = 'Bitte Email eingeben';
    $errors[] = 1;
  }

  // wenn das passwort feld leer ist wird in die session eine fehlermeldung geschrieben und ein
  // array feld hinzugefügt
  if ((bool)$loginPasswd === false) {
    $_SESSION['errors']['login-passwd'] = 'Bitte Passwort eingeben';
    $errors[] = 1;
  }

  // eingabe von email und passwort in eine session schreiben um bei einem möglichem
  // fehler die werte wieder in die felder schreiben zu können
  if ((bool)$loginEmail) {
    $_SESSION['loginEmail'] = $loginEmail;
  }
  if ((bool)$loginPasswd) {
    $_SESSION['loginPasswd'] = $loginPasswd;
  }

  // wenn fehler vorhanden sind, wird auf login umgeleitet
  if (count($errors) > 0) {
    header('Location: ' . '/drive2future/views/login.php#login_anker');
  }

  // prüfen ob keine fehler vorhanden sind
  if (count($errors) === 0) {
    
    // datenbankfunktionen für login einbinden
    require_once __DIR__ . '/../models/login.php';
    
    // suchen ob die eingegebene email in der datenbank existiert
    $emailExist = search_mail($loginEmail);

    // falls die email nicht existiert wird die fehler session gesetzt und in $errors
    // ein feld hinzugefügt
    if ((bool)$emailExist === false) {
      // um keinen hinweis zu geben ob email oder passwort falsch ist, werden beide als
        // möglicher fehler angezeigt
      $_SESSION['errors']['login-fail'] = 'Email oder Passwort stimmt nicht';
      $errors[] = 1;
    }
    
    // prüfung ob fehler vorhanden sind, falls ja wird auf login umgeleitet
    if (count($errors) > 0) {
      header('Location: ' . '/drive2future/views/login.php#login_anker');
    }

    // nochmalige prüfung ob die email existiert
    if ((bool)$emailExist) {
      
      // passwort holen anhand der übergebenen email
      $match = get_password_from_email($loginEmail);

      // gehashtes passwort von der datenbank mit dem übergebenen vom login vergleichen
      $isValidLogin = password_verify($loginPasswd, $match);
      
      // falls passwort nicht mit dem in der datenbank übereinstimmt
      if (!$isValidLogin) {
        // um keinen hinweis zu geben ob email oder passwort falsch ist, werden beide als
        // möglicher fehler angezeigt
        $_SESSION['errors']['login-fail'] = 'Email oder Passwort stimmt nicht';
        header('Location: ' . '/drive2future/views/login.php#login_anker');
        exit();
      }
  
      // wenn passwort übereinstimmt mit dem in der datenbank wird die benutzer id
      // von der datenbank geholt und in eine session gespeichert
      if ($isValidLogin) {
        $user_id = get_user_id($loginEmail);
        // setzen der benutzer id in die session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_session'] = $user_id . '_loggedIn';
        
        // löschen der login session für email und passwort
        unset($_SESSION['loginEmail']);
        unset($_SESSION['loginPassword']);

        // umleitung zur terminübersicht nach erfolgreichm login
        header('Location: ' . '/drive2future/views/appointments.php');
        exit();
      }
    }
  }
}