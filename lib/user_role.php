<?php
if (!isset($_SESSION['user_session']) || !isset($_SESSION['user_id'])) {
  header('Location: ' . '/drive2future/views/login.php');
} // falls kein benutzer eingeloggt ist, wird auf den login umgeleitet

// einbinden der datenbankabfrage für benutzerrechte
require_once __DIR__ . '/../models/login.php';

// abfrage ob ein benutzer eingeloggt ist
if (isset($_SESSION['user_session']) || isset($_SESSION['userId'])) {
  $userId = $_SESSION['user_session'];
  $userId = str_replace('_loggedIn', '', $userId);
  // das gefundene benutzerrecht in die variable als array schreiben
  $user_role = check_user_role($userId);
  // benutzerrecht aus dem array holen
  $role = $user_role['r_type'];
}
// variablen für die abfrage erstellen mit standardwert false
$user_admin = false;
$user_employee = false;
$user_student = false;

// je nach recht die in der variable gespeichert ist, wird die $user_... variable
// auf true gesetzt um damit weiter zu arbeiten
switch ($role) {
  case 'ADMIN':
      $user_admin = true;
      break;
  case 'STUDENT':
      $user_student = true;
      break;
  case 'EMPLOYEE':
      $user_employee = true;
      break;
}