<?php
$output = nl2br(shell_exec("python3 scripts/readjson.py"));
echo $output;
?>
