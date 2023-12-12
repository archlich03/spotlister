<?php
    require 'functions.php';
    checkSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add an element</title>
    <link rel="stylesheet" href="style/style.css">
    <meta name="description" content="Adds new element.">
    <meta name="keywords" content="spotify, converter, link">
    <meta name="author" content="We, The People">
    <meta name="date" content="2023-09-20">
    <meta name="expiry-date" content="2077-09-20">
    <meta name="robots" content="index, follow">
</head>
<body>
    <?php
        require 'template/header.php';
        require 'template/sidebar.php';
    ?>
    <div id='content'>
        <div class="gallery">
        <a target="_blank" href="photos/img_5terre.jpg">
            <img src="photos/img_5terre.jpg" alt="Cinque Terre" width="600" height="400">
        </a>
        <div class="desc">Gražu</div>
        </div>

        <div class="gallery">
        <a target="_blank" href="photos/img_forest.jpg">
            <img src="photos/img_forest.jpg" alt="Forest" width="600" height="400">
        </a>
        <div class="desc">Gražiau</div>
        </div>

        <div class="gallery">
        <a target="_blank" href="photos/img_lights.jpg">
            <img src="photos/img_lights.jpg" alt="Northern Lights" width="600" height="400">
        </a>
        <div class="desc">Gražiausia</div>
        </div><br>
        <div class="gallery">
        <a target="_blank" href="photos/database.jpg">
            <img src="photos/database.jpg" alt="Database" width="600" height="400">
        </a>
        <div class="desc">Duomenų bazė</div>
        </div><br>
        <div id="output"></div>

        <?php
            require 'template/footer.php';
        ?>
    </div>
</body>

</html>
