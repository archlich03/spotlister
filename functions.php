<?php
// Include this page to all other pages we create
// Lets leave this so we can see all the currently outputted errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'conf.php';

function displayJSONDataToTable() {
    global $settings;

    $jsonData = file_get_contents($settings['dataFileName']);
    $data = json_decode($jsonData);
    foreach ($data->data as $item) {
        echo '<tr>';
        echo '<td><a href="' . $item->url . '" target="_blank">' . $item->url . '</a></td>';
        echo '<td>' . frequencyToText($item->frequency) . '</td>';
        echo '<td>' . ($item['lastDownload'] != 0 ? date('Y-m-d', $item['lastDownload']) : 'Never') . '</td>';
        echo '<td><a href="edit.php?id='.$item->id.'">Edit</a></td>';
        echo '<td><a href="delete.php?id='.$item->id.'">Delete</a></td>';
        echo '</tr>';
    }
}

function frequencyToText($frequency) {
    $answer = '';
    if ($frequency == -1)
        $answer = "Once";
    elseif ($frequency == 0)
        $answer = "Every refresh";
    else {
        $hours = $frequency % 24;
        $days = (int)($frequency / 24);
        if ($days > 0)
            $answer = "$days days, $hours h";
        else
            $answer = "$hours h";
    }
    return $answer;
}
function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function redirectIndex() {
    header("Location: index.php");
    exit;
}
function readJSON($filename) {
    $jsonData = file_get_contents($filename);
    $data = json_decode($jsonData, true);
    return $data;
}