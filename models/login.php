<?php
// verbindung zur datenbank aufbauen
require_once __DIR__ . '/db_connection.php';

// diese funktion nimmt als parameter eine email als string entgegen und sucht anschließend
// in der datenbank ob diese email existiert
// rückgabewert ist ein boolean, bei fund -> true
function search_mail(string $email)
{
  $sql_search_mail = 'SELECT `email` 
                      FROM `users` 
                      WHERE `email` = :Email';
  $statement_search_mail = get_db()->prepare($sql_search_mail);
  $statement_search_mail->execute([':Email' => $email]);
  $result_search_mail = $statement_search_mail->fetchColumn();
  
  return $result_search_mail;
}

// diese funktion nimmt als parameter eine email als string an und
// gibt das gehashte passwort zurück
function get_password_from_email(string $email)
{
  $sql_get_password_from_email = 'SELECT `password` 
                              FROM `users`
                              WHERE `email` = :Email';
  $statement_get_password_from_email = get_db()->prepare($sql_get_password_from_email);
  $statement_get_password_from_email->execute([
    ':Email' => $email,
  ]);
  $result_get_password_from_email = $statement_get_password_from_email->fetchColumn();

  return $result_get_password_from_email;
}

// diese funktion nimmt als parameter eine email als string entgegen und gibt
// die benutzer id als string zurück
function get_user_id(string $email)
{
  $sql_get_user_id= 'SELECT `id_user` 
                      FROM `users`
                      WHERE `email` = :Email';
  $statement_get_user_id = get_db()->prepare($sql_get_user_id);
  $statement_get_user_id->execute([':Email' => $email]);
  $result_get_user_id = $statement_get_user_id->fetchColumn();

  return $result_get_user_id;
}

// diese funktion nimmt als parameter die benutzer id als string entgegen und verbindet
// sich mit den tabellen `users` und `roles` um die benutzerrechte anhand der benutzer id
// zu ermitteln
// rückgabewert ist ein array welches einen string mit dem rechte status beinhaltet
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