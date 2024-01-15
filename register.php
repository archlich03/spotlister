<?php
    require_once 'functions.php';
    require_once 'captcha/captcha.php';
    if (checkPriv() > 0) {
        redirectIndex();
    }

    $captcha = new Captcha();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $validationResult = validateRegister($_POST["username"], $_POST["password"]);
        $userInput = strtoupper($_POST["captcha"]);
        $captchaText = strtoupper($_SESSION['captcha']);
        
        if ($captcha->verify($userInput, $captchaText)){
            if ($validationResult === true) {
                if ($_POST["password"] == $_POST["confirmpassword"]) {
                    $username = $_POST["username"];
                    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        
                    $conn = startConn();
                    
                    $checkStmt = $conn->prepare("SELECT id FROM Users WHERE username = ?");
                    $checkStmt->bind_param("s", $username);
                    $checkStmt->execute();
                    $checkStmt->store_result();
        
                    if ($checkStmt->num_rows > 0) {
                        $error = "Username already taken. Please choose another one.";
                    } else {
                        $approved = 0;
                        $stmt = $conn->prepare("INSERT INTO Users (username, password, approved) VALUES (?, ?, ?)");
                        $stmt->bind_param("ssi", $username, $password, $approved);
        
                        if ($stmt->execute()) {
                            closeConn($stmt, $conn);
                            redirectIndex();
                        } else {
                            $error = "Error: " . $stmt->error;
                            closeConn($stmt, $conn);
                        }
                    }
        
                    closeConn($checkStmt, $conn);
                } else {
                    $error = "Passwords are non matching. Please try again.";
                }
            } else {
                $error = $validationResult;
            }
        } else {
            $error = "Wrong captcha. Please try again.";
        }
        
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

    .captcha-container {
        display: flex;
        align-items: center;
    }

    .captcha-image {
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>
<body>
<main>
    <form action="register.php" method="post">
        <h1>Sign Up</h1>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required maxlength="16">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required maxlength="64">
        </div>
        <div>
            <label for="confirmpassword">Confirm password:</label>
            <input type="password" name="confirmpassword" id="password" required maxlength="64">
        </div>
        <div class="captcha-container">
            <div class="captcha-image">
                <label for="captcha">Enter the Captcha:</label>
                <img src="captcha/captcha_image.php" alt="Captcha Image">
            </div>
            <input type="text" id="captcha" name="captcha" required>
        </div>
        <button type="submit" name="register">Register</button>
        <span class="error"><?php echo isset($error) ? $error : ''; ?></span>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <footer>Already a member? <a href="login.php">Login here</a></footer>
    </form>
</main>
</body>
</html>
