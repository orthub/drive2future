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

function match_mail_password(string $email, string $password): bool
{
  $sql_match_mail_password = 'SELECT `email`, `password` FROM `users`
                              WHERE `email` = :Email
                              AND `password` = :userPassword';
  $stmt_match_mail_password = get_db()->prepare($sql_match_mail_password);
  $stmt_match_mail_password->execute([
    ':Email' => $email,
    'userPassword' => $password
  ]);
  $res_match_mail_password = $stmt_match_mail_password->fetchColumn();

  return $res_match_mail_password;
}

function get_user_id(string $email)
{
  $sql_match_mail_password = 'SELECT `id_user` FROM `users`
                              WHERE `email` = :Email';
  $stmt_match_mail_password = get_db()->prepare($sql_match_mail_password);
  $stmt_match_mail_password->execute([':Email' => $email]);
  $res_match_mail_password = $stmt_match_mail_password->fetchColumn();

  return $res_match_mail_password;
}

function check_user_role(string $userId)
{
  $sql_check_user_role = 'SELECT `id_user`, `roles_id_role`, `roles`.`id_role`, `roles`.`r_type`
                          FROM `users`, `roles`
                          WHERE `id_user` = :userId
                          AND `roles`.`id_role` = `roles_id_role`';
  $stmt_check_user_role = get_db()->prepare($sql_check_user_role);
  $stmt_check_user_role->execute([':userId' => $userId]);

  $res_check_user_role = $stmt_check_user_role->fetch(PDO::FETCH_ASSOC);
  
  return $res_check_user_role;
}