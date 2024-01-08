<?php
    require_once 'functions.php';
    require_once 'validate.php';
    checkSession();
    if (checkPriv() != 2)
        header("Location: login.php");

    $id = $url = $frequency = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
        $userId = testInput($_SESSION['userId']);
        $id = testInput((int)$_POST["id"]);
        
        $conn = startConn();
    
        $stmt = $conn->prepare("DELETE FROM Playlists WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        closeConn($stmt, $conn);
        $conn = startConn();

        $stmt = $conn->prepare("DELETE FROM Users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    
        if ($stmt->errno) {
            closeConn($stmt, $conn);
            die("Error: " . $stmt->error);
        } else {
            echo "Record deleted successfully";
            closeConn($stmt, $conn);
            header("Location: panel.php");
            die();
        }
    } else {
        $error_message = "<h1>Invalid request.</h1><br>Element with id $id doesn't exist.";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete element</title>
    <?php
        require_once 'template/header.php';
        require_once 'template/sidebar.php';
        require_once 'bodies/deleteuser.php';
        require_once 'template/footer.php';
    ?>
</body>

</html>