<div class="w3-container">
    <h1 id='title'>Edit User</h1>
    <span>ID: <?=htmlspecialchars($id)?></span>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?=htmlspecialchars($id)?>">
        <br>
        <p>Approved: <input type="checkbox" name="approved" value="1" <?php echo ($approved == 1) || ($approved == 2) ? 'checked' : ''; ?>></p>
        <p>Make admin?: <input type="checkbox" name="approved" value="2" <?php echo ($approved == 2) ? 'checked' : ''; ?>></p>
        <p>Reset password to: <input type="password" name="password"></p>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <input class="w3-button w3-red" type="button" value="Back" onclick="location.href='panel.php'">
        <input type="submit" name="submit" value="Submit" class="w3-button w3-gray"><br>
        <span class="error"><?php echo isset($error) ? $error : ''; ?></span>
    </form>
</div>