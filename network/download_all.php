<?php
$root_path = "../";
include_once($root_path . './common.php');

$id_query = $_GET['protein-id'];

//Get all interactions
$query = 'SELECT IID,Domain_EnsPID,Interaction_EnsPID
			  FROM T_Interaction
			  WHERE Domain_EnsPID = :prot;';

$query_params = array(':prot' => $id_query);
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

$interactions = array();
while ($row = $stmt->fetch())
{
	$interactions[$row[0]] = array($row[1],$row[2]);
}


//Get all interaction info
$plist = '\'' . implode('\',\'', array_keys($interactions)) . '\'';
$query = 'SELECT *
			  FROM T_Interactions_Eval
			  WHERE IID IN(' . $plist . ');';
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);
while ($row = $stmt->fetch())
{
	$interactions[$row[0]] = array_merge($interactions[$row[0]], $row);
}


$File = 'network-data.txt';
header("Content-Disposition: attachment; filename=\"" . basename($File) . "\"");
header("Content-Type: application/force-download");
header("Connection: close");

echo "SH3 binding protein,Interacting proteins,Biological process,Disorder,Gene expression,Localization,Molecular function,Peptide conservation,Protein expression,Sequence signature,Surface accessibility,Average Interaction Score\n";
foreach($interactions as $i)
{
	echo $i[0] . "," . $i[1] . "," . $i['Biological_process'] . "," . $i['Disorder'] . "," . $i['Gene_expression'] . "," . $i['Localization'] . "," . $i['Molecular_function'] . "," . $i['Peptide_conservation'] . "," . $i['Protein_expression'] . "," . $i['Sequence_signature'] . "," . $i['Surface_accessibility'] . "," . $i['Avg'] . "\n";
}
//Output as file
?>