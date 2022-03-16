<?php

function get_db()
{
  static $db;
  if ($db instanceof PDO) {
    return $db;
  }

  require_once __DIR__ . '/../config/config.php';
  $dsn = sprintf('mysql:host=%s;dbname=%s;', DB_HOST, DB_NAME);
  $db = new PDO($dsn, DB_USER, DB_PASS);

  return $db;
}