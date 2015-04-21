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
$i = 1;
while ($row = $stmt->fetch())
{
	$query = "SELECT EnsPID,Type,GeneName,ProteinLength,DomainSequence,OtherEnsemblProteins FROM T_Domain WHERE Domain LIKE :domain;";
	$query_params = array(":domain"=>substr($row[1], 0, -3) .  "%");
	$stmt2 = $dbh->prepare($query);
	$stmt2->execute($query_params);
	$result = $stmt2->fetch();
	$protein = $result[0];
	$type = $result[1];

	$other_prots = "";
	foreach(explode("|", $result[5]) as $r){
	$other_prots = $other_prots . "<a href='http://ensembl.org/id/" . $r . "'>" . $r . "</a>, ";
	}
	$content = "<p style='font-size:0.8em;margin-top:10px;'><b>PWM: " . $row[0] . "</b><br><b>Domain: " . $row[1] . "</b></p><p style='font-size:0.6em;margin-left:20px;'>Gene Name: " . $result[2] . "<br>Additional Proteins: " . $other_prots. "<br><br>Domain Sequence:<div style='font-size:0.6em;max-width:400px;word-wrap: break-word;margin-left:100px;'>" . $result[4] . "</div></p>";

	if ($i % 2 == 1){
	?>
	<tr>
        <td>
	<div><b>PWM:</b> <?php echo $row[0];?></div>
	<div><b>Domain/Pattern:</b> <?php echo $row[1];?></div>
	<div><b>Protein:</b> <a href="./network/?genename=<?php echo $protein;?>"><?php echo $protein;?></a></b></div>
	<div><b>Type:</b> <?php echo $type;?></div>
	<div><b>Files:</b> <a download="<?php echo $row[0]?>.mimp" href="./pwms/mimp/<?php echo $row[0]?>.mimp">MIMP</a>, <a download="<?php echo $row[0]?>.enologo" href="./pwms/enologo/<?php echo $row[0]?>.enologo">Enologo</a>, <a download="<?php echo $row[0]?>.musi" href="./pwms/musi/<?php echo $row[0]?>.musi">Musi</a></div>
	</td>
        <td><img src="./pwms/logos/<?php echo $row[0]?>.png" height="100px" class="pwm-img" data-content="<?php echo $content;?>"></td>
	<?php
	}
	elseif ($i % 2 == 0) {
        ?>
	<td>
        <div><b>PWM:</b> <?php echo $row[0];?></div>
        <div><b>Domain/Pattern:</b> <?php echo $row[1];?></div>
        <div><b>Protein:</b> <a href="./network/?genename=<?php echo $protein;?>"><?php echo $protein;?></a></b></div>
        <div><b>Type:</b> <?php echo $type;?></div>
        <div><b>Files:</b> <a download="<?php echo $row[0]?>.mimp" href="./pwms/mimp/<?php echo $row[0]?>.mimp">MIMP</a>, <a download="<?php echo $row[0]?>.enologo" href="./pwms/enologo/<?php echo $row[0]?>.enologo">Enologo</a>, <a download="<?php echo  $row[0]?>.musi" href="./pwms/musi/<?php echo $row[0]?>.musi">Musi</a></div>
        </td>
        <td><img src="./pwms/logos/<?php echo $row[0]?>.png" height="100px" class="pwm-img" data-content="<?php echo $content;?>">
	</tr>
	<?php
	}
	$i += 1;
}


?>
