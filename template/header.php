<div id="header">
    <a class="title" href='index.php'><h1>Spotlister</h1></a>
    <?php
        switch(checkPriv()) {
            case 1:
                echo '<p class="refresh">Next playlist refresh in: <span id="timer">00:00:00</span></p>';
                echo '<p class="profile"><a href="profile.php">Profile</a></p>';
                break;
            case 2:
                echo '<p style="margin-top:10px;" class="panel"><a href="panel.php">Panel</a> <a href="profile.php">Profile</a></p>';
                break;
        }
    ?>
</div>
