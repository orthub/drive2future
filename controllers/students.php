<?php
require_once __DIR__ .'/../models/db_connection.php';
require_once __DIR__ .'/../models/students.php';

if(isset($_POST['status'])){
    $status = $_POST['status'];
    $userid = $_POST['userId'];

    if(change_student_status($userid,$status)){
        header('Location: ' . '/drive2future/views/students.php#Anker1');
    }
    else{
        $_SESSION['errors']['student'] = "Fehler beim ändern des Status vom Schüler";
        header('Location: ' . '/drive2future/views/students.php#Anker1');
    }
}