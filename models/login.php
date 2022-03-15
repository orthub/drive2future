<?php

require_once __DIR__ . '/db_connection.php';

function search_mail(string $email): bool
{
  $sql_search_mail = 'SELECT `email` FROM `users` WHERE `email` = :Email';
  $stmt_search_mail = get_db()->prepare($sql_search_mail);
  $stmt_search_mail->execute([':Email' => $email]);
  $res_search_mail = $stmt_search_mail->fetchColumn();
  return $res_search_mail;
}

function login()
{
  $sql_login = 'SELECT `email` `password`
                FROM `users`';
  $stmt_login = get_db()->prepare($sql_login);
  $stmt_login->execute([]);
}