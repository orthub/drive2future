<?php

require_once __DIR__ . '/db_connection.php';

function change_student_status(string $userId, string $status)
{
  $sql = "UPDATE `users` SET `status` = :studentStatus
          WHERE `user_id` = :userId";
  $stmt = get_db()->prepare($sql);
  $stmt->execute([
    ':studentStatus' => $status,
    ':userId' => $userId
  ]);
  return $stmt;
}