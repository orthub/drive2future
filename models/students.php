<?php

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

function delete_user_by_id(string $userId)
{
  $sql_delete_user_by_id = 'DELETE FROM `users`
                            WHERE `id_user` = :userId';
  $stmt_delete_user_by_id = get_db()->prepare($sql_delete_user_by_id);
  $stmt_delete_user_by_id->execute([':userId' => $userId]);

  return $stmt_delete_user_by_id;
}

function get_first_name_by_id(string $userId)
{
  $sql_get_first_name_by_id = 'SELECT `first_name` 
                              FROM `users`
                              WHERE `id_user` = :userId';
  $stmt_get_first_name_by_id = get_db()->prepare($sql_get_first_name_by_id);
  $stmt_get_first_name_by_id->execute([':userId' => $userId]);
  $res_get_first_name_by_id = $stmt_get_first_name_by_id->fetch();

  return $res_get_first_name_by_id;
}