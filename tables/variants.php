<?php
//returns all variants from entered user data
$root_path = "../";
include_once('../common.php');

//POST variable is starting position
$tissues = json_decode($_POST['start']);
$plist = '\'' . implode('\',\'', $tissues) . '\'';

$query = 'SELECT EnsPID, tumour_site FROM T_Mutations WHERE tumour_site IN(' . $plist . ') LIMIT 20;';
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);

while ($row = $stmt->fetch())
{
	?>
	<tr>
        <td><?php echo ucwords(str_replace("_"," ", $row[1]));;?></td>
        <td><?php echo $row[0];?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
	</tr>
	<?php
}
?>