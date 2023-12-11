<?php

require 'conf.php';
require 'functions.php';

function setupDB() {
    $conn = startConn();
    
    $sqlPlaylists = "
    CREATE TABLE IF NOT EXISTS Playlists (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        url VARCHAR(255) NOT NULL,
        frequency INT(15) NOT NULL,
        lastDownload INT(15) NOT NULL,
        user_id INT(6) UNSIGNED NOT NULL
    )
    ";
    
    $sqlScanData = "
    CREATE TABLE IF NOT EXISTS ScanData (
        lastScan INT(15) NOT NULL
    )
    ";

    $sqlUsers = "
    CREATE TABLE IF NOT EXISTS Users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        approved INT(1) NOT NULL
    )
    ";
    
    $conn->query($sqlPlaylists);
    $conn->query($sqlScanData);
    $conn->query($sqlUsers);
    $conn->close();
}

setupDB();
?>