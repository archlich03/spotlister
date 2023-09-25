<?php
// Your PHP code here
$output = nl2br(shell_exec("python3 scripts/readjson.py"));
echo $output;
?>
