<?php
    require_once 'functions.php';
    
    sortToLogin();
    checkName();
?>
<!DOCTYPE html>
<html>
<head>
<title>Main Dashboard</title>

<?php
    require_once 'template/header.php';
    require_once 'template/sidebar.php';
    require_once 'bodies/index.php';
    require_once 'template/footer.php';
?>
</body>
</html>
