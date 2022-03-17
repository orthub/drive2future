<?php
if (empty($_SESSION['user_session'])) {
  header('Location: ' . '/drive2future/views/login.php');
}

require_once __DIR__ . '/../models/login.php';

if (isset($_SESSION['user_session'])) {
  $userId = $_SESSION['user_session'];
  $userId = str_replace('_loggedIn', '', $userId);
  $user_role = check_user_role($userId);
  $role = $user_role['r_type'];
}
$user_admin = false;
$user_employee = false;
$user_student = false;

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