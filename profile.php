<?php
    require 'functions.php';
    checkSession();

    $id = $url = $frequency = "";
    $conn = startConn();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["password"]) && isset($_POST["newPassword"])) {
        $userId = testInput($_SESSION['userId']);
        $password = testInput($_POST["password"]);
        $newPassword = testInput($_POST["newPassword"]);

        $stmt = $conn->prepare("SELECT password FROM Users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        closeConn($stmt, $conn);

        $passwordFromForm = trim($_POST["password"]);
        if (!password_verify($passwordFromForm, $hashedPassword)) {
            $error = "Your old password does not match.";
        }
        elseif (validateRegister("user", $passwordFromForm)){
            $error = validateRegister("user", $passwordFromForm);
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
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit profile</title>
    <link rel="stylesheet" href="style/style.css">
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
        <h1 id='title'>Edit profile</h1>
        <div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <p>Current Password: <input type="password" name="password" required></p>
                <p>New Password: <input type="password" name="newPassword" required></p>
                <input class="back" type="button" value="No" onclick="location.href='index.php'">
                <input type="submit" name="submit" value="Yes"><br>
                <span class="error"><?php echo isset($error) ? $error : ''; ?></span>
            </form>
        </div>
        <div id="output"></div>
        <?php
            require 'template/footer.php';
        ?>
    </div>
</body>

</html>