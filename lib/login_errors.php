<?php 
if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
  foreach ($_SESSION['errors'] as $error) {
    echo '<p style="color: red"><b>' . $error . '</b></p>';
  } 
}

unset($_SESSION['errors']);

if (isset($_SESSION['new-user'])) {
  echo '<h2 style="color: green">' . $_SESSION['new-user'] . '</h2>';
}

unset($_SESSION['new-user']);
unset($_SESSION['registerFirstname']);
unset($_SESSION['registerLastname']);
unset($_SESSION['registerEmail']);
unset($_SESSION['registerPassword']);