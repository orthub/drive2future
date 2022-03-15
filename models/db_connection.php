<?php

function get_db()
{
  static $db;
  if ($db instanceof PDO) {
    return $db;
  }
  $db = new PDO('mysql:host=localhost;port=3306;dbname=drive2future', 'root', '');

  return $db;
}