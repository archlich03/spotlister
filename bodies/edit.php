<div class="w3-container">
    <h1 id='title'>Edit element</h1>
    <form method="post" action="">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <p>Playlist URL: <input type="url" name="url" style="width: 450px;" value="<?php echo htmlspecialchars($url); ?>"></p>
        <span class="error"><?php echo $urlErr;?></span>
        <p>Check frequency (in hours): <input type="number" name="frequency" min="<?=$frequencyMinValue;?>" max="<?=$settings['maxRefreshTime']?>" value="<?=htmlspecialchars($frequency);?>"></p>
        <span class="error"><?php echo $frequencyErr;?></span>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <input class="w3-button w3-grey" type="button" value="Back" onclick="location.href='index.php'">
        <input type="submit" name="submit" value="Submit" class="w3-button w3-red">
    </form>
</div>