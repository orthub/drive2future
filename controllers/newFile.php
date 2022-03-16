<?php
require_once __DIR__ .'../models/db_connection.php';

if(isset($_FILES['userfile']['name']) && $_FILES['userfile']['tmp_name'] != null){
    $uploadfile = '/../Documents/' . basename($_FILES['userfile']['name']);
    print_r($uploadfile);
}
