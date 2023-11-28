<?php
    require 'functions.php';
    require 'validate.php';
    checkSession();

    $id = $url = $frequency = "";

    $conn = startConn();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
        $id = testInput((int)$_POST["id"]);
        $approved = testInput($_POST["approved"]);
        if($approved == null){
            $approved = 0;
        }

        $stmt = $conn->prepare("UPDATE Users SET approved = ? WHERE id = ?");
        $stmt->bind_param("ii", $approved, $id);
        $stmt->execute();

        if ($stmt->errno) {
            closeConn($stmt, $conn);
            die("Error: " . $stmt->error);
        } else {
            echo "Record updated successfully";
            closeConn($stmt, $conn);
            header("Location: panel.php");
            die();
        }

    } 
    elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {

        $id = testInput((int)$_GET["id"]);

        $stmt = $conn->prepare("SELECT approved FROM Users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt->bind_result($approved);
        $stmt->fetch();
        
        if ($stmt->errno) {
            closeConn($stmt, $conn);
            die("Error: " . $stmt->error);
        } else {
            closeConn($stmt, $conn);
        }
    }
    else {
        die ("<h1>Invalid request.</h1><br>URL related errors: $urlErr<br>Frequency related errors: $frequencyErr");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit element</title>
    <link rel="stylesheet" href="style/style.css?<?=date('U')?>">
    <meta name="description" content="Edit playlist/link information.">
    <meta name="keywords" content="spotify, converter, link">
    <meta name="author" content="We, The People">
    <meta name="date" content="2023-09-20">
    <meta name="expiry-date" content="2077-09-20">
    <meta name="robots" content="index, follow">
</head>
<style>
    #content{
        margin-left: 210px;
        margin-top: -8px;
    }
</style>
<body>
    <?php
        require 'template/header.php';
        require 'template/sidebar.php';
    ?>
    <div id='content'>
    <h1 id='title'>Edit User</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <br>
            <p>Approved: <input type="checkbox" name="approved" value="1" <?php echo ($approved == 1) || ($approved == 2) ? 'checked' : ''; ?>></p>
            <p>Make admin?: <input type="checkbox" name="approved" value="2" <?php echo ($approved == 2) ? 'checked' : ''; ?>></p>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <input class="back" type="button" value="Back" onclick="location.href='panel.php'">
            <input type="submit" name="submit" value="Submit">
        </form><br>
        <div id="output"></div>
        <?php
        require 'template/footer.php';
        ?>
    </div>
</body>

</html>