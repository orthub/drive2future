<?php
require_once __DIR__ . '/db_connection.php';

//Funktion zum abholen aller Termine
function get_appointments()
{
    $currentDate = date('Y-m-d');
    $sql = "SELECT `id_appointment`, `date`,`begin_time`,`end_time`,`description` FROM appointments
    WHERE `date` >= '$currentDate'";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();

    return $res;
}

//Funktion zum abholen der Termine für einen bestimmten user
function get_appointments_for_user($userid)
{
    $currentDate = date('Y-m-d');
    $sql = "SELECT `date`,`begin_time`,`end_time`,`description`, `id_appointment` 
    FROM drive2future.users_has_appointments uha
    join appointments a on uha.appointments_id_appointment = a.id_appointment 
    where users_id_user = :userid AND `date` >= '$currentDate'
    order by date;";

    $getUserAppointment = get_db()->prepare($sql);
    $params = [":userid" => $userid];

    $getUserAppointment->execute($params);
    return $getUserAppointment->fetchAll();
}

//get all appointments from DB for admin view
function get_appointments_overview()
{
    $currentDate = date('Y-m-d');
    $sql = "SELECT a.id_appointment, a.date, a.begin_time, a.end_time, a.description, a.appointment_types_id_a_type, 
	u.first_name as teacher_first_name, u.last_name as teacher_last_name, r.r_type, c.class_label, student.first_name as student_first_name, student.last_name as student_last_name
	FROM appointments a 
	INNER JOIN users_has_appointments uha ON a.id_appointment = uha.appointments_id_appointment
    INNER JOIN users u ON uha.users_id_user = u.id_user
	INNER JOIN roles r ON u.roles_id_role = r.id_role
	INNER JOIN class c ON a.class_id_class = c.id_class
    LEFT OUTER JOIN (
		SELECT ap.id_appointment,us.first_name, us.last_name  FROM appointments ap
        INNER JOIN users_has_appointments uhap ON ap.id_appointment = uhap.appointments_id_appointment
		INNER JOIN users us ON uhap.users_id_user = us.id_user
        WHERE us.roles_id_role=2 AND ap.appointment_types_id_a_type=3
        ) as student ON student.id_appointment=a.id_appointment

    WHERE u.roles_id_role=3 AND a.date >= '$currentDate'
    ORDER BY a.date;";
    // var_dump($sql);
    // exit();
    $getAppointments = get_db()->query($sql);
    return $getAppointments->fetchAll();
}

//Funktion zum abholen aller TerminTypen
function get_appointment_types()
{
    $sql = "SELECT * FROM appointment_types";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();

    return $res;
}

//Funktion zum abholen der Räume
function get_rooms()
{
    $sql = "SELECT * FROM rooms";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();

    return $res;
}

//Funktion zum abholen der Klassen
function get_classes()
{
    $sql = "SELECT * FROM class";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();

    return $res;
}

//Funktion zum abholen der Schüler 
function get_students()
{
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
    $class_id_class
) {

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
function add_user_appointment($user_id, $app_id)
{
    $sql = "INSERT INTO drive2future.users_has_appointments (users_id_user, "
        . "appointments_id_appointment) VALUES ('$user_id', '$app_id')";
    $stmt = get_db()->query($sql);

    return $stmt;
}

// Termin für jeden Schüler einer Klasse speichern (bei Vortrag und Übung)
function add_class_appointment($class_id, $app_id)
{
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

function get_appointment($app_id)
{
    $sql = "SELECT * FROM appointments "
        . "WHERE id_appointment = '$app_id'";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();

    return $res;
}

//berechnen aller möglichen Startzeitpunkte eines Termins
function calculate_valid_start_times($duration, $bookings)
{
    $result = [];
    //umrechnen der Zeiten zu Minuten ausgehend von Mitternacht
    $bookings = transform_appointments($bookings);
    //Startzeitpunkt + Dauer muss kleiner gleich 1320 (Mitternacht bis 22 Uhr) sein
    for ($start = 420; $start + $duration <= 1320; $start += 30) {
        $end = $start + $duration;
        $overlap = false;
        foreach ($bookings as $booked) {
            //Überschneidungen wenn Endezeitpunkt größer als Startzeit von vorhandenem Termin UND Endzeit von vorhandenem Termin größer Startzeitpunkt 
            if ($end > $booked['start'] && $booked['end'] > $start) {
                $overlap = true;
                break;
            }
        }
        //Wenn nicht überschneidet -> Startzeitpunkt als time in $result[] schreiben
        if (!$overlap) {
            $result[] = transform_minutes_to_time($start);
        }
    }
    return $result;
}

//bestehende Termine für eine Liste von Usern an einem bestimmten Datum
function get_appointments_for_users($date, $user_ids)
{

    $query = "SELECT a.begin_time, a.end_time FROM appointments a 
	INNER JOIN users_has_appointments uha ON a.id_appointment = uha.appointments_id_appointment
    INNER JOIN users u ON uha.users_id_user = u.id_user
    WHERE u.id_user IN (:user_ids) AND a.date = :date";
    try {
        $getAppointments = get_db()->prepare($query);
        $params = [
            ":user_ids" => join(', ', $user_ids),
            ":date" => $date
        ];
        $getAppointments->execute($params);
        return $getAppointments->fetchAll();
    } catch (PDOException $e) {
        // todo return ["message" => "Es ist ein Serverfehler aufgetreten. Bitte versuchen Sie es später erneut."];
    }
}

//Startzeiten und Endzeiten von Terminen in Integer umrechnen
function transform_appointments($appointments)
{
    $transformed = [];
    foreach ($appointments as $appointment) {
        $transformed[] = [
            'start' => transform_time_to_minutes($appointment['begin_time']),
            'end' => transform_time_to_minutes($appointment['end_time'])
        ];
    }
    return $transformed;
}

//Zeitpunkt in Integer (Minuten ausgehend von Mitternacht) umrechnen
function transform_time_to_minutes($time)
{
    $parts = explode(":", $time);
    return intval($parts[0]) * 60 + intval($parts[1]);
}

//Minuten (Integer, ausgehend von Mitternacht) in Zeitpunkt umrechnen
function transform_minutes_to_time($value)
{
    $minutes = $value % 60;
    $hours = intdiv($value, 60);
    return sprintf('%02d:%02d:00', $hours, $minutes);
}

function delete_user_appointment($app_id)
{
    $sql = "DELETE FROM drive2future.users_has_appointments WHERE appointments_id_appointment = $app_id";
    $stmt = get_db()->query($sql);

    return $stmt;
}

function delete_appointment($app_id)
{
    $sql = "DELETE FROM drive2future.appointments WHERE id_appointment = $app_id";
    $stmt = get_db()->query($sql);

    return $stmt;
}

// Alle Schüler einer Klasse holen
function get_active_class_students($class_id)
{
    $sql = "SELECT * FROM drive2future.class_has_users JOIN users "
        . "ON users_id_user = id_user WHERE class_id_class = $class_id "
        . "AND status = 'aktiv' ORDER BY last_name ASC";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();

    return $res;
}

// Termin aktualiseren nach bearbeiten
function update_appointment(
    $edit_app_id,
    $date,
    $begin_time,
    $end_time,
    $description,
    $app_type_id,
    $room_id,
    $class_id
) {
    $sql = "UPDATE drive2future.appointments SET date = '$date', begin_time = '$begin_time', "
        . "end_time = '$end_time', description = '$description', appointment_types_id_a_type = $app_type_id, "
        . "rooms_id_room = $room_id, class_id_class = $class_id WHERE id_appointment = $edit_app_id";
    $stmt = get_db()->query($sql);

    return $stmt;
}

// Termin der zuvorausgewählten Klasse löschen
function delete_class_appointment($class_id, $app_id)
{
    $sql = "SELECT * FROM drive2future.class_has_users "
        . "WHERE class_id_class = $class_id";
    $stmt = get_db()->query($sql);
    $class_students = $stmt->fetchAll();

    // Termin für jeden Schüler der angegeben Klasse speichern 
    foreach ($class_students as $student) {
        $student_id = intval($student["users_id_user"]);
        $sql = "DELETE FROM drive2future.users_has_appointments WHERE "
            . "users_id_user = $student_id AND appointments_id_appointment = $app_id";
        $stmt = get_db()->query($sql);
    }

    return $stmt;
}

// Termin für jeden Schüler der neu ausgewählten Klasse speichern (bei Vortrag und Übung)
function update_class_appointment($class_id, $app_id)
{
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

// Aktuell ausgewählter Fahrschüler für einen bestimmten Termin herausfinden (bei Termin bearbeiten)
function get_driving_student_appointment($appointment_id)
{
    $sql = "SELECT uha.appointments_id_appointment, uha.users_id_user
    FROM drive2future.users_has_appointments uha
    INNER JOIN class_has_users chu ON uha.users_id_user = chu.users_id_user
    INNER JOIN users u ON uha.users_id_user = u.id_user AND u.roles_id_role = 2
    WHERE uha.appointments_id_appointment = $appointment_id";


    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();

    return $res;
}

//Funktion zum abholen der aktiven Klassen
function get_active_classes()
{
    $sql = "SELECT * FROM class WHERE status ='aktiv'";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();

    return $res;
}

//Funktion zum abholen aller Mitarbeiter
function get_all_employees()
{
    $sql = "SELECT * FROM users WHERE roles_id_role = 3";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();

    return $res;
}

//Abholen der Termine eines Mitarbeiters
function get_employee_appointment($app_id)
{
    $sql = "SELECT * FROM users_has_appointments uha
    INNER JOIN users u ON uha.users_id_user = u.id_user AND roles_id_role = 3
    WHERE uha.appointments_id_appointment = $app_id";
    $stmt = get_db()->query($sql);
    $res = $stmt->fetchAll();

    return $res;
}