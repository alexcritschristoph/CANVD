<?php
/*
	Runs searches for gene / protein interactions.
*/
$root_path = "../";
include_once($root_path . './common.php');

//Select Domain EnsPID from the gene name entered
if(isset($_GET['genename'])) {
	$gene_name = $_GET['genename'];

}
else{
	exit();
}


$query = 'SELECT EnsPID
			  FROM T_Ensembl
			  WHERE GeneName = :gene_name;';

//Parametized SQL prevents SQL injection
$query_params = array(':gene_name' => $gene_name);
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

$ens_ids = array();
while ($row = $stmt->fetch())
{
	$ens_ids[] = $row[0];
	//echo $row[0] . ' ';

}

//echo $ens_id . '<br><br>';

//Select all interactions with that Domain PID
$plist = '\'' . implode('\',\'', $ens_ids) . '\'';
$query = 'SELECT Interaction_EnsPID
			  FROM T_Interaction
			  WHERE Domain_EnsPID IN(' . $plist . ')';

//Parametized SQL prevents SQL injection
$query_params = array(':ens' => $plist);
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

//Get all interaction partners
$interaction_partners = array();
while ($row = $stmt->fetch())
{
	$interaction_partners[] = $row[0];
}

$plist = '\'' . implode('\',\'', $interaction_partners) . '\'';
//Find all mutations of all interaction partners and (if possible) Gene names
$query = 'SELECT EnsPID, mut_nt, mut_aa, tumour_site
			  FROM T_Mutations
			  WHERE EnsPID IN(' . $plist . ')';
//echo $query;
//echo $query;
//Parametized SQL prevents SQL injection
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

//Organize results
$results = array();
//echo "<br>******************<br>";
$mut_counter = 0;
$tumors = array();
$proteins = array();
while ($row = $stmt->fetch())
{
	$proteins[$row['EnsPID']] = 1;
	$tumors[$row[3]] = 1; 
	$results[$row['EnsPID']][$row[0]][] = array($row[1], $row[2], $row[3]);
	$mut_counter += 1;
	// . ',' . $row[1] . ',' . $row[2] . ',' . $row[3] . ',' . $row[4] . ',' . '<br>';
}
?>
var tumor_count = "<?php echo count(array_keys($tumors)); ?>";
var protein_count = "<?php echo count(array_keys($proteins)) + 1; ?>";
var mutation_count = "<?php echo $mut_counter; ?>";
var target_protein = "<?php echo $gene_name ?>";
var networkData = <?php echo json_encode($results);?>
