<?php

require_once __DIR__ . '/db_connection.php';

function search_if_email_exists_already()
{
  $sql_search_if_existing_email = 'SELECT `email` FROM `users`';
  $stmt_search_if_existing_email = get_db()->query($sql_search_if_existing_email);
  $res_search_if_existing_email = $stmt_search_if_existing_email->fetchAll(PDO::FETCH_ASSOC);
  return $res_search_if_existing_email;
}

function create_new_user(string $first_name, string $last_name, string $email, string $passwd, /*string $status*/)
{
  $passwd = password_hash($passwd, PASSWORD_DEFAULT);
  $sql_create_new_user = 'INSERT INTO `users` 
                          SET `first_name` = :firstName,
                              `last_name` = :lastName,
                              `email` = :email,
                              `password` = :passwd,
                              `status` = " ",
                              `roles_id_role` = 2';
  $stmt_create_new_user = get_db()->prepare($sql_create_new_user);
  $stmt_create_new_user->execute([
    ':firstName' => $first_name,
    ':lastName' => $last_name,
    ':email' => $email,
    ':passwd' => $passwd
    // ':userStatus' => $status
  ]);
  return $stmt_create_new_user;
}