<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong><?=checkName()?></strong></span><br>
      <a href="logout.php" class="w3-bar-item w3-button" title="Log out"><i class="fa fa-arrow-right"></i></a>
      <a href="profile.php" class="w3-bar-item w3-button" title="Edit profile"><i class="fa fa-user"></i></a>
      <?php
      if (checkPriv() == 2)
        echo "<a href=\"panel.php\" class=\"w3-bar-item w3-button\" title=\"User Management\"><i class=\"fa fa-cog\"></i></a>";
      ?>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Actions</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i> Close Menu</a>
    
    <?php
        $side_overview = "";
        $side_new_entry = "";
        $side_refresh_media = "";

        if ($_SERVER['PHP_SELF'] == "/index.php")
            $side_overview = "w3-blue";
        if ($_SERVER['PHP_SELF'] == "/add.php")
            $side_new_entry = "w3-blue";
    ?>
    <a href="index.php" class="w3-bar-item w3-button w3-padding <?=$side_overview?>"><i class="fa fa-users fa-fw"></i> Overview</a>
    <a href="add.php" class="w3-bar-item w3-button w3-padding <?=$side_new_entry?>"><i class="fa fa-pencil fa-fw"></i> New Entry</a>
    <a href="#" id="fetchOutputLink" class="w3-bar-item w3-button w3-padding"><i class="fa fa-rotate-left fa-fw"></i> Refresh media</a>
  </div>
</nav>



<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">