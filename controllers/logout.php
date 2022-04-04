<?php
// löschen der gespeicherten sessions und umleitung zur startseite
session_start();
unset($_SESSION['user_session']);
unset($_SESSION['user_id']);
session_destroy();
header('Location: ' . '/drive2future');