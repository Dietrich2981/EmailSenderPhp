<?php
require_once ('class.fileio.php');
$file = $_GET['file'];
fileio::open($file);
echo fileio::$text;
?>
