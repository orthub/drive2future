<?php
require_once __DIR__ . '/../lib/sessionHelper.php';

// falls die url mit GET aufgerufen wird, wird auf den login umgeleitet
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/drive2future/views.login.php');
}

// prüfen ob mit POST aufgerufen wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // string variable für spätere verwendung
  $firstName = '';
  // prüfen ob die lösch id gesetzt wurde
  if (isset($_POST['delete-id'])) {
    
    // filtern der POST übergabe
    $post_delete_id = filter_input(INPUT_POST, 'delete-id', FILTER_SANITIZE_SPECIAL_CHARS);
    $filtered_id = htmlspecialchars($post_delete_id);
    
    // lösch id in die session schreiben
    $_SESSION['delete-id'] = $filtered_id;
  
    // datenbankfunktionen für schüler einbinden
    require_once __DIR__ . '/../models/students.php';

    // vornamen anhand der id ermitteln und in eine session schreiben
    $firstName = get_first_name_by_id($_SESSION['delete-id']);
    $userStatus = get_student_status($filtered_id);
    $_SESSION['first-name'] = $firstName['first_name'];
    $_SESSION['user-status'] = $userStatus;
    
    // umleitung zur bestätigung des löschvorgangs
    header('Location: ' . '/drive2future/views/deleteStudent.php');
    exit();
  }
  // falls die lösch id nicht gesetzt wurde, wird zum login umgeleitet
  header('Location: ' . '/drive2future/views/login.php');
}