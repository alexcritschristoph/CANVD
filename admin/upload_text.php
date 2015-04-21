<?php
$root_path = "../";
include_once($root_path . './common.php');
session_start();
if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin')
{
ini_set('display_errors','On');
ini_set('error_reporting',E_ALL);
//print_r($_FILES);
if ($_FILES["file"]["error"] > 0) {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
} else {

  move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/admin/upload/" . $_FILES["file"]["name"]);
  //print_r($_POST['action']);
  if ($_POST['action'] == "replace")
  {
  	exec("mysql -u root -p8582liap@cs2 -e \"use canvd;truncate table " . $_POST['table-name'] .  "\"; ");
  }
  	$query = "use canvd;LOAD DATA LOCAL INFILE '". "/var/www/admin/upload/" . $_FILES["file"]["name"] ."' INTO TABLE " . $_POST['table-name'] . " FIELDS TERMINATED BY '\\t' IGNORE 1 LINES";

    //replace PSSWD with actual password to work in production.
  	exec("mysql -u root -p8582liap@cs2 -e \"". $query . "\"; ");
}
header('Location: ./index.php?submit=' . $_POST['table-name']);
}
else{
	echo "Error:unauthorized.";
}
?>
