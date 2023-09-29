<?php
    require 'functions.php';
    require 'validate.php';

    $id = $url = $frequency = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && empty($urlErr) && empty($frequencyErr)) {
        $id = (int)$_POST["id"];

        $data = readJSON($settings['dataFileName']);

        $elementKey = null;
        foreach ($data["data"] as $key => $item) {
            if ($item["id"] === $id) {
                $elementKey = $key;
                break;
            }
        }

        if ($elementKey !== null) {
            $data["data"][$key]["url"] = $_POST["url"];
            $data["data"][$key]["frequency"] = (int)$_POST["frequency"];

            file_put_contents($settings['dataFileName'], json_encode($data, JSON_PRETTY_PRINT));
            redirectIndex();
        } else {
            die ("ID not found");
        }

    } 
    elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && empty($urlErr)) {

        $id = (int)$_GET["id"];

        $data = readJSON($settings['dataFileName']);

        $element = null;

        foreach ($data["data"] as $item) {
            if ($item["id"] === $id) {
                $element = $item;
                break;
            }
        }

        if ($element !== null) {
            $url = $element["url"];
            $frequency = $element["frequency"];
        } else {
            die ("ID not found");
        }
    }
    else {
        die ("<h1>Invalid request.</h1><br>URL related errors: $urlErr<br>Frequency related errors: $frequencyErr");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit element</title>
    <link rel="stylesheet" href="style.css?<?=date('U')?>">
    <meta name="description" content="Edit playlist/link information.">
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
        <h1>Edit element</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <p>Playlist URL: <input type="url" name="url" style="width: 450px;" value="<?php echo htmlspecialchars($url); ?>"></p>
            <span class="error"><?php echo $urlErr;?></span>
            <br>
            <p>Check frequency (in hours): <input type="number" name="frequency" min="<?=$frequencyMinValue;?>" max="<?=$settings['maxRefreshTime']?>" value="<?=htmlspecialchars($frequency);?>"></p>
            <span class="error"><?php echo $frequencyErr;?></span>
            <br><br>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <input class="back" type="button" value="Back" onclick="location.href='index.php'">
            <input type="submit" name="submit" value="Submit">
        </form><br>
        <div id="output"></div>
        <?php
            require 'template/footer.php';
        ?>
    </div>
</body>

</html>