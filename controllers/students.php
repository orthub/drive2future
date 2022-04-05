<?php
if (empty($_SESSION['user_session'])) {
    header('Location: ' . '/drive2future/views/login.php');
}
require_once __DIR__ .'/../models/db_connection.php';
require_once __DIR__ .'/../models/students.php';

//Wenn der Status vom Schüler geändert wird
if(isset($_POST['status'])){
    //Status und UserId vom POST
    $status = $_POST['status'];
    $userid = $_POST['userId'];

    //Ändern des Status, wenn fehlerhaft wird ein Fehlergeschrieben und zur Schülerübersicht umgeleitet
    if(change_student_status($userid,$status)){
        header('Location: ' . '/drive2future/views/students.php#Anker1');
    }
    else{
        $_SESSION['errors']['student'] = "Fehler beim ändern des Status vom Schüler";
        header('Location: ' . '/drive2future/views/students.php#Anker1');
    }
}