<?php
    require_once 'functions.php';

    if (checkPriv() != 2)
        header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User management</title>
</head>
<body>
    <?php
        require_once 'template/header.php';
        require_once 'template/sidebar.php';
        require_once 'bodies/panel.php';
        require_once 'template/footer.php';
    ?>
</body>
</html>