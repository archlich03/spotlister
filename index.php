<?php
    require 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Link to Jellyfin maintainer</title>
    
    <!-- Meta Description -->
    <meta name="description" content="Tool which converts spotify link information.">

    <!-- Meta Keywords (optional, but not heavily used by search engines) -->
    <meta name="keywords" content="spotify, converter, link">

    <!-- Author (optional) -->
    <meta name="author" content="We, The People">

    <!-- Page Creation Date (optional) -->
    <meta name="date" content="2023-09-20">

    <!-- Page Expiry Date (optional) -->
    <meta name="expiry-date" content="2077-09-20">

    <!-- Search Engine Indexing (index/follow by default) -->
    <meta name="robots" content="index, follow">

    <!-- Open Graph Metadata (for social sharing) -->
    <meta property="og:title" content="Your Page Title Goes Here">
    <meta property="og:description" content="A concise and informative description of your page's content. Include relevant keywords.">
    <meta property="og:image" content="URL to an image for social sharing">
    <meta property="og:url" content="URL of the page">
    <meta property="og:type" content="website">

    <!-- Twitter Card Metadata (for Twitter sharing) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Your Page Title Goes Here">
    <meta name="twitter:description" content="A concise and informative description of your page's content. Include relevant keywords.">
    <meta name="twitter:image" content="URL to an image for Twitter sharing">

    <!-- Viewport Settings -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Generator (optional, identifies the tool used to generate the page) -->
    <meta name="generator" content="Your Website Builder or CMS">

    <!-- Favicon (optional) -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Other custom metadata as needed -->

    <!-- CSS and JavaScript links (typically included below metadata) -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td a {
            text-decoration: none;
            color: blue;
        }

        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Spotify Link to Jellyfin maintainer</h1>
    <p class='refresh'>Next playlist refresh in: <span id="timer">00:00:00</span></p>
    <table>
        <thead>
            <tr>
                <th>URL</th>
                <th>Check Frequency</th>
                <th>Last Check</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                displayJSONDataToTable();
            ?>
        </tbody>
    </table>
    <br>
    <a href="add.php">Add New Entry</a>
    <a href="download.php">Download Data</a>
    <a href="sitemap.html">View Sitemap</a>
    <script>
        function updateTimer() {
            const now = new Date();
            const currentMinutes = now.getMinutes();
            const currentSeconds = now.getSeconds();
            const remainingMinutes = 59 - currentMinutes;
            const remainingSeconds = 60 - currentSeconds;
            const formatTime = (value) => {
                return value < 10 ? `0${value}` : value;
            };

            if (remainingMinutes === 0 && remainingSeconds === 0) {
                clearInterval(timerInterval);
                document.getElementById('timer').textContent = "00:00:00";
                setTimeout(updateTimer, 1000); // Restart the timer
            } else {
                let countdown = `00:00`;
                // `${formatTime(remainingMinutes)}:${formatTime(remainingSeconds)}`;
                if (remainingSeconds != 60)
                    document.getElementById('timer').textContent = `${formatTime(remainingMinutes)}:${formatTime(remainingSeconds)}`;
                else
                    document.getElementById('timer').textContent = `${formatTime(remainingMinutes+1)}:00`;
            }
        }

        // Initial call to set the timer
        updateTimer();

        // Update the timer every second
        const timerInterval = setInterval(updateTimer, 1000);
    </script>
</body>
</html>
