<?php
// falls fehler bei der registrierung sind, werden diese nacheinander ausgegeben
if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
  foreach ($_SESSION['errors'] as $error) {
    echo '<p style="color: red"><b>' . $error . '</b></p>';
  } 
}
// löschen der session
unset($_SESSION['errors']);