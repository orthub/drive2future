<header>
  <div class="navbar">
    <div class="logo">
      <a href="/drive2future" title="Zur Startseite">
        <img src="/drive2future/assets/img/softec_logo.svg" width="280" />
      </a>
    </div>
    <a class="nav-link" href="/drive2future/views/appointments.php" title="Zur Terminübersicht">Terminübersicht</a>
    <a class="nav-link" href="/drive2future/views/manageDocs.php" title="Zu den Unterlagen">Unterlagen</a>

    <?php if(isset($_SESSION['user_session'])) :?>
    <?php if( (isset($user_employee) || isset($user_admin)) && ( $user_employee || $user_admin)) :?>
    <a class="nav-link" href="/drive2future/views/appointmentManagement.php">Terminverwaltung</a>
    <?php endif ?>
    <a class="nav-link" href="/drive2future/views/logout.php">Logout</a>
    <?php else : ?>
      <a class="nav-link" href="/drive2future/views/login.php">Login</a>
    <?php endif ?>
    
    <?php
        /*if (isset($_SESSION['isStaff']) or isset($_SESSION['customerRoles'])) { ?>
    <a class="nav-link" href="logout" title="Logout">Logout</a>
    <?php }*/
        ?>
  </div>
  <!--<img class="header-img" src="public/images/BannerSeife.jpg" width="1920" />-->
</header>