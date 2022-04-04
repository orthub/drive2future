<?php
// verbindung zur datenbank aufbauen
require_once __DIR__ . '/db_connection.php';

// diese funktion sucht nach allen emails die in der datenbank vorhanden sind
// und gibt die gefundenen als assoziatives array zurück
function get_all_emails()
{
  $sql_get_all_emails = 'SELECT `email` FROM `users`';
  $statement_get_all_emails = get_db()->query($sql_get_all_emails);
  $result_get_all_emails = $statement_get_all_emails->fetchAll(PDO::FETCH_ASSOC);
  
  return $result_get_all_emails;
}

// diese funktion erstellt einen neuen benutzer, als parameter werden vor-, nachname, email und das
// passwort als string übergeben. das passwort wird anschließend in der funktion gehasht
// dieser benutzer wird standardmäßig mit den rechten eines schülers angelegt
// rückgabewert ist ein boolean je nach status (erfolgreich -> true, nicht erfolgreich -> false)
function create_new_user(string $first_name, string $last_name, string $email, string $passwd)
{
  $status = 'aktiv';
  $passwd = password_hash($passwd, PASSWORD_DEFAULT);
  $sql_create_new_user = 'INSERT INTO `users` 
                          SET `first_name` = :firstName,
                              `last_name` = :lastName,
                              `email` = :email,
                              `password` = :passwd,
                              `status` = :userStatus,
                              `roles_id_role` = 2';
  $statement_create_new_user = get_db()->prepare($sql_create_new_user);
  $statement_create_new_user->execute([
    ':firstName' => $first_name,
    ':lastName' => $last_name,
    ':email' => $email,
    ':passwd' => $passwd,
    ':userStatus' => $status
  ]);
  return $statement_create_new_user;
}


// diese funktion erstellt einen neuen benutzer, als parameter werden vor-, nachname, email und das
// passwort als string übergeben. das passwort wird anschließend in der funktion gehasht
// dieser benutzer wird standardmäßig mit den rechten eines trainers/lehrers angelegt
// rückgabewert ist ein boolean je nach status (erfolgreich -> true, nicht erfolgreich -> false)
function create_new_employee(string $first_name, string $last_name, string $email, string $passwd)
{
  $status = 'aktiv';
  $passwd = password_hash($passwd, PASSWORD_DEFAULT);
  $sql_create_new_employee = 'INSERT INTO `users` 
                          SET `first_name` = :firstName,
                              `last_name` = :lastName,
                              `email` = :email,
                              `password` = :passwd,
                              `status` = :userStatus,
                              `roles_id_role` = 3';
  $statement_create_new_employee = get_db()->prepare($sql_create_new_employee);
  $statement_create_new_employee->execute([
    ':firstName' => $first_name,
    ':lastName' => $last_name,
    ':email' => $email,
    ':passwd' => $passwd,
    ':userStatus' => $status
  ]);
  return $statement_create_new_employee;
}