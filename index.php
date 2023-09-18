<?php
    require 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Link to Jellyfin maintainer</title>
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
</body>
</html>
