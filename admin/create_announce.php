<?php
$root_path = "../";
include_once($root_path . './common.php');
session_start();
if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin')
{
$title =  $_GET['title'];
$body =  $_GET['body'];
date_default_timezone_set('America/New_York');
$date = date("F j, Y, g:i a");
$query = 'INSERT INTO announcements (`date`,title,body) VALUES (:date,:title,:body);';

//Parametized SQL prevents SQL injection
$query_params = array(':title' => $title, ':body' => $body,':date' => $date);
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);
header( 'Location: ./index.php' ) ;
}
else{
	echo "Error: Unauthorized.";
}
?>