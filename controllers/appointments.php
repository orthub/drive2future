<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../lib/user_role.php';
require_once __DIR__ . '/../models/appointments.php';


$appointments = get_appointments();
$appointments_for_user = get_appointments_for_user(str_replace('_loggedIn', '', $_SESSION['user_session']));
$rooms = get_rooms();
$classes = get_classes();
$students = get_students();
$appointment_types = get_appointment_types();
$allAppointments = get_all_appointments();

function get_valid_appointment_times($date, $duration,$user_ids, $exclude_start_time = ""){
    $bookings = get_appointments_for_users($date, $user_ids);
    //falls Termin bereits existiert, wird die aktuell vergebene Startzeit nicht in $bookings gespeichert
    if ($exclude_start_time !=""){
        foreach ($bookings as $ix=>$booking) {
            if ($booking['begin_time'] == $exclude_start_time){
                unset($bookings[$ix]);
                break;
            }
        }
    }
    
    return calculate_valid_start_times($duration, $bookings);
}