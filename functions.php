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
function convertDataToCSV() {
    global $settings;

    $csv = "id,url,frequency,lastDownload\n";
    $conn = new mysqli($settings['serverName'], $settings['userName'], $settings['password'], $settings['dbName']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, url, frequency, lastDownload FROM Playlists";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $csv .= $row['id'] . ',' . $row['url'] . ',' . $row['frequency'] . ',' . date('Y-m-d', $row['lastDownload']) . "\n";
        }
    }

    $conn->close();
    return $csv;
}
function convertDataToText() {
    $text = "";
    global $settings;

    $conn = new mysqli($settings['serverName'], $settings['userName'], $settings['password'], $settings['dbName']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, url, frequency, lastDownload FROM Playlists";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $text .= "ID: " . $row['id'] . "\n";
            $text .= "URL: " . $row['url'] . "\n";
            $text .= "Frequency: " . frequencyToText($row['frequency']) . "\n";
            $text .= "Last Download: " . date('Y-m-d', $row['lastDownload']) . "\n";
            $text .= "------------------------------------\n";
        }
    }

    $conn->close();
    return $text;
}
function convertDataToJSON(){
    global $settings;

    $json = [];

    $conn = new mysqli($settings['serverName'], $settings['userName'], $settings['password'], $settings['dbName']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, url, frequency, lastDownload FROM Playlists";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $json[] = $row;
        }
    }
    $conn->close();
    return json_encode($json);
}