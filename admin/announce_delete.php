<?php

//show or show in home?
$root_path = "../";
include_once($root_path . './common.php');
session_start();
if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin')
{
//Value 
$a_id = (int) $_POST['a_id'];
$query = 'DELETE FROM announcements WHERE id=' .$a_id.';';

//Parametized SQL prevents SQL injection
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);
//Query

//Return
echo "Success";
}
else{
	echo "Error: unauthorized."
}
?>