<?php
require_once __DIR__. '/../lib/sessionHelper.php';
require_once __DIR__.'/db_connection.php';

function get_classes(){
    $sql = 'select `id_class`,`class_label`,`status`,`begin_date`,`end_date` from class;';

    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();

    return $res;
}

function add_new_class($bezeichnung,$beginn_date,$end_date){
    $sql = "INSERT INTO `drive2future`.`class` (`class_label`,`status` , `begin_date`, `end_date`) 
    VALUES (:bz,:status, :bdate, :edate);";

    $insertAppointment = get_db()->prepare($sql);
    $params = [":bz" => $bezeichnung, ":bdate" => $beginn_date, "edate" => $end_date, ":status" => "aktiv"];

    return $insertAppointment->execute($params);
}