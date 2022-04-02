<?php
if (empty($_SESSION['user_session'])) {
    header('Location: ' . '/drive2future/views/login.php');
}
require_once __DIR__ .'/../models/db_connection.php';
require_once __DIR__ .'/../models/files.php';


//$userrole = check_user_role()

$files = get_files();

if(!empty($_FILES['userfile']['name']) && $_FILES['userfile']['tmp_name'] != null){
    $filename = basename($_FILES['userfile']['name']);
    $uploadfile = __DIR__ .'/../Documents/' . $filename;

    if(file_exists($uploadfile)){
        $_SESSION['errors']['File'] = 'File ist schon vorhanden';
        header('location: /drive2future/views/manageDocs.php');
    }
    else{
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            if(add_New_File($filename)){
                header('location: /drive2future/views/manageDocs.php');
            }
        }
    }
}
if(isset($_POST['delete'])){
    $filename = get_filename_to_id($_POST['delete']);
    $filepath = __DIR__.'\\..\\Documents\\'.$filename;
    if(file_exists($filepath)){
        if(!unlink($filepath)){
            $_SESSION['errors']['File'] = 'Fehler beim löschen des Files';
            header('location: /drive2future/views/manageDocs.php');
        }
    }
    if(delete_document_entry($_POST['delete'])){
        header('location: /drive2future/views/manageDocs.php');
    }
    else{
        $_SESSION['errors']['File'] = 'Fehler beim löschen des DB Eintrags';
        header('location: /drive2future/views/manageDocs.php');
    }
}
if(isset($_POST['download'])){
    $file_to_download = '/../Documents/'.$_POST['download'];

    if (!file_exists($file_to_download)) {
        $_SESSION['errors']['File'] = 'File Existiert nicht';
        header('location: /drive2future/views/manageDocs.php');
        exit();
    }

    if (!is_file($file_to_download)) {
        $_SESSION['errors']['File'] = 'File ist nicht gültig';
        header('location: /drive2future/views/manageDocs.php');
        exit();
    }

    $client_file = $_POST['download'];

    $download_rate = 200; // 200Kb/s

    $f = null;

    header('Cache-control: private');
	header('Content-Type: application/octet-stream');
	header('Content-Length: ' . filesize($file_to_download));
	header('Content-Disposition: filename=' . $_POST['download']);

    flush();

    $f = fopen($file_to_download, 'r');

    while (!feof($f)) {
        echo fread($f, round($download_rate * 1024));
        flush();
    }
}
if (empty($_FILES['userfile']['name']) && $_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['download']) && !isset($_POST['delete'])) {
    $_SESSION['errors']['File'] = 'Keine Datei ausgewählt';
    header('Location: ' . '/drive2future/views/manageDocs.php');
}