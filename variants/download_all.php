<?php
$root_path = "../";
include_once('../common.php');

/*******************FORM QUERY **********************************
*****************************************************************/

//Lets set all of the values to their proper values OR wildcards

//Which tissues are specified?
	$start = 0;
 if(!isset($_GET['current_count'])){
 	$start = 0;
 }
 else {
 	$start = $_GET['current_count'];
 }

  //For use by the downlad.php file
 $end = '';
 if (isset($_GET['end']))
 {
  $end = $_GET['end'];
 }
 else{
  $end = '10';
 }

  //Lets set all of the values to their proper values OR wildcards
  $tissues = '';
  $protein_name = '';
  $source = '';
  $type = '';


  if (!isset($_GET['prot']) || $_GET['prot'] == ''){
    $protein_name = "%";
    $_GET['prot'] = '';
  }
  else{
    $protein_name = $_GET['prot'];

    $protein_name = str_replace(',', '$|^', $protein_name);
    $protein_name = "^" . $protein_name . "$";
  }


  if (isset($_GET['source']) && $_GET['source'] != ''){
  	$source = str_replace('["', '', $_GET['source']);
  	$source = str_replace('"]', '', $source);
    $source = str_replace('","', '|', $source);
  }
  else{
    if (isset($_GET['variant_search'])){
      $source = "";
    }
    else {
    $source = ".*";
    $_GET['source'] = '';
    }
  }

  if (isset($_GET['mut_type']) && $_GET['mut_type'] != ''){
  	$type = str_replace('["', '', $_GET['mut_type']);
  	$type = str_replace('"]', '', $type);
    $type = str_replace('","', '|', $type);
  }
  else{
    if (isset($_GET['variant_search'])){
      $type = "";
    }
    else{
      $type = ".*";
      $_GET['mut_type'] = '';
    }
  }
  //CREATE PENULTIMATE QUERIES
  if(isset($_GET['tissue']))
  {
  $tissues = $_GET['tissue'];
  function sanitize($s) {
    return htmlspecialchars($s);
    }
  $t = array_map('sanitize', $tissues);
  $tissues = "'" . $tissues . "'";
  $tissue_array = explode(',', $tissues);

  $plist = implode("','", $tissue_array);
  $query = "SELECT GeneName,Sequence FROM T_Ensembl LEFT JOIN T_Mutations on T_Ensembl.EnsPID=T_Mutations.EnsPID WHERE T_Mutations.Source RLIKE :source AND T_Mutations.`gene name` RLIKE :name AND T_Mutations.mut_description RLIKE :type AND T_Mutations.tumour_site IN (" . $plist . ") LIMIT 10000;";
  }
  else
  {
  $query = "SELECT GeneName,Sequence FROM T_Ensembl LEFT JOIN T_Mutations on T_Ensembl.EnsPID=T_Mutations.EnsPID WHERE  T_Mutations.Source RLIKE :source AND T_Mutations.`gene name` RLIKE :name AND T_Mutations.mut_description RLIKE :type LIMIT 10000;";
  }



/*******************RUN QUERY **********************************
*****************************************************************/


$query_params = array(":source" => $source, ":name" => $protein_name, ":type" => $type);
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);
$variant_proteins = array();
$newfile = "";
while ($row = $stmt->fetch())
{
	$newfile = $newfile . '>' . $row['GeneName'] . "\n";
	$newfile = $newfile . $row['Sequence'] . "\n";
}


/*******************GET SEQUENCES **********************************
*****************************************************************/


$File = 'variants.fasta';
header("Content-Disposition: attachment; filename=\"" . basename($File) . "\"");
header("Content-Type: application/force-download");
header("Connection: close");

echo $newfile;

?>
