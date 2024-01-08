<?php
    require_once 'functions.php';
    require_once 'validate.php';

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
    <title id="title">Track a new playlist</title>
    <?php
        require_once 'template/header.php';
        require_once 'template/sidebar.php';
        require_once 'bodies/add.php';
        require_once 'template/footer.php';
    ?>  
    </div>
</body>

</html>
