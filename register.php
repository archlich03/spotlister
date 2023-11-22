<?php
    require 'functions.php';
    if (checkPriv() > 0) {
        redirectIndex();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $validationResult = validateRegister($_POST["username"], $_POST["password"]);
        if ($validationResult === true){
            $username = $_POST["username"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $conn = startConn();
            
            $approved = 0;
            $stmt = $conn->prepare("INSERT INTO Users (username, password, approved) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $username, $password, $approved);
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
        else {
            $error = $validationResult;
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css?<?=date('U')?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<style>
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
    <form action="register.php" method="post">
        <h1>Sign Up</h1>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit" name="register">Register</button>
        <span class="error"><?php echo isset($error) ? $error : ''; ?></span>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <footer>Already a member? <a href="login.php">Login here</a></footer>
    </form>
</main>
</body>
</html>