<?php
    require 'functions.php';
    require 'validate.php';
    checkSession();

    $id = $url = $frequency = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
        $userId = testInput($_SESSION['userId']);
        $id = testInput((int)$_POST["id"]);
        
        $conn = startConn();
    
        $stmt = $conn->prepare("DELETE FROM Playlists WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $userId);
        $stmt->execute();
    
        if ($stmt->errno) {
            closeConn($stmt, $conn);
            die("Error: " . $stmt->error);
        } else {
            echo "Record deleted successfully";
            closeConn($stmt, $conn);
            redirectIndex();
        }
    } else {
        $error_message = "<h1>Invalid request.</h1><br>Element with id $id doesn't exist.";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete element</title>
    <link rel="stylesheet" href="style/style.css?<?=date('U')?>">
    <meta name="description" content="Deletes selected element.">
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
        <h1 id='title'>Are you sure you want to delete this element?</h1>
        <div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input class="back" type="button" value="No" onclick="location.href='index.php'">
                <input type="submit" name="submit" value="Yes">
            </form>
        </div>
        <div id="output"></div>
        <?php
            require 'template/footer.php';
        ?>
    </div>
</body>

</html>