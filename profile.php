<?php
    require 'functions.php';
    checkSession();

    $id = $url = $frequency = "";
    $conn = startConn();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["password"]) && isset($_POST["newPassword"])) {
        $userId = testInput($_SESSION['userId']);
        $password = testInput($_POST["password"]);
        $newPassword = testInput($_POST["newPassword"]);
        $confPassword = testInput($_POST["confPassword"]);
        if ($newPassword == $confPassword) {
            $stmt = $conn->prepare("SELECT password FROM Users WHERE id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();
            closeConn($stmt, $conn);

            $passwordFromForm = trim($_POST["password"]);
            $validationResult = validateRegister("usertest", $passwordFromForm);
            $validationNewResult = validateRegister("usertest", $newPassword);
            if (!password_verify($passwordFromForm, $hashedPassword)) {
                $error = "Your old password does not match.";
            }
            elseif ($validationResult !== true) {
                $error = validateRegister("usertest", $passwordFromForm);
            } elseif ($validationNewResult !== true) {
                $error = validateRegister("usertest", $newPassword);
            } else {
                $newPassword = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
                $conn = startConn();
            
                $stmt = $conn->prepare("UPDATE Users SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $newPassword, $userId);
                $stmt->execute();

                if ($stmt->errno) {
                    closeConn($stmt, $conn);
                    die("Error: " . $stmt->error);
                } else {
                    closeConn($stmt, $conn);
                    header("Location: index.php");
                    die();
                }
            }
        } else $error = "Passwords are non matching. Please try again.";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit profile</title>
    <?php
        require_once 'template/header.php';
        require_once 'template/sidebar.php';
        require_once 'bodies/profile.php';
        require_once 'template/footer.php';
    ?>
</body>

</html>