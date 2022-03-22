<?php
require_once __DIR__.'/db_connection.php';

function get_appointments() {
    $sql = "Select `id_appointment`, `date`,`begin_time`,`end_time`,`description` from appointments";
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

// Termin zur Tabelle appointments hinzufügen
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
        . "VALUES (:date, :begin_time, :end_time, :description, "
        . ":appointment_types_id_a_type, :rooms_id_room, :class_id_class)";

    $insertAppointment = get_db()->prepare($sql);
        $params = [
            ":date" => $date,
            ":begin_time" => $begin_time,
            ":end_time" => $end_time,
            ":description" => $description,
            ":appointment_types_id_a_type" => $appointment_types_id_a_type, 
            ":rooms_id_room" => $rooms_id_room,
            ":class_id_class" => $class_id_class
        ];
        $insertAppointment->execute($params);
        return $insertAppointment->fetchAll();
}

// Termin für einzelnen Benutzer speichern (bei Fahrstunde)
function add_user_appointment($student, $app_id) {
    $sql = "INSERT INTO drive2future.users_has_appointments (users_id_user, "
        . "appointments_id_appointment) VALUES ('$student', '$app_id')";
    $stmt = get_db()->query($sql);
    
    return $stmt;
}

// Termin für jeden Schüler einer Klasse speichern (bei Vortrag und Übung)
function add_class_appointment($class_id, $app_id) {
    $sql = "SELECT * FROM drive2future.class_has_users "
        . "WHERE class_id_class = $class_id";
    $stmt = get_db()->query($sql);
    $class_students = $stmt->fetchAll();

    // Termin für jeden Schüler der angegeben Klasse speichern 
    foreach ($class_students as $student) {
        $student_id = intval($student["users_id_user"]);
        $sql = "INSERT INTO drive2future.users_has_appointments (users_id_user, "
            . "appointments_id_appointment) VALUES ('$student_id', '$app_id')";
        $stmt = get_db()->query($sql);
    }

    return $stmt;
}

function get_appointment($app_id) {
    $sql = "SELECT * FROM appointments "
        . "WHERE id_appointment = '$app_id'";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();
    
    return $res;
}

//berechnen aller möglichen Startzeitpunkte eines Termins
function calculate_valid_start_times ($duration, $bookings){
    $result = [];
    //umrechnen der Zeiten zu Minuten ausgehend von Mitternacht
    $bookings = transform_appointments($bookings);
    for ($start = 420; $start + $duration <= 1200; $start += 30){
        $end = $start + $duration;
        $overlap = false;
        foreach ($bookings as $booked){
            if ($end > $booked['start'] && $booked['end'] > $start){
                $overlap = true;
                break;
            }
        }
        if(!$overlap){
            $result[] = transform_minutes_to_time($start);
        }
    }
    return $result;
}

//bestehende Termine für eine Liste von Usern an einem bestimmten Datum
function get_appointments_for_users($date, $user_ids){

    $query = "SELECT a.begin_time, a.end_time FROM appointments a 
	INNER JOIN users_has_appointments uha ON a.id_appointment = uha.appointments_id_appointment
    INNER JOIN users u ON uha.users_id_user = u.id_user
    WHERE u.id_user IN (:user_ids) AND a.date = :date";
    try{
        $getAppointments = get_db()->prepare($query);
        $params = [
            ":user_ids" => join(', ', $user_ids),
            ":date" => $date
        ];
        $getAppointments->execute($params);
        return $getAppointments->fetchAll();
    } catch(PDOException $e) {
        // todo return ["message" => "Es ist ein Serverfehler aufgetreten. Bitte versuchen Sie es später erneut."];
    }
}
function transform_appointments($appointments){
    $transformed =[];
    foreach ($appointments as $appointment){
        $transformed[] = [
            'start' => transform_time_to_minutes($appointment['begin_time']),
            'end' => transform_time_to_minutes($appointment['end_time'])
        ];
    }
    return $transformed;
}

function transform_time_to_minutes($time){
    $parts = explode(":", $time);
    return intval($parts[0]) * 60 + intval($parts[1]);
}

function transform_minutes_to_time($value){
    $minutes = $value % 60;
    $hours = intdiv($value, 60);
    return sprintf('%02d:%02d:00', $hours, $minutes);
}

