<?php
require_once __DIR__ . '/../lib/sessionHelper.php';
require_once __DIR__ . '/../models/appointments.php';

$appointments = get_appointments();
$rooms = get_rooms();
$classes = get_classes();
$students = get_students();
$appointment_types = get_appointment_types();
