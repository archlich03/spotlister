<?php
$urlErr = $frequencyErr = "";

$frequencyMinValue = -1;
if ($settings["allowOneTimeImport"] == false)
    $frequencyMinValue = 0;
if ($settings["allowOneTimeImport"] == false && $settings["allowConstantRefresh"] == false)
    $frequencyMinValue = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["url"])) {
        $urlErr = "URL is required; ";
    } else {
        $url = testInput($_POST["url"]);
        if (!preg_match('#spotify\.com/#i', $url)) {
            $urlErr = "Invalid URL. It must be a Spotify link; ";
        }
      }
      if ($_POST["frequency"] == "") {
        $frequencyErr .= "Check frequency is required; ";
    } elseif ($_POST["frequency"] > $settings['maxRefreshTime']) {
        $frequencyErr .= "Frequency must be smaller than " . $settings['maxRefreshTime']."; ";
    }

    if ($settings["allowOneTimeImport"] == false && (int)$_POST["frequency"] == -1)
        $frequencyErr .= "Current settings don't allow one time importing of media. Try selecting a different frequency; ";
    if ($settings["allowConstantRefresh"] == false && (int)$_POST["frequency"] == 0)
        $frequencyErr .= "Current settings don't allow constant importing of media. Try selecting a different frequency; ";
}
?>
