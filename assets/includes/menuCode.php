<?php
if (!isset($activePage)) {
  $activePage="notmainpage";
}
 ?>
<header>
    <nav class="navbar container navbar-expand-lg navbar-expand-md navbar-dark" role="navigation">
        <a class="navbar-brand" href="https://hullseals.space"><img src="https://hullseals.space/images/emblem_scaled.png" height="30" class="d-inline-block align-top" alt="Logo"> Hull Seals</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item <?php if ($activePage =='home') {?>active<?php }?>">
                    <a class="nav-link" href="https://hullseals.space">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://hullseals.space/knowledge">Knowledge Base</a>
                </li>
                <li class="nav-item <?php if ($activePage =='about') {?>active<?php }?>">
                    <a class="nav-link" href="https://hullseals.space/about">About</a>
                </li>
                <li class="nav-item <?php if ($activePage =='contact') {?>active<?php }?>">
                    <a class="nav-link" href="https://hullseals.space/contact">Contact</a>
                </li>
                  <?php
                  if(!$user->isLoggedIn()) {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="https://hullseals.space/users/login.php">Login</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="https://hullseals.space/users/join.php">Register</a
                          </li>';
                  }
                  else {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="https://hullseals.space/users">My Account</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="https://hullseals.space/users/logout.php">Log Out</a>
                          </li>';
                  } ?>
            </ul>
        </div>
    </nav>
</header>
