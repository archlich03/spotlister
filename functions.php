<?php
// Include this page to all other pages we create
// Lets leave this so we can see all the currently outputted errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'conf.php';
require 'csrf_protection.php';

function displayDataToTable() {
    global $settings;

    $conn = startConn();

    $stmt = $conn->prepare("SELECT * FROM Playlists WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['userId']);
    $stmt->execute();

    $result = $stmt->get_result();
    
    if ($result->num_rows > 0 && checkPriv() > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td><a href="' . $row['url'] . '" target="_blank">' . $row['url'] . '</a></td>';
            echo '<td>' . frequencyToText($row['frequency']) . '</td>';
            echo '<td>' . ($row['lastDownload'] != 0 ? date('Y-m-d', $row['lastDownload']) : 'Never') . '</td>';
            echo '<td><a href="edit.php?id=' . $row['id'] . '">Edit</a></td>';
            echo '<td><a href="delete.php?id=' . $row['id'] . '">Delete</a></td>';
            echo '</tr>';
        }
    } else if ($result->num_rows == 0 || checkPriv() == 0) {
        echo '<tr><td colspan="5">No elements found. Please login first.</td></tr>';
    } else {
        die ("<h1>Error displaying table: </h1>". $conn->error);
    }

    closeConn($stmt, $conn);
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

function validateRegister($username, $password){
    $username = testInput($username);
    $password = testInput($password);

    switch ($password){
        case strlen($username)==0: // perkelt
            return "Username cannot be empty";
        case !strlen($password)>8: // iki 64
            return "Password must be at least 8 characters long";
        case !preg_match('/[A-Z]/', $password)
            || !preg_match('/[a-z]/', $password)
            || !preg_match('/[0-9]/', $password)
            || !preg_match('/[^A-Za-z0-9]/', $password):
            return "Password must contain at least one uppercase letter, one lowercase letter, one number and one special character";
        default:
            return true;
    }

}
function validateLogin($username, $password){
    $username = testInput($username);
    $password = testInput($password);

    switch ($password){
        case strlen($username)==0:
            return "Username cannot be empty";
        case strlen($password)==0:
            return "Password cannot be empty";
        default:
            return true;
    }

}

function startConn(){
    global $settings;

    $conn = new mysqli($settings['serverName'], $settings['userName'], $settings['password'], $settings['dbName']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function checkPriv(){
    $conn = startConn();
    $userId = testInput($_SESSION['userId']);


    $stmt = $conn->prepare("SELECT approved FROM Users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($approved);
        $stmt->fetch();
        return $approved;
    } else {
        return false;
    }
}
function checkSession(){
    if(!isset($_SESSION['userId']) || checkPriv() == false){
        redirectIndex();
        exit;
    }
}