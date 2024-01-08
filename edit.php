<?php
    require_once 'functions.php';
    require_once 'validate.php';
    checkSession();

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

        $id = (int)testInput((int)$_GET["id"]);
        $userId = (int)testInput($_SESSION['userId']);

        $stmt = $conn->prepare("SELECT url, frequency FROM Playlists WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $userId);
        $stmt->execute();

        $stmt->bind_result($url, $frequency);
        $stmt->fetch();
        //die(var_dump($url));
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
    <title>Edit playlist</title>
    <?php
        require_once 'template/header.php';
        require_once 'template/sidebar.php';
        require_once 'bodies/edit.php';
        require_once 'template/footer.php';
    ?>
</body>

</html>