<?php
// Include this page to all other pages we create
// Lets leave this so we can see all the currently outputted errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'conf.php';
require 'csrf_protection.php';

function displayDataToTable() {
    global $settings;

    $conn = new mysqli($settings['serverName'], $settings['userName'], $settings['password'], $settings['dbName']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Playlists";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td><a href="' . $row['url'] . '" target="_blank">' . $row['url'] . '</a></td>';
            echo '<td>' . frequencyToText($row['frequency']) . '</td>';
            echo '<td>' . ($row['lastDownload'] != 0 ? date('Y-m-d', $row['lastDownload']) : 'Never') . '</td>';
            echo '<td><a href="edit.php?id=' . $row['id'] . '">Edit</a></td>';
            echo '<td><a href="delete.php?id=' . $row['id'] . '">Delete</a></td>';
            echo '</tr>';
        }
    } else {
        die ("<h1>Error displaying table: </h1>". $conn->error);
    }

    $conn->close();
}

function closeConn($stmt, $conn){
    $stmt->close();
    $conn->close();
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