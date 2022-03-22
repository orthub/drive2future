<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../models/appointments.php';

$appointments = get_appointments();
$rooms = get_rooms();
$classes = get_classes();
$students = get_students();
$appointment_types = get_appointment_types();

function get_valid_appointment_times($date, $duration,$user_ids){
    $bookings = get_appointments_for_users($date, $user_ids) ;

    return calculate_valid_start_times($duration, $bookings);
}