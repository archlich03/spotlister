<?php
    if (checkPriv() > 0){
        echo '<div id="sidebar">
            <a href="add.php">Add New Entry</a>
            <a href="download.php">Download Data</a>
            <a href="sitemap.php">View Sitemap</a>
            <a href="#" id="fetchOutputLink">Refresh playlist</a>
            <a href="lmao.php">HTML form :)</a>
            <a href="logout.php">Logout</a>
              </div>';
    }
    else {
        echo '<div id="sidebar">
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
              </div>';
    }
?>
