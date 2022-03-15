  <?php 
  if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
      echo $error . '<br />';
    } 

  }
   unlink($_SESSION['errors']['email']);
   unlink($_SESSION['errors']['password']);