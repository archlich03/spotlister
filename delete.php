<?php
    require 'functions.php';
    require 'validate.php';

    $id = $url = $frequency = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
        $id = (int)$_POST["id"];
        testInput($id);
        $data = readJSON('job.json');

        $elementKey = null;
        foreach ($data["data"] as $key => $item) {
            if ($item["id"] === $id) {
                $elementKey = $key;
                break;
            }
        }
    
        if ($elementKey !== null) {
            array_splice($data["data"], $elementKey, 1);

            file_put_contents('job.json', json_encode($data, JSON_PRETTY_PRINT));

            redirectIndex();
        } else {
            die ("<h1>Invalid request.</h1><br>Element with id $id doesn't exist.");
        }
        
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete element</title>
    <link rel="stylesheet" href="style.css?<?=date('U')?>">
    <meta name="description" content="Deletes selected element.">
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
        <h1>Are you sure you want to delete this element?</h1>
        <div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input class="back" type="button" value="No" onclick="location.href='index.php'">
                <input type="submit" name="submit" value="Yes">
            </form>
        </div>
    <?php
        require 'template/footer.php';
    ?>
    </div>
</body>

</html>