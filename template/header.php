<div id="header">
    <a class="title" href='index.php'><h1>Spotlister</h1></a>
    <p class='refresh'>Next playlist refresh in: <span id="timer">00:00:00</span></p>
    <?php
        if(checkPriv() > 0){
            echo '<p style="margin-top:10px;" class="logout"><a href="logout.php">Logout</a></p>';
        }
        else {
            echo '<p style="margin-top:10px;" class="login"><a href="login.php">Login</a></p>';
        }
        if(checkPriv() == 2){
            echo '<p style="margin-top:10px;" class="panel"><a href="panel.php">Panel</a></p>';
        }
    ?>
</div>