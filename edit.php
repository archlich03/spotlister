<?php
    require 'functions.php';
    require 'validate.php';

    // TODO: add login/register buttons, admin panel, change allowed bool to
    // 0 - unallowed, 1 - allowed, 2 - admin
    // add test class

    $id = $url = $frequency = "";

    $conn = startConn();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && empty($urlErr) && empty($frequencyErr)) {
        $id = testInput((int)$_POST["id"]);
        $userId = testInput($_SESSION['userId']);

        $stmt = $conn->prepare("UPDATE Playlists SET url = ?, frequency = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("siii", $url, $frequency, $id, $user_id);
        $stmt->execute();

        if ($stmt->errno) {
            closeConn($stmt, $conn);
            die("Error: " . $stmt->error);
        } else {
            echo "Record updated successfully";
            closeConn($stmt, $conn);
            redirectIndex();
        }

    } 
    elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && empty($urlErr)) {

        $id = testInput((int)$_GET["id"]);
        $userId = testInput($_SESSION['userId']);

        $stmt = $conn->prepare("SELECT url, frequency FROM Playlists WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();

        $stmt->bind_result($url, $frequency);
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
    <link rel="stylesheet" href="style.css?<?=date('U')?>">
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
        require 'template/header.html';
        require 'template/sidebar.html';
    ?>
    <div id='content'>
        <h1 id='title'>Edit element</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <p>Playlist URL: <input type="url" name="url" style="width: 450px;" value="<?php echo htmlspecialchars($url); ?>"></p>
            <span class="error"><?php echo $urlErr;?></span>
            <br>
            <p>Check frequency (in hours): <input type="number" name="frequency" min="<?=$frequencyMinValue;?>" max="<?=$settings['maxRefreshTime']?>" value="<?=htmlspecialchars($frequency);?>"></p>
            <span class="error"><?php echo $frequencyErr;?></span>
            <br><br>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <input class="back" type="button" value="Back" onclick="location.href='index.php'">
            <input type="submit" name="submit" value="Submit">
        </form><br>
        <div id="output"></div>
        <?php
            require 'template/footer.php';
        ?>
    </div>
</body>

</html>