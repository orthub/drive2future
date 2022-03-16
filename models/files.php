<?php
require_once __DIR__. '/../lib/sessionHelper.php';
require_once __DIR__.'/db_connection.php';

function add_New_File($path,$date)
{
    $sql = "INSERT INTO `drive2future`.`documents` (`path`, `date`) 
            VALUES (:Path, :date)";
    $stmt = get_db()->prepare($sql);
    $stmt->execute([':Path' => $path,':date' => $date]);

    return $stmt;
}

function get_files(){
    $sql = "select `id_documents`,`path`, `date` from drive2future.documents;";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}

function delete_file($id)
{
    $sql = "delete from drive2future.documents where id_documents = :id;";
    $stmt = get_db()->prepare($sql);
    $stmt->execute([':id' => $id]);
}