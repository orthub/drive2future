<?php
require_once __DIR__. '/../lib/sessionHelper.php';
require_once __DIR__.'/db_connection.php';

function add_New_File($path)
{
    $sql = "INSERT INTO `drive2future`.`documents` (`path`) 
            VALUES (:Path)";
    $stmt = get_db()->prepare($sql);
    $res = $stmt->execute([':Path' => $path]);

    return $res;
}

function get_files(){
    $sql = "select `id_documents`,`path`, `date` from drive2future.documents order by `date` desc;";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}
function get_filename_to_id($id){
    $sql = "select `path` from drive2future.documents where id_documents = :id;";
    $stmt = get_db()->prepare($sql);
    $stmt->execute([':id' => $id]);
    $res = $stmt->fetchColumn();
    
    return $res;
}

function delete_document_entry($id)
{
    $sql = "delete from drive2future.documents where id_documents = :id;";
    $stmt = get_db()->prepare($sql);
    $res = $stmt->execute([':id' => $id]);

    return $res;
}