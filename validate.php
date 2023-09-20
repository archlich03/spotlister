<?php
$urlErr = $frequencyErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["url"])) {
        $urlErr = "URL is required";
    } else {
        $url = testInput($_POST["url"]);
        if (!preg_match('#spotify\.com/#i', $url)) {
            $urlErr = "Invalid URL. It must be a Spotify link.";
        }
      }
      if (empty($_POST["frequency"])) {
        $frequencyErr = "Check frequency is required";
    } elseif (!is_numeric($_POST["frequency"]) || $_POST["frequency"] < -1) {
        $frequencyErr = "Check frequency must be bigger than -1";
    }
  
}
?>
