<?php
require_once __DIR__ .'/../models/db_connection.php';
require_once __DIR__ .'/../models/files.php';

$files = get_files();

if(isset($_FILES['userfile']['name']) && $_FILES['userfile']['tmp_name'] != null){
    $filename = basename($_FILES['userfile']['name']);
    $uploadfile = __DIR__ .'/../Documents/' . $filename;
    
    $today = date("Y-m-d");

    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        $res = add_New_File($filename,$today);

        add_New_File($filename,$today);
        //überprüfung ob funktioniert hat fehlt
        header('location: /drive2future/views/manageDocs.php');
    }
}

else if(isset($_POST['delete'])){
    delete_file($_POST['delete']);
    //überprüfung ob funktioniert hat fehlt
    header('location: /drive2future/views/manageDocs.php');
}