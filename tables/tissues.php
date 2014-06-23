<?php
//Generates HTML for the proteins table
$root_path = "../";
include_once('../common.php');

//POST variable is starting position
$start = $_POST['start'];
//$end = (int) $start + 10;

//Get list of unique tissues in entire database
//Get # of mutations for each tissue
$query = "SELECT * FROM tissue_table_browser LIMIT " . strval($start) . ",10;";
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);
$tissues = array();

while ($row = $stmt->fetch())
{
	?>
	<tr>
        <td><?php echo ucwords(str_replace("_"," ", $row[1]));;?></td>
        <td><?php echo $row[2];?></td>
        <td><?php echo $row[3];	?></td>
        <td><?php echo "<a href='#'>Proteins</a> - <a href='#'>Downloads</a>"?></td>
	</tr>

	<?php
}


?>