<?php
    require_once 'functions.php';
    checkSession();

    session_destroy();
    redirectIndex();
?>
