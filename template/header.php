<div id="header">
    <a class="title" href='index.php'><h1>Spotlister</h1></a>
    
    <?php
        if(checkPriv() > 0){
            echo '<p class="refresh">Next playlist refresh in: <span id="timer">00:00:00</span></p>';
        }
        if(checkPriv() == 2){
            echo '<p style="margin-top:10px;" class="panel"><a href="panel.php">Panel</a></p>';
        }
    ?>
</div>
