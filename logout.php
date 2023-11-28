<?php
    require 'functions.php';
    checkSession();

    session_destroy();
    redirectIndex();
?>