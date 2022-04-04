<?php
// verbindung zur datenbank aufbauen
require_once __DIR__ . '/db_connection.php';

function change_student_status(string $userId, string $status)
{
  $sql = "UPDATE `users` SET `status` = :studentStatus
          WHERE `id_user` = :userId";
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':studentStatus' => $status,
    ':userId' => $userId
  ]);
  return $stmt;
}

// dieser funktion wird die benutzer id als string übergeben, welche gelöscht werden soll
// rückgabewert ist ein boolean, je nach erfolg
function delete_user_by_id(string $userId)
{
  $sql_delete_user_by_id = 'DELETE FROM `users`
                            WHERE `id_user` = :userId';
  $statement_delete_user_by_id = get_db()->prepare($sql_delete_user_by_id);
  $statement_delete_user_by_id->execute([':userId' => $userId]);

  return $statement_delete_user_by_id;
}

// dieser funktion wird die benutzer id als string übergeben und anhand der id
// der passende name aus der datenbank ausgesucht.
// rückgabewert ist ein string
function get_first_name_by_id(string $userId)
{
  $sql_get_first_name_by_id = 'SELECT `first_name` 
                              FROM `users`
                              WHERE `id_user` = :userId';
  $statement_get_first_name_by_id = get_db()->prepare($sql_get_first_name_by_id);
  $statement_get_first_name_by_id->execute([':userId' => $userId]);
  $result_get_first_name_by_id = $statement_get_first_name_by_id->fetch();

  return $result_get_first_name_by_id;
}