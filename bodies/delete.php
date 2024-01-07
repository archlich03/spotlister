<div class="w3-container">
    <h1 id='title'>Are you sure you want to delete this playlist?</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <input class="w3-button w3-red" type="button" value="No" onclick="location.href='index.php'">
        <input type="submit" name="submit" value="Yes" class="w3-button w3-gray">
    </form>
    <div id="output"></div>
</div>