<?php

function get_db()
{
  static $db;
  if ($db instanceof PDO) {
    return $db;
  }

  require_once __DIR__ . '/../config/config.php';
  $dsn = sprintf('mysql:host=%s;dbname=%s;', 'db', 'drive2future');
  $db = new PDO($dsn, 'root', 'root');

  return $db;
}