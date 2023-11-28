<?php
/*
    :)
*/
require 'functions.php';
checkSession();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['text'] == "XD")
        header("Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ");
    else
        header("Location: https://www.youtube.com/watch?v=ajmvgIcu59M");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>All HTML Input Types</title>
    <link rel="stylesheet" href="style.css?<?=date('U')?>">
</head>
<body>
    <?php
        require 'template/header.php';
        require 'template/sidebar.php';
    ?>
    <div id='content'>
        <h1>A HTML form of all types!</h1>
        <form action="#" method="post">
            <label for="text">Text Input:</label>
            <input type="text" id="text" name="text"><br><br>

            <label for="password">Password Input:</label>
            <input type="password" id="password" name="password"><br><br>

            <label for="email">Email Input:</label>
            <input type="email" id="email" name="email"><br><br>

            <label for="number">Number Input:</label>
            <input type="number" id="number" name="number"><br><br>

            <label for="date">Date Input:</label>
            <input type="date" id="date" name="date"><br><br>

            <label for="time">Time Input:</label>
            <input type="time" id="time" name="time"><br><br>

            <label for="color">Color Input:</label>
            <input type="color" id="color" name="color"><br><br>

            <label for="range">Range Input:</label>
            <input type="range" id="range" name="range"><br><br>

            <label for="checkbox">Checkbox:</label>
            <input type="checkbox" id="checkbox" name="checkbox"><br><br>

            <label for="radio">Radio Buttons:</label>
            <input type="radio" id="radio1" name="radio" value="option1">Option 1
            <input type="radio" id="radio2" name="radio" value="option2">Option 2
            <input type="radio" id="radio3" name="radio" value="option3">Option 3<br><br>

            <label for="file">File Input:</label>
            <input type="file" id="file" name="file"><br><br>

            <label for="submit">Submit Button:</label>
            <input type="submit" id="submit" value="Submit"><br><br>

            <label for="reset">Reset Button:</label>
            <input type="reset" id="reset" value="Reset"><br><br>

            <label for="button">Button:</label>
            <button type="button" id="button">Click Me</button><br><br>

            <label for="image">Image Input:</label>
            <input type="image" id="image" src="image.png" alt="Submit"><br><br>

            <label for="hidden">Hidden Input:</label>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"><br><br>

            <label for="search">Search Input:</label>
            <input type="search" id="search" name="search"><br><br>

            <label for="url">URL Input:</label>
            <input type="url" id="url" name="url"><br><br>

            <label for="tel">Telephone Input:</label>
            <input type="tel" id="tel" name="tel"><br><br>
            
            <label for="week">Week Input:</label>
            <input type="week" id="week" name="week"><br><br>
            
            <label for="month">Month Input:</label>
            <input type="month" id="month" name="month"><br><br>

            <label for="datetime-local">Datetime-Local Input:</label>
            <input type="datetime-local" id="datetime-local" name="datetime-local"><br><br>
        </form>
        <div id="output"></div>
        <?php
            require 'template/footer.php';
        ?>
    </div>
</body>
</html>
