<?php
//Generates HTML for the proteins table
$root_path = "../";
include_once('../common.php');

//POST variable is starting position
$start = $_POST['start'];
//$end = (int) $start + 10;

//Get list of unique tissues in entire database
//Get # of mutations for each tissue
$query = "SELECT PWM, Domain FROM T_PWM LIMIT " . strval($start) . ",10;";
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);
$tissues = array();
while ($row = $stmt->fetch())
{
	$query = "SELECT EnsPID,Type FROM T_Domain WHERE Domain LIKE :domain;";
	$query_params = array(":domain"=>substr($row[1], 0, -3) .  "%");
	$stmt2 = $dbh->prepare($query);
	$stmt2->execute($query_params);
	$result = $stmt2->fetch();
	$protein = $result[0];
	$type = $result[1];
	?>


	<tr>
        <td><?php echo $row[0];?></td>
        <td><?php echo $row[1];?></td>
        <td><a href="http://127.0.0.1/gsoc/network/?genename=<?php echo $protein;?>"><?php echo $protein;?></a></td>
        <td><?php echo $type;?></td>
        <td>-</td>
        <td>-</td>
	</tr>

	<?php
}


?>