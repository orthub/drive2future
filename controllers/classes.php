<?php
require_once __DIR__ .'/../models/classes.php';

$classes = get_classes();

if(isset($_POST['isNewClass'])){
    if(empty($_POST['bezeichnung']) || empty($_POST['beginn_date']) || empty($_POST['end_date'])){
        $_SESSION['errors']['class'] = 'Daten nicht vollständig';
        header('Location: ' . '/drive2future/views/classAdd.php');
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