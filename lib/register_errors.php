<?php
if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
  foreach ($_SESSION['errors'] as $error) {
    echo '<h2 style="color: red">' . $error . '</h2><br />';
  } 
}
unset($_SESSION['errors']);