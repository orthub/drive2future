  <?php 
  if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
      echo $error . '<br />';
    } 

  }
   unset($_SESSION['errors']['email']);
   unset($_SESSION['errors']['password']);