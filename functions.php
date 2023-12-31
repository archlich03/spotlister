<?php
// Include this page to all other pages we create
// Lets leave this so we can see all the currently outputted errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'conf.php';
require_once 'csrf_protection.php';

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
            echo '<td><a href="edit.php?id=' . $row['id'] . '">Edit</a> | <a href="delete.php?id=' . $row['id'] . '">Delete</a></td>';
            echo '</tr>';
        }
    } elseif ($result->num_rows == 0 || checkPriv() == 0) {
        echo '<tr><td colspan="5">No entries found. Please <a href="add.php">add new entries</a>.</td></tr>';
    } else {
        die ("<h1>Error displaying table: </h1>". $conn->error);
    }

    closeConn($stmt, $conn);
}
function displayUsersToTable() {
    $conn = startConn();

    $stmt = $conn->prepare("SELECT id, username, approved FROM Users");
    $stmt->execute();

    $result = $stmt->get_result();
    
    if ($result->num_rows > 0 && checkPriv() > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>' . numberToPriv($row['approved']) . '</td>';
            echo '<td><a href="edituser.php?id=' . $row['id'] . '">Edit</a> | <a href="deleteuser.php?id=' . $row['id'] . '">Delete</a></td>';
            echo '</tr>';
        }
    } else {
        echo '<p>No users found.</p>';
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
function numberToPriv($priv) {
    $answer = '';
    if ($priv == 0)
        $answer = "User";
    elseif ($priv == 1)
        $answer = "Approved";
    else
        $answer = "Admin";
    return $answer;
}
function testInput($data) {
    if ($data === null) {
        return null;
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function redirectIndex() {
    header("Location: index.php");
    exit;
}
function sortToLogin() {
    if (checkPriv() == 0) {
        header("Location: login.php");
    }
}
function convertDataToCSV() {
    global $settings;

    $csv = "id,url,frequency,lastDownload\n";
    $conn = new mysqli($settings['serverName'], $settings['userName'], $settings['password'], $settings['dbName']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, url, frequency, lastDownload FROM Playlists WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['userId']);
    $stmt->execute();
    $result = $stmt->get_result();

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

    $stmt = $conn->prepare("SELECT id, url, frequency, lastDownload FROM Playlists WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['userId']);
    $stmt->execute();
    $result = $stmt->get_result();

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

    $stmt = $conn->prepare("SELECT id, url, frequency, lastDownload FROM Playlists WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['userId']);
    $stmt->execute();
    $result = $stmt->get_result();

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
        case strlen($username)==0:
            return "Username cannot be empty";
        case !strlen($password)>8:
            return "Password must be at least 8 characters long";
        case strlen($password)>64:
            return "Password cannot be longer than 64 characters";
        case strlen($username)>24:
            return "Username cannot be longer than 24 characters";
        case strlen($username)<5:
            return "Username cannot be shorter than 5 characters";
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
    if(!isset($_SESSION['userId'])) {
        return false;
    }
    else{
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
}
function checkSession(){
    if(!isset($_SESSION['userId']) || checkPriv() == false){
        header("Location: login.php");
        exit;
    }
}
function checkName(){
    $conn = startConn();
    if(!isset($_SESSION['userId'])) {
        return false;
    }
    else{
        $userId = testInput($_SESSION['userId']);


        $stmt = $conn->prepare("SELECT username FROM Users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($name);
            $stmt->fetch();
            return $name;
        } else {
            return false;
        }
    }
}

function checkMyPlaylists(){
    $conn = startConn();
    if(!isset($_SESSION['userId'])) {
        return false;
    }
    else{
        $userId = testInput($_SESSION['userId']);

        $stmt = $conn->query("SELECT id FROM Playlists WHERE user_id = $userId");
        return $stmt->num_rows;
    }
}

function checkTotalPlaylists(){
    $conn = startConn();
    $stmt = $conn->query("SELECT id FROM Playlists");
    return $stmt->num_rows;
}

function checkUsers(){
    $conn = startConn();
    if(!isset($_SESSION['userId'])) {
        return false;
    }
    else{
        $userId = testInput($_SESSION['userId']);

        $stmt = $conn->query("SELECT id FROM Users");
        return $stmt->num_rows;
    }
}