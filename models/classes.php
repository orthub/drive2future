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

    $addclass = get_db()->prepare($sql);
    $params = [":bz" => $bezeichnung, ":bdate" => $beginn_date, "edate" => $end_date, ":status" => "aktiv"];

    return $addclass->execute($params);
}

function change_Status($status,$id){
    $sql = "UPDATE `drive2future`.`class` SET `status` = :gstatus WHERE (`id_class` = :id)";

    $stmt = get_db()->prepare($sql);
    $stmt->execute([':gstatus' => $status, ':id' => $id]);
    return $stmt;
}

function get_students(){
    $sql = 'SELECT `id_user`,`first_name`,`last_name`
    FROM `users`
    WHERE `roles_id_role` = 2';
    $stmt = get_db()->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}

function add_student_to_class($classId,$userId){
    $sql = 'INSERT INTO `drive2future`.`class_has_users` (`class_id_class`, `users_id_user`) 
            VALUES (:classid, :userid);';

    $stmt = get_db()->prepare($sql);
    $stmt->execute([':classid' => $classId, ':userid' => $userId]);

    return $stmt;
}

function get_users_from_class($classId){
    $sql = 'SELECT `id_user`,`first_name`,`last_name`
    FROM `users` u 
    JOIN class_has_users chu on chu.users_id_user = u.id_user
    WHERE `roles_id_role` = 2 And chu.class_id_class = :classid';
    $stmt = get_db()->prepare($sql);
    $stmt->execute([':classid' => $classId]);

    return $stmt->fetchAll();
}

function delete_user_from_class($classId,$userId){
    $sql = 'DELETE from class_has_users 
    where class_id_class = :classid 
    and users_id_user = :userid';
    
    $stmt = get_db()->prepare($sql);
    $stmt->execute([':classid' => $classId, ':userid' => $userId]);

    return $stmt;

}