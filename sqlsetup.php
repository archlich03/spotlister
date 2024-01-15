<?php
    require_once 'conf.php';
    require_once 'functions.php';

    function setupDB() {
        $conn = startConn();
        $success = true;
        
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
        
        if ($conn->query($sqlPlaylists) !== true) {
            $success = false;
            echo "Error creating table Playlists: " . $conn->error . "<br>";
        }

        if ($conn->query($sqlScanData) !== true) {
            $success = false;
            echo "Error creating table ScanData: " . $conn->error . "<br>";
        }

        if ($conn->query($sqlUsers) !== true) {
            $success = false;
            echo "Error creating table Users: " . $conn->error . "<br>";
        }
        
        $conn->close();
        if($success === true) {
            unlink(__FILE__);
        }
    }

    setupDB();
?>
