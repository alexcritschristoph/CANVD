<?php
  $root_path = "../";
  include_once('../common.php');
?>

<html>
	<head>
		<title>
			Cancer Variant Database
		</title>
		<link href="<?php echo $root_path;?>bootstrap.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
    <script src="<?php echo $root_path;?>site.js" ></script>
		<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $root_path;?>styles.css">
	</head>

	<body style="background:#fafafa;">
	<div class="jumbotron" style="margin-bottom:0px;height:100%">
    <div class="container" style="margin-bottom:15px;">
    <p class="pull-right" style="margin-left:10px;margin-top:25px;"><a class="btn btn-danger" id="test" href="<?php echo $root_path;?>variants" role="button"><i class="fa fa-flask"></i> Variants </a>
      <a class="btn btn-default" href="<?php echo $root_path;?>faqs" role="button"><i class="fa fa-question"></i> About</a>
      <a class="btn btn-default" href="<?php echo $root_path;?>contact" role="button"><i class="fa fa-envelope-o"></i> Contact</a>
      </p>
      <h1><a href="<?php echo $root_path;?>"><span style="color:#ea2f10">Can-VD</span>: The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase</a></h1>

      <p id="main-top-text">The effects of over 800,000 missense mutations are analyzed and stored in the <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase (<span style="color:#ea2f10">Can-VD</span>).</p>

    </div>  
	<div class="container">
	 <div class="row">
   <?php
     /* Is this the search page, or the results page, or the details page? */
   if(isset($_GET['variant']))
   {
    //get protein name
    $query = 'SELECT GeneName, Description FROM T_Ensembl WHERE EnsPID=:ens;';
    $stmt = $dbh->prepare($query);
    $query_params = array(':ens'=> $_GET['variant']);
    $stmt->execute($query_params);
    $name = '';
    $description = '';
    while ($row = $stmt->fetch())
    {
      $name = $row[0];
      $description = $row[1];
    }
    //get all variants
    $query = 'SELECT EnsPID, mut_syntax_aa, tumour_site FROM T_Mutations WHERE EnsPID=:ens;';
    $stmt = $dbh->prepare($query);
    $query_params = array(':ens'=> $_GET['variant']);
    $stmt->execute($query_params);
    $variants = array();
    while ($row = $stmt->fetch())
    {
      $variants[] = $row;
    }

    //get all effects
    $effects = array();
    $interactions = array();
    foreach($variants as $var)
    {
      $query = 'SELECT Mut_Syntax, WT, MT, Eval, IID FROM T_Interaction_MT WHERE Int_EnsPID=:ens and Mut_Syntax = :aa;';
      $stmt = $dbh->prepare($query);
      $query_params = array(':ens'=> $var[0], ':aa' => $var[1]);
      $stmt->execute($query_params);
      while ($row = $stmt->fetch())
      {
        $effects[$row[0]] = $row;
      }
    }

    //get all sh3 interacting domains
    $query = 'SELECT Domain_EnsPID, Interaction_EnsPID, IID FROM T_Interaction WHERE Interaction_EnsPID=:ens;';
    $stmt = $dbh->prepare($query);
    $query_params = array(':ens'=> $_GET['variant']);
    $stmt->execute($query_params);
    $domains = array();
    while ($row = $stmt->fetch())
    {
      $query2 = 'SELECT GeneName FROM T_Domain WHERE EnsPID=:ens;';
      $stmt2 = $dbh->prepare($query2);
      $query_params2 = array(':ens'=> $row[0]);
      $stmt2->execute($query_params2);
      $domains[$row[2]] = array($row[0],$stmt2->fetch()[0]);
    }

    ?>

    <p> Variant Details for <?php echo $_GET['variant'] ?> (<?php echo $name;?>)</p>
    <p  style="margin-bottom:30px;font-size:0.9em;margin-left:30px;"><?php echo $description;?></p>
    <div class="col-md-8">
    <table class="table table-striped table-hover">
    <thead>
        <tr>
          <th>Variant Syntax</th>        
          <th>Tissues</th>
          <th>Effect</th>
          <th>SH3 Interacting Domain</th>
          <th>Interaction Network</th>        
        </tr>
      </thead>
    <tbody>
    <?php
    foreach($variants as $var)
    {
      ?>
      <tr>
      <td><?php echo $var[1];?></td>
      <td><?php echo ucwords(str_replace("_"," ", $var[2]));?></td>
      <td><?php if (isset($effects[$var[1]][3])) {echo $effects[$var[1]][3]; } else { echo "None";}?></td>
      <td><?php if (isset($effects[$var[1]][3])) {echo $domains[$effects[$var[1]][4]][1]; } else  { echo "None";}?></td>
      <td><?php if (isset($effects[$var[1]][3])) {?><a href="../network/?genename=<?php echo $domains[$effects[$var[1]][4]][0];?>">Network Link</a><?php }?></td>
      </tr>
      <?php
    }

    ?>
    </tbody>
    </table>
    </div>
    <?php
  }
   else
   {

   ?>
     Error:protein not found.
  <?php
    }
      include $root_path. 'footer.php';
    ?>
   </div>

	</div>

	</div>

	</body>

</html>