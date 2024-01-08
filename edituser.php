<?php
    require_once 'functions.php';
    checkSession();
    if (checkPriv() != 2)
        header("Location: login.php");

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
        closeConn($stmt, $conn);

        if(isset($_POST["password"]) && !empty($_POST["password"])) {
            $password = testInput($_POST["password"]);
            $validationResult = validateRegister("usertest", $password);
            if ($validationResult !== true) {
                $error = validateRegister("usertest", $password);
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $conn = startConn();
                $stmt = $conn->prepare("UPDATE Users SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $password, $id);
                $stmt->execute();
                if ($stmt->errno) {
                    closeConn($stmt, $conn);
                    die("Error: " . $stmt->error);
                }
            }
        }
        if ($error == null) {
            echo "Record updated successfully";
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
    <title>Edit user</title>
    <?php
        require_once 'template/header.php';
        require_once 'template/sidebar.php';
        require_once 'bodies/edituser.php';
        require_once 'template/footer.php';
    ?>
</body>

</html>