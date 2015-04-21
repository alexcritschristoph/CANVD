<?php
//Generates HTML for the proteins table
$root_path = "../";
include_once('../common.php');

//echo "STARTING<br>";

//if ($_GET["pass"] == 'changecanvd7')
//{

$query1 ="DELETE FROM canvd.tissue_table_browser;";
$query_params1 = array();
$stmt1 = $dbh->prepare($query1);
$stmt1->execute($query_params1);

$query = "SELECT DISTINCT tumour_site FROM T_Mutations;";

$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);
$tissues = array();
while ($row = $stmt->fetch())
{
	$tissue = $row[0];
	//echo $row[0] . "<br>";
	$query = "SELECT COUNT(ID) FROM T_Mutations use index (ID) WHERE tumour_site=:tissue;";
	$query_params = array(":tissue" => $tissue);
	$stmt2 = $dbh->prepare($query);
	$stmt2->execute($query_params);
	$mutation_count = $stmt2->fetch()[0];

	$query = "SELECT COUNT(Distinct EnsPID) FROM T_Mutations use index (ID) WHERE tumour_site=:tissue;";
	$query_params = array(":tissue" => $tissue);
	$stmt2 = $dbh->prepare($query);
	$stmt2->execute($query_params);
	$protein_count = $stmt2->fetch()[0];

	//$query = "SELECT Distinct ID FROM T_Mutations WHERE tumour_site=:tissue;";
	$query = "SELECT Distinct EnsPID FROM T_Mutations WHERE tumour_site=:tissue;";
	$query_params = array(":tissue" => $tissue);
	$stmt2 = $dbh->prepare($query);
	$stmt2->execute($query_params);
	$ids = array();
	while ($row = $stmt2->fetch())
	{
		$ids[] = $row[0];
		//echo $row[0];
	}

	//count interactions
	$plist = '\'' . implode('\',\'', $ids) . '\'';
	//$query = "SELECT COUNT(*) FROM T_Interaction_MT WHERE IID IN(" . $plist . ") AND Eval='loss of function';";
	$query = "SELECT COUNT(*) FROM T_Interaction_MT WHERE Int_EnsPID IN(" . $plist . ") AND Eval='loss of function';";
	$query_params = array();
	$stmt2 = $dbh->prepare($query);
	$stmt2->execute($query_params);
	$loss_num = $stmt2->fetch()[0];

	//$query = "SELECT COUNT(*) FROM T_Interaction_MT WHERE IID IN(" . $plist . ") AND Eval='gain of function';";
	$query = "SELECT COUNT(*) FROM T_Interaction_MT WHERE Int_EnsPID IN(" . $plist . ") AND Eval='gain of function';";
	$query_params = array();
	$stmt2 = $dbh->prepare($query);
	$stmt2->execute($query_params);
	$gain_num = $stmt2->fetch()[0];

	$query = "INSERT INTO  `tissue_table_browser` (`Tissue` ,`variants` ,`proteins`, `gain`, `loss`) VALUES (:tissue,  :muts,  :prots, :gain, :loss);";
	$query_params = array(":tissue" => $tissue, ":muts" => $mutation_count, ":prots" => $protein_count, ':gain' => $gain_num, ':loss' => $loss_num);
	$stmt2 = $dbh->prepare($query);
	$stmt2->execute($query_params);

}

//}

//else{
//	echo "Unauthorized.";
//}
header("Location: index.php?submit=true");
exit;
?>