<div class="w3-container">
    <h1>Track a new playlist</h1>
    <form method="post" action="">
        <p>Playlist URL: <input type="url" name="url" style="width: 450px;"></p>
        <span class="error"><?php echo $urlErr;?></span>
        <p>Check frequency (in hours): <input type="number" name="frequency" min="<?=$frequencyMinValue;?>" max="<?=$settings['maxRefreshTime'];?>"></p>
        <span class="error"><?php echo $frequencyErr;?></span>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <input class="w3-button w3-gray" type="button" value="Back" onclick="location.href='index.php'">
        <input type="submit" name="submit" value="Submit" class="w3-button w3-red">
    </form>
    <br>
    <span>Here are some additional tips:</span>
    <ul>
        <li>If you set check frequency to be -1, then it will be synced only once and removed from the system</li>
        <li>Don't import long playlists, it may cause the system to not be able to sync music properly. As an alternative, please split them up. Use up to 20 songs per playlist</li>
    </ul>
</div>