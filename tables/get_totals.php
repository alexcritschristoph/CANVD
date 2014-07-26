<?php
//Counts totals

$root_path = "../";
include_once('../common.php');

$counts = array();

$query = "SELECT COUNT(*) FROM tissue_table_browser;";
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params); 
$counts[] = $stmt->fetch()[0];

$query = "SELECT COUNT(PWM) FROM T_PWM ;";
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params); 
$counts[] = $stmt->fetch()[0];

$query = "SELECT COUNT(GeneName) FROM T_Domain;";
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params); 
$counts[] = $stmt->fetch()[0];


print json_encode($counts);
?>