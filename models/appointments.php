<?php
require_once __DIR__.'/db_connection.php';

function get_appointments() {
    $sql = "Select `date`,`begin_time`,`end_time`,`description` from appointments";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}

function get_appointment_types() {
    $sql = "SELECT * FROM appointment_types";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}

function get_rooms() {
    $sql = "SELECT * FROM rooms";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}

function get_classes() {
    $sql = "SELECT * FROM class";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}

function get_students() {
    $sql = "SELECT * FROM drive2future.class_has_users JOIN users "
        . "ON users_id_user = id_user ORDER BY last_name ASC;";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}

function get_app_type_id($app_type) {
    $sql = "SELECT * FROM drive2future.appointment_types "
        . "WHERE description = '$app_type';";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}

function get_room_id($room_description) {
    $sql = "SELECT * FROM drive2future.rooms "
        . "WHERE room_name = '$room_description';";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}

function get_class_id($class_label) {
    $sql = "SELECT * FROM drive2future.class "
        . "WHERE class_label = '$class_label';";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}


function add_appointment($date, $begin_time, $end_time, $description,
    $appointment_types_id_a_type, $rooms_id_room, $class_id_class) {
    $sql = "INSERT INTO drive2future.appointments (date, begin_time, end_time, "
        . "description, appointment_types_id_a_type, rooms_id_room, class_id_class) "
        . "VALUES ('$date', '$begin_time', '$end_time', '$description', "
        . "'$appointment_types_id_a_type', '$rooms_id_room', '$class_id_class')";
    $stmt = get_db()->query($sql);
    
    return $stmt;
}