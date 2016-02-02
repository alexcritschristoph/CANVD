<?php
/*
	Contains files common to all pages and php files, such as database connections and global variables / functions.
*/

ini_set('display_errors','On');
ini_set('error_reporting',E_ALL);


$settings = array(
					'db_host' 		=> 'localhost',
					'db_name' 		=> 'canvd',
					'db_user' 		=> 'INSERT_USERNAME',
					'db_password' 	=> 'INSERT_PASSWORD',
);

require($root_path . 'PDOext.class.php');
// Connect to our database
$dbh = new PDOext('mysql:host=' . $settings['db_host'] . ';dbname=' . $settings['db_name'], $settings['db_user'], $settings['db_password']);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);



?>
