<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
if (empty($_SESSION['user_session'])) {
    header('Location: ' . '/drive2future/views/login.php');
}

require_once __DIR__ .'/../models/classes.php';

$classes = get_classes();
$students = get_students();

if(isset($_SESSION['classid'])){
    $studentsFromClass = get_users_from_class($_SESSION['classid']);
}

if(isset($_POST['isNewClass'])){
    $filterdLabel = filter_var($_POST['bezeichnung'], FILTER_SANITIZE_SPECIAL_CHARS);

    $filtered = htmlspecialchars($filterdLabel);

    if($filterdLabel != $filtered){
        $_SESSION['errors']['class'] = 'Keine Sonderzeichen!';
        header('Location: ' . '/drive2future/views/classAdd.php');
        exit;
    }

    if(empty($filtered) || mb_strlen($filtered) >= 45 || empty($_POST['beginn_date']) || empty($_POST['end_date'])){
        $_SESSION['errors']['class'] = 'Daten nicht vollständig';
        header('Location: ' . '/drive2future/views/classAdd.php');
        exit;
    }

    $diffDays = (strtotime($_POST['end_date']) - strtotime($_POST['beginn_date']))/60/60/24;

    if($diffDays < 2){
        $_SESSION['errors']['class'] = 'Daten stimmen nicht überein';
        header('Location: ' . '/drive2future/views/classAdd.php');
        exit;
    }

    if(add_new_class($_POST['bezeichnung'],$_POST['beginn_date'],$_POST['end_date'])){
        header('Location: ' . '/drive2future/views/classes.php');
        exit;
    }
    else{
        $_SESSION['errors']['class'] = 'Fehler beim erstellen der Klasse';
        header('Location: ' . '/drive2future/views/classAdd.php');
        exit;
    }
}

if(isset($_POST['status'])){
    $status = "";
    if($_POST['status'] == 'aktiv'){
        $status = 'inaktiv';
    }
    if($_POST['status'] == 'inaktiv'){
        $status = 'aktiv';
    }
    $id = $_POST['id'];
    if(change_Status($status,$id)){
        header('Location: ' . '/drive2future/views/classes.php#Anker1');
    }
    else{
        $_SESSION['errors']['class'] = 'Fehler beim ändern des Status';
        header('Location: ' . '/drive2future/views/classes.php#Anker1');
        exit;
    }
}

if(isset($_POST['addSchuler'])){
    if(add_student_to_class($_POST['classId'],$_POST['userId'])){
        header('Location: ' . '/drive2future/views/classesAddStudents.php#Anker1');
    }
    else{
        $_SESSION['errors']['class'] = 'Fehler beim hinzufügen eines Schülers zur Klasse';
        header('Location: ' . '/drive2future/views/classesAddStudents.php#Anker1');
    }
}

if(isset($_POST['isDelete'])){
    if(delete_user_from_class($_POST['classId'],$_POST['userId'])){
        header('Location: ' . '/drive2future/views/classesAddStudents.php#Anker1');
    }
    else{
        $_SESSION['errors']['class'] = 'Fehler beim Löschen des Users aus der Klasse';
        header('Location: ' . '/drive2future/views/classesAddStudents.php#Anker1');
    }
}