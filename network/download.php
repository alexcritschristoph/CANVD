<?php
session_start();


$File = 'network-data.txt';
header("Content-Disposition: attachment; filename=\"" . basename($File) . "\"");
header("Content-Type: application/force-download");
header("Connection: close");
echo $_SESSION['download_data'];
unset($_SESSION['download_data']);
?>