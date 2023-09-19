<?php
    require 'functions.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($urlErr) && empty($frequencyErr)) {
        $url = testInput($_POST["url"]);
        $frequency = (int)testInput($_POST["frequency"]);
        
        if ($frequency > $settings['maxRefreshTime'] || $frequency < -1)
            die("Invalid frequency range.");

        if (!preg_match('#spotify\.com/#i', $url) || empty($_POST["url"]))
            die("URL can't be empty and must be a spotify link");
    
        $jsonData = file_get_contents($settings['dataFileName']);
        $data = json_decode($jsonData, true);
    
        $newEntry = [
            "id" => ++$data["lastID"], 
            "url" => $url,
            "frequency" => $frequency,
            "lastDownload" => 0,
        ];
        $data["data"][] = $newEntry;
    
        file_put_contents($settings['dataFileName'], json_encode($data, JSON_PRETTY_PRINT));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add an element</title>
</head>
<body>
    <h1>Add an element</h1>
    <div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <p>Playlist URL: <input type="url" name="url" style="width: 450px;"></p>
            <span class="error"><?php echo $urlErr;?></span>
            <br>
            <p>Check frequency (in hours): <input type="number" name="frequency" min="-1"></p>
            <span class="error"><?php echo $frequencyErr;?></span>
            <br><br>

            <input class="back" type="button" value="Back" onclick="location.href='index.php'">
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>

</html>
