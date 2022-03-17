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
        . "ON users_id_user = id_user ORDER BY last_name ASC";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}

function add_appointment(
    $date,
    $begin_time, 
    $end_time, 
    $description,
    $appointment_types_id_a_type, 
    $rooms_id_room, 
    $class_id_class) {

    $sql = "INSERT INTO drive2future.appointments (date, begin_time, end_time, "
        . "description, appointment_types_id_a_type, rooms_id_room, class_id_class) "
        . "VALUES ('$date', '$begin_time', '$end_time', '$description', "
        . "'$appointment_types_id_a_type', '$rooms_id_room', '$class_id_class')";
    $stmt = get_db()->query($sql);
    
    return $stmt;
}

function add_user_appointment($student, $app_id) {
    $sql = "INSERT INTO drive2future.users_has_appointments (users_id_user, "
        . "appointments_id_appointment) VALUES ('$student', '$app_id')";
    $stmt = get_db()->query($sql);
    
    return $stmt;
}

function add_class_appointment($class_id, $app_id) {
    $sql = "SELECT * FROM drive2future.class_has_users "
        . "WHERE class_id_class = $class_id";
    $stmt = get_db()->query($sql);
    $class_students = $stmt->fetchAll();

    // Termin für jeden Schüler speichern 
    foreach ($class_students as $student) {
        $student_id = intval($student["users_id_user"]);
        $sql = "INSERT INTO drive2future.users_has_appointments (users_id_user, "
            . "appointments_id_appointment) VALUES ('$student_id', '$app_id')";
        $stmt = get_db()->query($sql);
    }

    return $stmt;
}