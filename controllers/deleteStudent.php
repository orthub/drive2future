<?php
require_once __DIR__ . '/../lib/sessionHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: ' . '/drive2future/views.login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $firstName = '';
  if (isset($_POST['delete-id'])) {
    $post_delete_id = filter_input(INPUT_POST, 'delete-id', FILTER_SANITIZE_SPECIAL_CHARS);
    $filtered_id = htmlspecialchars($post_delete_id);
    $_SESSION['delete-id'] = $filtered_id;
  
    require_once __DIR__ . '/../models/students.php';
    $firstName = get_first_name_by_id($_SESSION['delete-id']);
    $_SESSION['first-name'] = $firstName['first_name'];
    header('Location: ' . '/drive2future/views/deleteStudent.php');
  }
}