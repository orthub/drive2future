<header>
  <div class="navbar">
    <div class="logo">
      <a href="todo" title="Zur Startseite">
        <img src="todo" width="280" />
      </a>
    </div>
    <a class="nav-link" href="todo" title="Zur Terminübersicht">Terminübersicht</a>
    <a class="nav-link" href="todo" title="Zu den Unterlagen">Unterlagen</a>
    <a class="nav-link" href="/views/login.php">Login</a>
    <a class="nav-link" href="/views/logout.php">Logout</a>
    <?php
        /*if (isset($_SESSION['isStaff']) or isset($_SESSION['customerRoles'])) { ?>
    <a class="nav-link" href="logout" title="Logout">Logout</a>
    <?php }*/
        ?>
  </div>
  <!--<img class="header-img" src="public/images/BannerSeife.jpg" width="1920" />-->
</header>