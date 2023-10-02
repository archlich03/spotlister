<?php
    require 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?<?=date('U')?>">
    <meta name="description" content="Tool which converts spotify link information.">
    <meta name="keywords" content="spotify, converter, link">
    <meta name="author" content="We, The People">
    <meta name="date" content="2023-09-20">
    <meta name="expiry-date" content="2077-09-20">
    <meta name="robots" content="index, follow">
</head>
<body>
    <?php
        require 'template/header.html';
        require 'template/sidebar.html';
    ?>
    <div id='content'>
        <table>
            <thead>
                <tr>
                    <th>URL</th>
                    <th>Check Frequency</th>
                    <th>Last Check</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    displayJSONDataToTable();
                ?>
            </tbody>
        </table>
        <div id="output"></div>
        <br><br>
        <?php
            require 'template/footer.php';
        ?>
    </div>
</body>
</html>
