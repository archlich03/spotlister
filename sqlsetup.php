<?php

require 'conf.php';

function setupDB() {
    global $settings;

    $conn = new mysqli($settings['serverName'], $settings['userName'], $settings['password'], $settings['dbName']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
    
    $sqlPlaylists = "
    CREATE TABLE IF NOT EXISTS Playlists (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        url VARCHAR(255) NOT NULL,
        frequency INT(15) NOT NULL,
        lastDownload INT(15) NOT NULL
    )
    ";
    
    $sqlScanData = "
    CREATE TABLE IF NOT EXISTS ScanData (
        lastScan INT(15) NOT NULL
    )
    ";
    
    if ($conn->query($sqlPlaylists) === TRUE && $conn->query($sqlScanData) === TRUE) {
        echo "\nTables created successfully";
    } else {
        die ("<h1>Error creating table: </h1>". $conn->error);
    }
    $conn->close();
}
?>