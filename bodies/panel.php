<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
        <div class="w3-container">
            <h5>All users</h5>
            <table class="w3-table w3-striped w3-white">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                <?php
                    displayUsersToTable();
                ?>
            </table>
        </div>
    <div id="output"></div>
</div>