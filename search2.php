<?php

//Select Domain EnsPID from the gene name entered
if(isset($_GET['genename']) && $_GET['genename'] != '') {
	$gene_name = $_GET['genename'];
}
else{
	echo "$('#cy').append('<h2> Please enter a valid domain name.</h2>'); });</script></body></html>";
	exit();
}

$all_data = array();

//Select Domain(s)
//If is domain name
$query = 'SELECT *
			  FROM T_Domain
			  WHERE Domain=:gene_name OR EnsPID=:gene_name2;';

//If is EnsPID

$gene = $_GET['genename'];
$query_params = array(':gene_name' => $gene, ':gene_name2' => $gene);
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

$domains = array();
$domain_names = array();
$domain_info = array();
while ($row = $stmt->fetch())
{
	$domains[] = $row["EnsPID"];
	$domain_names[$row['EnsPID']] = $row['GeneName'];

	//get T_Ensembl description
	$query2 = 'SELECT Description
				FROM T_Ensembl
				WHERE EnsPID=:ens_pid;';
	$query_params2 = array(':ens_pid' => $row["EnsPID"]);
	$stmt2 = $dbh->prepare($query2);
	$stmt2->execute($query_params2);
	while ($row2 = $stmt2->fetch())
	{
		$desc = $row2['Description'];
	}
	$domain_info[] = ["EnsPID" => $row["EnsPID"],"DomainName" => $row['GeneName'],"Type" => $row["Type"], "Description" => $desc];
}

//For each domain, get interaction data
$i = 0;
foreach ($domains as $domain) {

	//get pwm

	$query = 'SELECT PWM
				FROM T_PWM
				WHERE Domain=:ens_pid;';
	$query_params = array(':ens_pid' => $domain_names[$domain]);
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	while ($row = $stmt->fetch())
	{
		$pwm = $row['PWM'];
	}

	//now get interaction data
	$query = 'SELECT *
				FROM T_Interaction
				WHERE Domain_EnsPID=:ens_pid;';
	$query_params = array(':ens_pid' => $domain);
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);

	$interactions = array();
	$interaction_raw_data = array();
	$interaction_scores = array();
	$iid_to_enspid = array();
	$partners = array();
	$mut_interaction_types = array();
	while ($row = $stmt->fetch())
	{
		$interactions[] = $row['IID'];
		$partners[] = $row['Interaction_EnsPID'];
		$iid_to_enspid[$row['IID']] = $row['Interaction_EnsPID'];
		$mut_interaction_types[$row['Interaction_EnsPID']] = [];
		$interaction_raw_data[] = ['domain' => $row['Domain_EnsPID'], 'interaction' => $row['Interaction_EnsPID'], 'start' => $row['Start'], 'end' => $row['End'], 'score'=> $row['Score']];
		$interaction_scores[$row['Interaction_EnsPID']] = $row['Score'];
	}

	//Get all T_Interaction_Eval data for all interactions
	$plist = '\'' . implode('\',\'', $interactions) . '\'';
	$query = 'SELECT * FROM T_Interactions_Eval WHERE IID IN(' . $plist . ')';
	$query_params = array();
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);

	$interaction_eval = [];
	while ($row = $stmt->fetch())
	{
		$interaction_eval[$iid_to_enspid[$row['IID']]] = $row;
	}

	//Get all Interaction_MT for all Interactions
	$plist = '\'' . implode('\',\'', $interactions) . '\'';

	$query = 'SELECT *
				  FROM T_Interaction_MT
				  WHERE IID IN(' . $plist . ');';
	$query_params = array();
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);

	$mut_interactions = array();
	$mut_impacts = array();
	while ($row = $stmt->fetch())
	{
		$mut_interactions[$row['Int_EnsPID']][] = [$row['WT'],$row['MT'], $row['WTscore'], $row['MTscore'], $row['Mut_Syntax'], $row['LOG2'], $row['Eval'], $row['DeltaScore']];
		$mut_interaction_types[$row['Int_EnsPID']][] = $row['Eval'];
		$mut_impacts[$row['Int_EnsPID']][$row['Mut_Syntax']] = $row['Eval'];
	}

	//Assign each interaction as "loss, "gain", "neutral", or "both"
	$mut_interaction_labels = array();
	foreach ($mut_interaction_types as $key => $value) {
		if (in_array('loss of function', $value) && in_array('gain of function', $value))
		{
			$mut_interaction_labels[$key] = 'both';
		}
		elseif (in_array('loss of function', $value)) {
			$mut_interaction_labels[$key] = 'loss';
		}
		elseif (in_array('gain of function', $value)) {
			$mut_interaction_labels[$key] = 'gain';
		}
		else {
			$mut_interaction_labels[$key] = 'neutral';
		}
	}

	//Get all mutations, mark those w/ impact. save tissue types and AA syntax.
	$plist = '\'' . implode('\',\'', $partners) . '\'';
	if (isset($_GET['main_search'])){
		if (isset($_GET['source'])){
		    $source = implode("|", $_GET['source']);
		}
		else {
			$source = "";
		}
	  }
	else{
	$source = ".*";
	$_GET['source'] = '';
	}


	if (isset($_GET['main_search'])){
		if (isset($_GET['mut_type'])){
	    $type = implode("|", $_GET['mut_type']);
		}
		else{
			$type = "";
		}
	  }
	else{
	    $type = ".*";
	    $_GET['mut_type'] = '';
	}


	$query = 'SELECT *
				  FROM T_Mutations
				  WHERE Source RLIKE :source AND mut_description RLIKE :type AND EnsPID IN(' . $plist . ');';
	$query_params = array(':source' => $source, ':type' => $type);
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	$mutation_information = array();
	while ($row = $stmt->fetch())
	{
		//Does it have an impact?
		//if this EnsPID has entry in mut impacts
		if (array_key_exists($row['EnsPID'], $mut_impacts))
		{
			if (array_key_exists($row['mut_syntax_aa'], $mut_impacts[$row['EnsPID']]))
			{
				if ($mut_impacts[$row['EnsPID']][$row['mut_syntax_aa']] == "loss of function")
				{
					$impact = -1;
				}
				else
				{
					$impact = 1;
				}
			}
			else {
				$impact = 0;
			}
		}
		else{
			$impact = 0;
		}

		// add mutation info to array
		$mutation_information[] = ['Syntax' => $row['mut_syntax_aa'], 'Tissue' => $row['tumour_site'], 'Source' => $row['Source'], 'EnsPID' => $row['EnsPID'], 'Impact' => $impact];
	}

	//Get all interaction partner names
	$gene_info = array();
	$plist = '\'' . implode('\',\'', $partners) . '\'';
	$query = 'SELECT GeneName, Description, EnsPID
				  FROM T_Ensembl
				  WHERE EnsPID IN(' . $plist . ');';
	$query_params = array();
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);

	while ($row = $stmt->fetch())
	{
		$gene_info[$row['EnsPID']] = ['GeneName' => $row['GeneName'], 'Description' => $row['Description'],'EnsPID' => $row['EnsPID']];
	}

	//our info
	$all_data[$domain] = ["domain_info" => $domain_info[$i], "gene_info" => $gene_info, "mut_int" => $mut_interaction_labels, "muts" => $mutation_information, "mut_effects" => $mut_interactions, "raw_interactions" => $interaction_raw_data, "interaction_scores" => $interaction_scores, "interaction_eval" => $interaction_eval, "pwm" => $pwm, "int_start" => 0, "int_limit" => 100];

	$i = $i + 1;
}

?>
var networkData = <?php echo json_encode($all_data);?>;
