<?php
require_once '../models/db_connection.php';

function get_appointments() {
    $sql = "Select * from appointments";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}

?>