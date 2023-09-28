<?php
    require 'functions.php';
    require 'validate.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($urlErr) && empty($frequencyErr)) {
        $url = $_POST["url"];
        $frequency = $_POST["frequency"];
    
        $data = readJSON($settings['dataFileName']);
    
        $newEntry = [
            "id" => ++$data["lastID"], 
            "url" => $url,
            "frequency" => (int)$frequency,
            "lastDownload" => 0,
        ];
        
        $data["data"][] = $newEntry;
        file_put_contents($settings['dataFileName'], json_encode($data, JSON_PRETTY_PRINT));
        redirectIndex();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add an element</title>
    <link rel="stylesheet" href="style.css?<?=date('U')?>">
    <meta name="description" content="Adds new element.">
    <meta name="keywords" content="spotify, converter, link">
    <meta name="author" content="We, The People">
    <meta name="date" content="2023-09-20">
    <meta name="expiry-date" content="2077-09-20">
    <meta name="robots" content="index, follow">
</head>
<body>
    <?php
        require 'template/header.html';
        require 'template/sidebar.html';
    ?>
    <div id='content'>
        <div id="output"></div>
        <h1>Add an element</h1>
        <div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <p>Playlist URL: <input type="url" name="url" style="width: 450px;"></p>
                <span class="error"><?php echo $urlErr;?></span>
                <br>
                <p>Check frequency (in hours): <input type="number" name="frequency" min="<?=$frequencyMinValue;?>" max="<?=$settings['maxRefreshTime'];?>"></p>
                <span class="error"><?php echo $frequencyErr;?></span>
                <br><br>
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input class="back" type="button" value="Back" onclick="location.href='index.php'">
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    <?php
        require 'template/footer.php';
    ?>
    </div>
</body>

</html>
