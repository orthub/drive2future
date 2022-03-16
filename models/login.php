<?php

require_once __DIR__ . '/db_connection.php';

function search_mail(string $email)
{
  $sql_search_mail = 'SELECT `email` FROM `users` WHERE `email` = :Email';
  $stmt_search_mail = get_db()->prepare($sql_search_mail);
  $stmt_search_mail->execute([':Email' => $email]);
  $res_search_mail = $stmt_search_mail->fetch();
  
  return $res_search_mail;
}

function match_mail_password(string $email): bool
{
  $sql_match_mail_password = 'SELECT `email`, `password` FROM `users`
                              WHERE `email` = :Email';
  $stmt_match_mail_password = get_db()->prepare($sql_match_mail_password);
  $stmt_match_mail_password->execute([':Email' => $email]);
  $res_match_mail_password = $stmt_match_mail_password->fetchColumn();

  return $res_match_mail_password;
}

function login()
{
  $sql_login = 'SELECT `email` `password`
                FROM `users`';
  $stmt_login = get_db()->prepare($sql_login);
  $stmt_login->execute([]);
}