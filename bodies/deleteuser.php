<div class="w3-container">
    <h1 id='title'>Are you sure you want to delete this user?</h1>
    <div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <input class="w3-button w3-red" type="button" value="No" onclick="location.href='panel.php'">
            <input type="submit" name="submit" value="Yes" class="w3-button w3-gray">
        </form>
    </div>
    <div id="output"></div>
</div>