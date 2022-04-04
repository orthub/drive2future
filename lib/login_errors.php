<?php
// fehlerausgabe für den login, wenn fehler in der session gesetzt sind
// werden diese ausgegeben
if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
  foreach ($_SESSION['errors'] as $error) {
    echo '<p style="color: red"><b>' . $error . '</b></p>';
  } 
}
// nach ausgabe der fehler wird die fehler session gelöscht
unset($_SESSION['errors']);

// wenn ein neuer benutzer erstellt wurde, wird die erfolgsmeldung auf
// der login seite ausgegeben
if (isset($_SESSION['new-user'])) {
  echo '<h2 style="color: green">' . $_SESSION['new-user'] . '</h2>';
}
// löschen der registrations session
unset($_SESSION['new-user']);
unset($_SESSION['registerFirstname']);
unset($_SESSION['registerLastname']);
unset($_SESSION['registerEmail']);
unset($_SESSION['registerPassword']);