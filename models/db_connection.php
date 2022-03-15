<?php
require_once __DIR__ . '/../config/config.php';

function get_db()
{
  static $db;
  if ($db instanceof PDO) {
    return $db;
  }
  
  $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME);
  $db = new PDO($dsn, DB_USER, DB_PASS);

  return $db;
}