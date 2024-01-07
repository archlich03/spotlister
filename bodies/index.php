    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
    </header>

    <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
        <div class="w3-container w3-red w3-padding-16">
            <div class="w3-left"><i class="fa fa-music w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><?=checkMyPlaylists()?></h3>
            </div>
            <div class="w3-clear"></div>
                <h4>My playlists</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-blue w3-padding-16">
            <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><?=checkTotalPlaylists()?></h3>
            </div>
            <div class="w3-clear"></div>
                <h4>Total playlists</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-orange w3-text-white w3-padding-16">
            <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><?=checkUsers()?></h3>
            </div>
            <div class="w3-clear"></div>
                <h4>Users</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-teal w3-padding-16">
            <div class="w3-left"><i class="fa fa-rotate-left w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><span id="timer">00:00:00</span></h3>
            </div>
            <div class="w3-clear"></div>
                <h4>Refreshes in</h4>
        </div>
    </div>

    <div class="w3-panel">
        <div class="w3-row-padding" style="margin:0 -16px">
            <div class="w3-container">
                <h5>My tracked playlists</h5>
                <table class="w3-table w3-striped w3-white">
                <tr>
                    <th>Spotify URL&nbsp;&nbsp;<i class="fa fa-info-circle" title="Link to the tracked playlist"></i></th>
                    <th>Resync Frequency&nbsp;<i class="fa fa-info-circle" title="How often should the playlist be resynced"></i></th>
                    <th>Last checked&nbsp;<i class="fa fa-info-circle" title="How long ago was the playlist last synced"></i></th>
                    <th >Actions</th>
                </tr>
                <?php
                displayDataToTable();
                ?>
                </table>
            </div>
        <div id="output"></div>
    </div>