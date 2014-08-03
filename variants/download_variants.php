<?php

$variant_id = $_GET['variant_ids'];
$variant_ids = explode(",",$variant_id);

$newfile = "";
foreach ($variant_ids as $var)
{
	$prot = fopen("../protein/mt/" . $var . ".fasta", "r");
	while ($line = fgets($prot)) {
		$newfile = $newfile . $line;
	}
	fclose($prot);

}

echo $newfile;
?>