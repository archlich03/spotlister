<?php
    require 'functions.php';
    require 'validate.php';

    checkSession();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($urlErr) && empty($frequencyErr)) {
        $userId = testInput($_SESSION['userId']);
        $url = $_POST["url"];
        $frequency = $_POST["frequency"];

        $conn = startConn();

        $sql = "INSERT INTO Playlists (url, frequency, lastDownload, user_id) VALUES (?, ?, 0, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $url, $frequency, $userId);
        $stmt->execute();

        if ($stmt->errno) {
            closeConn($stmt, $conn);
            die("Error: " . $stmt->error);
        } else {
            echo "New record created successfully";
            closeConn($stmt, $conn);
            redirectIndex();
        }   
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="title">Add an element</title>
    <link rel="stylesheet" href="style.css?<?=date('U')?>">
    <meta name="description" content="Adds new element.">
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
        <h1 id='title'>Add an element</h1>
        <div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <p>Playlist URL: <input type="url" name="url" style="width: 450px;"></p>
                <span class="error"><?php echo $urlErr;?></span>
                <p>Check frequency (in hours): <input type="number" name="frequency" min="<?=$frequencyMinValue;?>" max="<?=$settings['maxRefreshTime'];?>"></p>
                <span class="error"><?php echo $frequencyErr;?></span>
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input class="back" type="button" value="Back" onclick="location.href='index.php'">
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
        <div id="output"></div>
        <?php
            require 'template/footer.php';
        ?>
    </div>
</body>

</html>
