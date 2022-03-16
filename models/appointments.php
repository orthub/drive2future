<?php
require_once __DIR__.'/db_connection.php';

function get_appointments() {
    $sql = "Select `date`,`begin_time`,`end_time`,`description` from appointments";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}