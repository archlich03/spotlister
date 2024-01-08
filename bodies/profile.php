<div class="w3-container">
    <h1>Edit profile</h1>
    <div>
        <form method="post" action="">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <p>Current Password: <input type="password" name="password" required></p>
            <p>New Password: <input type="password" name="newPassword" required></p>
            <p>Confirm Password: <input type="password" name="confPassword" required></p>
            <input class="w3-button w3-gray" type="button" value="Cancel" onclick="location.href='index.php'">
            <input type="submit" name="submit" value="Confirm" class="w3-button w3-red"><br>
            <span class="error"><?php echo isset($error) ? $error : ''; ?></span>
        </form>
    </div>
    <div id="output"></div>
</div>