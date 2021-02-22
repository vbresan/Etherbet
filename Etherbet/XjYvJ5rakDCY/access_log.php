<?php

header("Content-Type: text/plain");

$homepage = file_get_contents('../../apache/logs/access.log');
echo $homepage;

?>
