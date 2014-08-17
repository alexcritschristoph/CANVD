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

$counter = 0;
$diff_genes = array();
$tumor_json = array();
$protein_json = array();
$names_json = array();
$mutation_json = array();
$target_json = array();
$target_id_json = array();
$edges_json = array();
$pwms_json = array();
$networkData_json = array();
$total_count_json = array();
$gene_names = explode(",", $gene_name);
foreach ($gene_names as $gene)
{
$gene = trim($gene);
/* 
	SEARCH ALGORITHM
	WHAT IS THE USER SEARCHING FOR?
*/
$true_name = '';
$target_id = '';
$found = False;
//Is this word a gene name?
//Is this word a EnsID?
//Does this word match a description?
//If not, word is unidentified
$counter += 1;

//Is it a gene name?
$query = 'SELECT EnsPID
			  FROM T_Domain
			  WHERE Domain LIKE :gene_name;';

//Parametized SQL prevents SQL injection
$query_params = array(':gene_name' => $gene . '%');
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

$ens_ids = array();
while ($row = $stmt->fetch())
{
	$ens_ids[] = $row[0];
}

if (count($ens_ids) > 0){
	$found = True;
	$true_name = $gene;
}

//Not a gene name, check EnsID
if (!$found){
	$query = 'SELECT EnsPID
				  FROM T_Ensembl
				  WHERE EnsPID = :enspid;';
	$query_params = array(':enspid' => $gene);
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);

	$ens_ids = array();
	while ($row = $stmt->fetch())
	{
		$ens_ids[] = $row[0];
	}

if (count($ens_ids) > 0){
	$found = True;

	//Get gene name of this EnsPID
	$query = 'SELECT GeneName
				  FROM T_Ensembl
				  WHERE EnsPID = :enspid;';
	$query_params = array(':enspid' => $gene);
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);

	$true_name = $stmt->fetch()[0];
}
}

//Not a gene name or EnsID, check description
if (!$found){
	$query = 'SELECT EnsPID
				  FROM T_Ensembl
				  WHERE Description LIKE :description;';
	$query_params = array(':description' => $gene . '%');
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);

	$ens_ids = array();
	while ($row = $stmt->fetch())
	{
		$ens_ids[] = $row[0];
	}

if (count($ens_ids) > 0){
	$found = True;
	//Get gene name of this description
	$query = 'SELECT GeneName
			  FROM T_Ensembl
			  WHERE Description LIKE :description;';
	$query_params = array(':description' => $gene . '%');
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	$true_name = $stmt->fetch()[0];
}
}

//If not found at this point, it is ignored

if ($found){


$diff_genes[] = $true_name;

/*
	END SEARCHING ALGORITHM

*/
//echo $ens_id . '<br><br>';

//Select all interactions with that Domain PID
$plist = '\'' . implode('\',\'', $ens_ids) . '\'';

$target_id_json[] = implode(",",$ens_ids);
//Get total count
$query = 'SELECT COUNT(DISTINCT Interaction_EnsPID)
			  FROM T_Interaction
			  WHERE Domain_EnsPID IN(' . $plist . ');';
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);
$total_count_json[] = $stmt->fetch()[0];


$query = 'SELECT Interaction_EnsPID, IID, PWM
			  FROM T_Interaction
			  WHERE Domain_EnsPID IN(' . $plist . ') LIMIT :user_limit;';

//Parametized SQL prevents SQL injection
if (isset($_GET['limit']))
{
	$query_params = array(':user_limit' => $_GET['limit']);
}
else
{
	$query_params = array(':user_limit' => 100);
}
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

//Get all interaction partners
$interaction_partners = array();
$interaction_ids = array();
$interaction_association = array();
$pwms = array();

while ($row = $stmt->fetch())
{
	$interaction_partners[] = $row[0];
	$interaction_ids[] = $row[1];
	$interaction_association[$row[1]] = $row[0];
	$pwms[$row[0]] = $row[2];
	$pwms['quickpwm'] = $row[2];
}
//Find all gene names of the interaction partners
//Organize results
$results = array();
$proteins = array();

$plist = '\'' . implode('\',\'', $interaction_partners) . '\'';
$query = 'SELECT GeneName, EnsPID, Description FROM T_Ensembl WHERE EnsPID IN(' . $plist . ')';
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

$interaction_names = [];
while ($row = $stmt->fetch())
{
	$interaction_names[$row[1]] = array($row[0], $row[2]);
	$proteins[$row['EnsPID']] = 1;
	$results[$row['EnsPID']][$row[1]] = [];
}

/*echo count($interaction_partners);
echo "**";
echo count($interaction_names);
*///Get all interaction edge values
$plist2 = '\'' . implode('\',\'', $interaction_ids) . '\'';
$query = 'SELECT * FROM T_Interactions_Eval WHERE IID IN(' . $plist2 . ')';
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

$interaction_edges = [];
while ($row = $stmt->fetch())
{
	$interaction_edges[$row[0]] = $row;
	$interaction_edges[$row[0]]['protein_id'] = $interaction_association[$row['IID']];
}

//Get interaction type (gain / loss)
$query = 'SELECT IID, Eval, Mut_Syntax, WT, MT, WTscore, MTscore FROM T_Interaction_MT WHERE IID IN(' . $plist2 . ')';
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

while ($row = $stmt->fetch())
{
	$interaction_edges[$row[0]]['Type'] = $row[1];
	$interaction_edges[$row[0]]['Syntax'] = $row[2];
	$interaction_edges[$row[0]]['WT'] = $row[3];
	$interaction_edges[$row[0]]['MT'] = $row[4];
	$interaction_edges[$row[0]]['WTscore'] = $row[5];
	$interaction_edges[$row[0]]['MTscore'] = $row[6];
}


$interaction_edges = array_values($interaction_edges);
//Find all mutations of all interaction partners
$query = 'SELECT EnsPID, mut_nt, mut_aa, tumour_site, mut_syntax_aa
			  FROM T_Mutations
			  WHERE EnsPID IN(' . $plist . ')';
//echo $query;
//echo $query;
//Parametized SQL prevents SQL injection
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

//echo "<br>******************<br>";
$mut_counter = 0;
$tumors = array();
$existing_syntaxes = array();
while ($row = $stmt->fetch())
{
	$tumors[$row[3]] = 1;
	//find if any of these cause gain / loss
	$mut_type = 0;
	foreach ($interaction_edges as $int_edge)
	{
		if (array_key_exists('Syntax', $int_edge))
		{
			if ($int_edge['protein_id'] == $row[0] && $int_edge['Syntax'] == $row[4])
			{
				$mut_type = 1;
			}			
		}

	}
	$results[$row['EnsPID']][$row[0]][] = array($row[1], $row[2], $row[3], $row[4], $mut_type);
	
	if (!in_array($row[4], $existing_syntaxes))
	{
		$mut_counter += 1;
	}
	$existing_syntaxes[] = $row[4];
	//echo "console.log(" . var_dump($existing_syntaxes) . ");";
	// . ',' . $row[1] . ',' . $row[2] . ',' . $row[3] . ',' . $row[4] . ',' . '<br>';
}


	//Advanced Search narrows the options by removing some from the results.
	foreach ($results as $k => $r){
		foreach ($r as $t){
			foreach ($t as $s){
				if (in_array(1, $s)){
					//unset($results[$k]);
				}
			}
		}
	}

$tumor_json[] = count(array_keys($tumors));
$protein_json[] = count(array_keys($proteins)) + 1;
$mutation_json[] = $mut_counter;
$target_json[] = $true_name;
$networkData_json[] = $results;
$names_json[] = $interaction_names;
$edges_json[] = $interaction_edges;
$pwms_json[] = $pwms;
}
}
?>

var total_count = <?php echo json_encode($total_count_json);?>;
var interaction_pwms = <?php echo json_encode($pwms_json);?>;
var interaction_names = <?php echo json_encode($names_json);?>;
var interaction_edges = <?php echo json_encode($edges_json);?>;
var tumor_count = <?php echo json_encode($tumor_json); ?>;
var protein_count = <?php echo json_encode($protein_json); ?>;
var mutation_count = <?php echo json_encode($mutation_json); ?>;
var target_protein = <?php echo json_encode($target_json); ?>;
var target_id_json = <?php echo json_encode($target_id_json); ?>;
var networkData1 = <?php echo json_encode($networkData_json);?>;
var all_proteins = <?php echo json_encode($diff_genes);?>;

console.log(tumor_count);