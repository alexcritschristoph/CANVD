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
    <script src="<?php echo $root_path;?>bootstrap.js"></script>
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

    if(isset($_GET['tissues'])){
    $tissue = $_GET['tissues'];
    $tissues = explode(",",$tissue);
    //
    function sanitize($s) {
    return htmlspecialchars($s);
    }
    $t = array_map('sanitize', $tissues);
    $plist = '\'' . implode('\',\'', $t) . '\'';
    $query = 'SELECT EnsPID, mut_syntax_aa, tumour_site, MUTATION_ID, mut_description FROM T_Mutations WHERE EnsPID=:ens AND tumour_site IN(' . $plist . ') ;';
    }
    //get all variants
    else 
    {
      $query = 'SELECT EnsPID, mut_syntax_aa, tumour_site, MUTATION_ID, mut_description FROM T_Mutations WHERE EnsPID=:ens;';
    }
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
    $mut_syntaxes_to_ids = array();
    $interactions = array();
    foreach($variants as $var)
    {
      $query = 'SELECT Mut_Syntax, WT, MT, Eval, IID FROM T_Interaction_MT WHERE Int_EnsPID=:ens and Mut_Syntax = :aa;';
      $stmt = $dbh->prepare($query);
      $query_params = array(':ens'=> $var[0], ':aa' => $var[1]);
      $stmt->execute($query_params);
      while ($row = $stmt->fetch())
      {
        $effects[$row[0]][$row[4]] = $row[3];
        $mut_syntaxes_to_ids[$row[4]] = $row[0];
      }
    }


    //get all sh3 interacting domains
    $query = 'SELECT Domain_EnsPID, Interaction_EnsPID, IID FROM T_Interaction WHERE Interaction_EnsPID=:ens;';
    $stmt = $dbh->prepare($query);
    $query_params = array(':ens'=> $_GET['variant']);
    $stmt->execute($query_params);
    $domains = array();
    $domain_ids = array();
    while ($row = $stmt->fetch())
    {
      $query2 = 'SELECT GeneName FROM T_Domain WHERE EnsPID=:ens;';
      $stmt2 = $dbh->prepare($query2);
      $query_params2 = array(':ens'=> $row[0]);
      $stmt2->execute($query_params2);
      //Get Mut syntax of this ID
      if (isset($mut_syntaxes_to_ids[$row[2]])){
        $mut_syntax_d = $mut_syntaxes_to_ids[$row[2]];
        $domain_name = $stmt2->fetch()[0];
        if (isset($domains[$mut_syntax_d])){
          if (!in_array($domain_name, $domains[$mut_syntax_d])){
          $domains[$mut_syntax_d][$row[2]] = $domain_name;
          $domain_ids[$domain_name] = $row[0];          
          }
        }
        else {
          $domains[$mut_syntax_d][$row[2]] = $domain_name;
          $domain_ids[$domain_name] = $row[0];         
        }
      }
    }
    ?>

    <div class="container">
   <div class="row">

   <div class="col-md-12">
   <div class="navbar navbar-inverse">
  <div class="navbar-header">
    <a class="navbar-brand" href="#"><?php echo $name;?> (<?php echo $_GET['variant'] ?>)</a>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#"><?php echo $description;?></a></li>


      <li class="dropdown">
        <a href="#" class="dropdown-toggle filter-dropdown" data-toggle="dropdown">Filter Interaction <b class="caret"></b></a>

        <ul class="dropdown-menu" id="function-filter">
          <li><a href="#" data-func="all">Show All</a></li>
          <li><a href="#" data-func="gain">Gain of Function</a></li>
          <li><a href="#" data-func="loss">Loss of Function</a></li>
          <li><a href="#" data-func="neutral">Neutral Effect on Function</a></li>
        </ul>
      </li>
      <script>
      $(function(){
              $("#function-filter").on("click", "a", function(){

        if ($(this).data("func") == 'all'){
          var new_url = window.location.href.split('&int-filter')[0];
           window.location.href = new_url;
        }
        else{
        var new_url = window.location.href.split('&int-filter')[0] + "&int-filter=" + $(this).data("func");
        window.location.href = new_url;
        }
      });
      });
      </script>
    </ul>
    <ul class="nav navbar-nav navbar-right">

      <li class="dropdown">
        <a href="#" class="dropdown-toggle download-dropdown" data-toggle="dropdown">Download <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="../proteins/wt/<?php echo $_GET['variant'];?>.fasta">Download Wildtype Sequence</a></li>
          <li><a href="#" id="download_all">Download All Mutant Sequences</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
   </div>

    <div class="col-md-12">
    <table class="table table-striped table-hover" id="variant-details-table">
    <thead>
        <tr>
          <th>Mutation ID</th>
          <th>Variant Syntax</th>  
          <th>Mutation Type</th>      
          <th>Tissues</th>
          <th>Rewiring Effects - <span class="g">Gain of Function</span>, <span class="r">Loss of Function</span>.<br></th>
          <th>Download Sequence</th>        
        </tr>
      </thead>
    <tbody>
    <?php

    //If the int-filter option is set, restrict to that type only.
    $filter_option = "N/A";
    if (isset($_GET['int-filter']))
    {
      if ($_GET['int-filter'] == 'gain'){
        $filter_option = "gain of function";
      }
      elseif ($_GET['int-filter'] == "loss"){
        $filter_option = "loss of function";
      }
    }

    foreach($variants as $var)
    {
      $mut_id = $_GET['variant'] . '-' . strtoupper(explode(".",$var[1])[1]);

      //If an effect filter is set, check to see if it's in this row's effects to show it.
      if ((isset($_GET['int-filter']) && (isset($effects[$var[1]]) && in_array($filter_option,$effects[$var[1]]))) || (isset($_GET['int-filter']) && $_GET['int-filter'] == 'neutral' && !isset($effects[$var[1]])) || !isset($_GET['int-filter']))
      {
      ?>
      <tr>
      <td><?php echo $mut_id;?></td>
      <td><?php echo explode(".",$var[1])[1];?></td>
      <td><?php echo $var[4];?></td>
      <td><?php echo ucwords(str_replace("_"," ", $var[2]));?></td>
      <td>
      <?php
      if (isset($effects[$var[1]])){
      $i = 0;
      foreach($domains[$var[1]] as $k => $d){
        if ($effects[$var[1]][$k] == "gain of function" && ($filter_option == 'gain of function' || $filter_option == "N/A")){
          if ($i > 0){
          echo ", <a href='../network/?genename=" .  $domain_ids[$d] . "' class='g'>" . $d . "</a>";

          }
          else
          {
          echo "<a href='../network/?genename=" .  $domain_ids[$d] . "' class='g'>" . $d . "</a>";            
          }
        }
        elseif ($effects[$var[1]][$k] == "loss of function" && ($filter_option == 'loss of function' || $filter_option == "N/A")){
          if ($i > 0){          
          echo ", <a href='../network/?genename=" .  $domain_ids[$d] . "' class='r'>" . $d . "</a>";
          }
          else{
          echo "<a href='../network/?genename=" .  $domain_ids[$d] . "' class='r'>" . $d . "</a>";            
          }
        }
        $i += 1;
      }
      }
      else{
        echo "None";
      }
      ?>
      </td>
      <td><a href="../proteins/mt/<?php echo $mut_id?>.fasta">Download</a></td>
      </tr>
      <?php
    }
    }

    ?>
    </tbody>
    </table>
    <?php if(isset($_GET['tissues'])){
      ?>
      <p style="margin-top:20px;margin-bottom:60px;font-size:1.2em;text-align:center;"> <a id="showall" href="#" class="btn btn-default">Showing variants in specific tissue(s). Click here to view all variants for this protein.</a></p>
      <?php
    }
    ?>
    </div>
    <script>
      $( document ).ready(function() {

        $("#showall").on("click", function(){
          window.location.href = './details.php?variant=<?php echo $_GET['variant'];?>';
        });

      <?php
      $var_list = "";
      $i = 0;
      foreach($variants as $var)
    {
      if ($i > 0){
        $var_list = $var_list . "," . $_GET['variant'] . '-' . strtoupper(explode(".",$var[1])[1]);
      }
      else 
      {
      $var_list = $_GET['variant'] . '-' . strtoupper(explode(".",$var[1])[1]);
      }
      $i += 1;
    }
      echo "var variant_list = '" . $var_list . "';";
      ?>

      $("#download_all").on("click", function(){
        window.location.href = './download_variants.php?variant_ids=' + variant_list;
      });

      });
    </script>

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