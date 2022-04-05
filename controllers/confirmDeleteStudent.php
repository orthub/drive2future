<?php
require_once __DIR__ . '/../lib/sessionHelper.php';

// wenn der controller falsch (mit GET) aufgerufen wird, wird auf den login umgeleitet
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/drive2future/views.login.php');
}

// prüfen ob die verbindung mit post aufgerufen wird
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $errors = [];
  
  // prüfung ob die benutzer id gesetzt wurde
  if (isset($_POST['userId'])) {
    
    // filtern der POST übergabe
    $post_delete_id = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_SPECIAL_CHARS);
    $filtered_id = htmlspecialchars($post_delete_id);

    // datenbankfunktionen für schüler einbinden
    require_once __DIR__ . '/../models/students.php';
    
    // benutzer wird anhand der id gelöscht 
    $delete_user = delete_user_by_id($filtered_id);
    
    // namen von der session in die variable speichern für löschbestätigung
    $removedUser = $_SESSION['first-name'];
    
    // wenn der benutzer erfolgreich gelöscht wurde, wird eine meldung in die session gespeichert
    // und nach dem redirect ausgegeben 
    if ((bool)$delete_user) {
      $_SESSION['confirmed-deletion'] = 'Benutzer <b>' . $removedUser . '</b> wurde erfolgreich entfernt';
      
      // löschen der session variablen
      unset($_SESSION['userId']);
      unset($_SESSION['first-name']);
      unset($_SESSION['confirm']);
      
      // umleitung zu schüler übersicht
      header('Location: ' . '/drive2future/views/students.php');
      exit();
    }
    // wenn keine userId gesetzt ist, wird auf den login umgeleitet
    header('Location: ' . '/drive2future/views/login.php');
  }
}