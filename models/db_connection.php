<?php
// funktion zum aufbau der datenbankverbindung
function get_db()
{
  static $db;
  // falls $db eine instanz von PDO ist, wird $db zurückgegeben
  if ($db instanceof PDO) {
    return $db;
  }

  // falls $db noch keine instanz ist
  // einbinden der datenbank einstellung
  require_once __DIR__ . '/../config/config.php';
  
  // verbindungsdaten für die datenbank setzen
  $dsn = sprintf('mysql:host=%s;dbname=%s;', DB_HOST, DB_NAME);
  // an der datenbank mittels PDO anmelden
  $db = new PDO($dsn, DB_USER, DB_PASS);

  return $db;
}