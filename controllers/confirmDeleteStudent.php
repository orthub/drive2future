<?php
require_once __DIR__ . '/../lib/sessionHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/drive2future/views.login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['userId'])) {
    $post_delete_id = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_SPECIAL_CHARS);
    $filtered_id = htmlspecialchars($post_delete_id);

    require_once __DIR__ . '/../models/students.php';
    $delete_user = delete_user_by_id($filtered_id);
    $removedUser = $_SESSION['first-name'];
    
    if ((bool)$delete_user) {
      $_SESSION['confirmed-deletion'] = 'Benutzer <b>' . $removedUser . '</b> wurde erfolgreich entfernt';
      unset($_SESSION['userId']);
      unset($_SESSION['first-name']);
      unset($_SESSION['confirm']);
      header('Location: ' . '/drive2future/views/students.php');
    }
  }
}