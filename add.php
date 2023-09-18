<?php
    require 'functions.php';
    require 'validate.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($urlErr) && empty($frequencyErr)) {
        $url = $_POST["url"];
        $frequency = $_POST["frequency"];
    
        $jsonData = file_get_contents('job.json');
        $data = json_decode($jsonData, true);
    
        $newEntry = [
            "id" => ++$data["lastID"], 
            "url" => $url,
            "frequency" => (int)$frequency,
            "lastDownload" => 0,
        ];
        
        $data["data"][] = $newEntry;
    
        file_put_contents('job.json', json_encode($data, JSON_PRETTY_PRINT));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a playlist</title>
</head>
<body>
    <h1>Add a playlist</h1>
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
