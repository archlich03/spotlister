<?php
    require_once 'functions.php';
    if (checkPriv() > 0) {
        redirectIndex();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
        $validationResult = validateLogin($_POST["username"], $_POST["password"]);

        if ($validationResult === true){
            $username = $_POST["username"];
            $password = $_POST["password"];

            $conn = startConn();

            $stmt = $conn->prepare("SELECT id, username, password, approved FROM Users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($userId, $dbUsername, $dbPassword, $approved);
                $stmt->fetch();

                if (password_verify($password, $dbPassword) && $approved > 0) {
                    session_start();

                    $_SESSION['userId'] = testInput($userId);
                    redirectIndex();
                } else {
                    $error = "Such approved user not found!";
                }
            } else {
                $error = "Such approved user not found!";
            }
        } else {
            $error = $validationResult;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="w3-clear">Login</title>
</head>
<style>
    body {
        font-family: "Raleway", sans-serif;
    }
    main {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    form {
        background-color: #f1f1f1;
        padding: 20px;
        border-radius: 5px;
        max-width: 400px;
        width: 100%;
    }

    h1 {
        text-align: center;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    a {
        text-decoration: underline;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #8b0000;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    footer {
        text-align: center;
        margin-top: 15px;
    }
</style>
<body>
<main>
    <form action="login.php" method="post">
        <h1>Login</h1>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit" name="login">Login</button>
        <span class="error"><?php echo isset($error) ? $error : ''; ?></span>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <footer>Not a member? <a href="register.php">Register here</a></footer>
    </form>
</main>
</body>
</html>