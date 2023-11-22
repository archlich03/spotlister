<?php
$output = nl2br(shell_exec("python3 scripts/readDB.py"));
echo $output;
?>
