<?php
//Generates HTML for the proteins table
$root_path = "../";
include_once('../common.php');

//POST variable is starting position
//$start = $_POST['start'];
//$end = (int) $start + 10;

//Get list of unique tissues in entire database
//Get # of mutations for each tissue
$query = "SELECT DISTINCT tumour_site FROM T_Mutations LIMIT 0,10;";
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);
$tissues = array();
while ($row = $stmt->fetch())
{
	$tissues[] = $row[0];
	echo $row[0];
}

//Get # of gain and loss and total proteins

foreach ($tissues as $tissue)
{
	//get all mutations
	$query = "SELECT ID FROM T_Mutations WHERE tumour_site=:tissue;";
	$query_params = array(":tissue" => $tissue);
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	$ids = array();
	while ($row = $stmt->fetch())
	{
		$ids[] = $row[0];
		//echo $row[0];
	}
	//count interactions
/*	$plist = '\'' . implode('\',\'', $ids) . '\'';
	$query = "SELECT COUNT(*) FROM T_Interaction_MT WHERE IID IN(" . $plist . ") AND Eval='loss of function';";
	$query_params = array();
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	$loss_num = $stmt->fetch()[0];*/

/*	$query = "SELECT COUNT(*) FROM T_Interaction_MT WHERE IID IN(" . $plist . ") AND Eval='gain of function';";
	$query_params = array();
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	$gain_num = $stmt->fetch()[0];

	//count proteins
	$query = "SELECT Count(DISTINCT EnsPID) FROM T_Mutations WHERE tumour_site=:tissue;";
	$query_params = array(":tissue" => $tissue);
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	$tissues = array();
	$prot_num = $stmt->fetch()[0];
	//Display results
	?>
	<tr>
        <td><?php echo $tissue;?></td>
        <td><?php echo count($ids);?></td>
        <td><?php echo $gain_num;?></td>
        <td><?php echo $loss_num;?></td>
        <td><?php echo $prot_num;?></td>
        <td><a href="./network/?genename=<?php echo $tissue[0]; ?>">Network</a></td>
	</tr>

	<?php*/
}


?>