<?php
// Include this page to all other pages we create
// Lets leave this so we can see all the currently outputted errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'conf.php';

function displayJSONDataToTable() {
    global $settings;

    $data = readJSON($settings['dataFileName']);
    
    foreach ($data['data'] as $item) {
        echo '<tr>';
        echo '<td><a href="' . $item['url'] . '" target="_blank">' . $item['url'] . '</a></td>';
        echo '<td>' . frequencyToText($item['frequency']) . '</td>';
        echo '<td>' . ($item['lastDownload'] != 0 ? date('Y-m-d', $item['lastDownload']) : 'Never') . '</td>';
        echo '<td><a href="edit.php?id='.$item['id'].'">Edit</a></td>';
        echo '<td><a href="delete.php?id='.$item['id'].'">Delete</a></td>';
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
    if(file_exists($filename)) {
        $jsonData = file_get_contents($filename);
        $data = json_decode($jsonData, true);
        return $data;
    }
    else {
        $data = ["lastScan" => 0, "lastID" => 0, "data" => []];

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($filename, $jsonData);
        return $data;
        
    }
}
function convertDataToCSV($data) {
    $csv = "id,url,frequency,lastDownload\n";
    foreach ($data['data'] as $item) {
        $csv .= $item['id'] . ',' . $item['url'] . ',' . $item['frequency'] . ',' . date('Y-m-d', $item['lastDownload']) . "\n";
    }
    return $csv;
}
function convertDataToText($data) {
    $text = "";
    foreach ($data['data'] as $item) {
        $text .= "ID: " . $item['id'] . "\n";
        $text .= "URL: " . $item['url'] . "\n";
        $text .= "Frequency: " . frequencyToText($item['frequency']) . "\n";
        $text .= "Last Download: " . date('Y-m-d', $item['lastDownload']) . "\n";
        $text .= "------------------------------------\n";
    }
    return $text;
}