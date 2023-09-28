<html>
    <head>
        <title>Sitemap</title>
        <link rel="stylesheet" href="style.css?<?=date('U')?>">
        <meta name="description" content="Page which contains all the available pages.">
        <meta name="keywords" content="spotify, converter, link">
        <meta name="author" content="We, The People">
        <meta name="date" content="2023-09-20">
        <meta name="expiry-date" content="2077-09-20">
        <meta name="robots" content="index, follow">
    </head>
    <body>
        <?php
            require 'template/header.html';
            require 'template/sidebar.html';
        ?>
        <div id='content'>
            <div id="output"></div>
            <h1>Here's all the available pages to be visited on this website:</h1>
            <ul>
                <li><a href='index.php'>Main page</a></li>
                <li><a href='add.php'>Add media</a></li>
                <li><a href='download.php'>Download configuration</a></li>
                <li><a href='lmao.php'>All HTML form inputs</a></li>
            </ul>
        <?php
            require 'template/footer.php';
        ?>
    </div>
    </body>
</html>