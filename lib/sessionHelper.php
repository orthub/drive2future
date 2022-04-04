<?php
if (session_status() === PHP_SESSION_NONE){
  session_start();
}
// hilfsfunktion für session, wenn keine session gestartet ist,
// wird automatisch eine gestartet