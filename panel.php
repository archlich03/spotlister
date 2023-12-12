<?php
    require_once 'functions.php';

    checkSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <meta name="description" content="Tool which converts spotify link information.">
    <meta name="keywords" content="spotify, converter, link">
    <meta name="author" content="We, The People">
    <meta name="date" content="2023-09-20">
    <meta name="expiry-date" content="2077-09-20">
    <meta name="robots" content="index, follow">
</head>
<body>
    <?php
        require_once 'template/header.php';
        require_once 'template/sidebar.php';
    ?>
    <div id='content'>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    displayUsersToTable();
                ?>
            </tbody>
        </table>
        <div id="refreshStart"></div>
        <div id="output"></div>
        <br><br>
        <?php
            require_once 'template/footer.php';
        ?>
    </div>
</body>
</html>
<script>
    document.cookie = "luckyNumber=" + Math.floor(Math.random() * 1000);
    document.cookie = "luckyString=" + Math.random().toString(36).substring(2, 15);
</script>
