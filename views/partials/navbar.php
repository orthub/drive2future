<header>
  <div class="navbar">
    <div class="logo">
      <a href="/drive2future" title="Zur Startseite">
        <img src="/drive2future/assets/img/softec_logo.svg" width="150" />
      </a>
    </div>

    <ul class="navbar-collapse">
      <input type="checkbox" id="checkbox_toggle" />
      <label for="checkbox_toggle" class="hamburger"><img class="" src="/drive2future/assets/img/Hamburger_icon.png" width="40" /></label>
      <div class="menu">
        <li><a class="nav-link" href="/drive2future/views/appointments.php" title="Zur Terminübersicht">Terminübersicht</a></li>
        <li><a class="nav-link" href="/drive2future/views/manageDocs.php" title="Zu den Unterlagen">Unterlagen</a></li>


        <?php if (isset($_SESSION['user_session'])) : ?>
          <?php if ((isset($user_employee) || isset($user_admin)) && ($user_employee || $user_admin)) : ?>
            <li><a class="nav-link" href="/drive2future/views/appointmentManagement.php">Terminverwaltung</a></li>
          <?php endif ?>
          <li><a class="nav-link" href="/drive2future/views/logout.php">Logout</a></li>
        <?php else : ?>
          <li><a class="nav-link" href="/drive2future/views/login.php">Login</a></li>
        <?php endif ?>
      </div>
    </ul>

  </div>
</header>