<?php
    require 'functions.php';
    require 'validate.php';

    $id = $url = $frequency = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
        $id = (int)$_POST["id"];

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
            redirectIndex();
        }
        
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete element</title>
</head>
<body>
    <h1>Are you sure you want to delete this element?</h1>
    <div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <input class="back" type="button" value="No" onclick="location.href='index.php'">
            <input type="submit" name="submit" value="Yes">
        </form>
    </div>
</body>

</html>