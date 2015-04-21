<?php
/*
	Generates sitewide statistics for CANVD
*/

$root_path = "./";
include_once('./common.php');

//Count # of Domains
$query = 'SELECT COUNT(Domain)
			  FROM T_Domain;';
  	$query_params = array();
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	$domain_count = $stmt->fetch()[0];

//Count # of Proteins
$query = 'SELECT COUNT(EnsPID)
			  FROM T_Ensembl;';
  	$query_params = array();
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	$protein_count = $stmt->fetch()[0];

//Count # of Interactions
$query = 'SELECT COUNT(IID)
			  FROM T_Interaction;';
  	$query_params = array();
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	$interaction_count = $stmt->fetch()[0];

//Count # of Mutations
$query = 'SELECT COUNT(ID)
			  FROM T_Mutations;';
  	$query_params = array();
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	$mutation_count = $stmt->fetch()[0];

//Count # of Rewiring Effects
$query = 'SELECT COUNT(IID)
                          FROM T_Interaction_MT;';

	$query_params = array();
        $stmt = $dbh->prepare($query);
        $stmt->execute($query_params);

	$rewire_count = $stmt->fetch()[0];

//Count # of PWMs
$query = 'SELECT COUNT(PWM)
			  FROM T_PWM;';
  	$query_params = array();
	$stmt = $dbh->prepare($query);
	$stmt->execute($query_params);
	$pwm_count = $stmt->fetch()[0];	

?>
