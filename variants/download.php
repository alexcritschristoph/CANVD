<?php
//perform initial stuff

echo "Tissue(s)\tProtein ID\tProtein Name\tVariants\tInteractions\tEffects\n";
//download variants
$tissues = $_GET['tissue'];
$_GET['tissue'] = explode(",", $tissues);
$_GET['type'] = json_decode($_GET['type']);
$_GET['source'] = json_decode($_GET['source']);
$_GET['download'] = "true";
include('./variant_load.php');

$File = 'variant-download.csv';
header("Content-Disposition: attachment; filename=\"" . basename($File) . "\"");
header("Content-Type: application/force-download");
header("Connection: close");

?>
