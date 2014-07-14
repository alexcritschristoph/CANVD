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
   if(isset($_GET['search']))
   {
    ?>
    <div class="col-md-11">
  <table class="table table-striped table-hover" id="variant-table">
      <thead>
        <tr>
          <th>Tissue</th>        
          <th>Protein ID</th>
          <th>Protein Name</th>
          <th>Applicable Variants</th>
          <th>Interactions</th>
          <th>Effect(s)</th>
        </tr>
      </thead>
      <tbody id="variants-results">
  <?php

    //Which tissues are specified?
    if(isset($_GET['tissue'])){
    $tissues = $_GET['tissue'];
    $plist = '\'' . implode('\',\'', $tissues) . '\'';
    }            
    
    //First look for proteins in T_Mutations with correct tumor site, source, and protein name.
    $query = '';
    $protein = '';
    $source = '';
    if ($_GET['prot'] == ''){
      unset($_GET['prot']); 
    }
    $query_params = array();
    if(isset($_GET['prot']) && isset($_GET['tissue']) && isset($_GET['source']))
    {
      $protein = (string)$_GET['prot'];
      $source = $_GET['source'];
      $query_params = array(':source' => $source . "%", ':prot' => $protein);
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE source LIKE :source and `gene name` LIKE :prot and tumour_site IN(' . $plist . ') LIMIT 20;';
    }
    else if (isset($_GET['prot']) && isset($_GET['tissue']))
    {
      $protein = $_GET['prot'];
      $query_params = array(':prot' => $protein);
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE `gene name` LIKE :prot and tumour_site IN(' . $plist . ') LIMIT 20;';
    }
    else if (isset($_GET['prot']) && isset($_GET['source']))
    {
      $protein = (string)$_GET['prot'];
      $source = (string)$_GET['source'];
      $query_params = array(':source' => $source . "%", ':prot' => $protein);
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE source LIKE :source and `gene name` LIKE :prot LIMIT 20;';
    }
     else if (isset($_GET['source']) && isset($_GET['tissue']))
    {
      $source = $_GET['source'];
      $query_params = array(':source' => $source . "%");
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE source LIKE :source and tumour_site IN(' . $plist . ') LIMIT 20;';
    }
    else if (isset($_GET['source']))
    {
      $source = $_GET['source'];
      $query_params = array(':source' => $source . "%");
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE source LIKE :source LIMIT 20;';
    }
    else if (isset($_GET['protein']))
    {
      $protein = $_GET['protein'];
      $query_params = array(':prot' => $protein);
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE `gene name` LIKE :prot LIMIT 20;';
    }
    else if (isset($_GET['tissue']))
    {
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE tumour_site IN(' . $plist . ') LIMIT 20;';
    }

    $stmt = $dbh->prepare($query);
    $stmt->execute($query_params);

    $variants = array();
    $variant_names = array();
    $variant_ids = array();
    while ($row = $stmt->fetch())
    {
      if(!array_key_exists($row[0],$variants))
      {
        $variants[$row[0]] = array(array($row[1], $row[3]));
        $variant_names[$row[0]] = $row[2];
        $variant_ids[] = $row[0];
      }
      else
      {
        $variants[$row[0]][] = array($row[1], $row[3]);
      }
    }
    //let's get the interactions
    $interactions = array();
    $interaction_ids = array();
    $plist = '\'' . implode('\',\'', $variant_ids) . '\'';
    $query = 'SELECT IID, Interaction_EnsPID FROM T_Interaction WHERE Interaction_EnsPID IN(' . $plist . ');';
    $stmt = $dbh->prepare($query);
    $query_params = array();
    $stmt->execute($query_params);
    while ($row = $stmt->fetch())
    {
      $interaction_ids[] = $row[0];
      if(!array_key_exists($row[1],$interactions))
      {
      $interactions[$row[1]] = array($row[0]);
      }
      else
      {
      $interactions[$row[1]][] = $row[0];   
      }
    }

    //let's get the effects
    $effects = array();
    $plist = '\'' . implode('\',\'', $interaction_ids) . '\'';
    $query = 'SELECT IID, Eval FROM T_Interaction_MT WHERE IID IN(' . $plist . ');';
    $stmt = $dbh->prepare($query);
    $query_params = array();
    $stmt->execute($query_params);
    while ($row = $stmt->fetch())
    {
      $protein = '';
      foreach($interactions as $prot_name => $int)
      {
        foreach($int as $i)
        {
          if ($i == $row[0])
          {
            $protein = $prot_name;
          }
        }
      }
      if(!array_key_exists($protein,$effects))
      {
        $effects[$protein] = array($row[1]);
      }
      else
      {
        if(!in_array($row[1],$effects[$protein]))
        {
          $effects[$protein][] = $row[1];
        }
      }
    }

    foreach ($variants as $name => $data)
    {
      //get interactions
      if (array_key_exists($name, $interactions))
      {
        $int_num = count($interactions[$name]);
      }
      else
      {
        $int_num = '0';
      }
      $tissues = array();
      foreach ($data as $d){
        if(!in_array(ucwords(str_replace("_"," ", $d[0])),$tissues))
        {
          $tissues[] = ucwords(str_replace("_"," ", $d[0]));
        }
      }
      $plist = implode($tissues);
      if (array_key_exists($name, $effects))
      {
      $elist = implode(', ',$effects[$name]);
    }
    else
    {
      $elist = 'None';
    }
    ?>
  <tr data-protein="<?php echo $name;?>">
        <?php  ?>
        
        <td><?php echo $plist;?></td>
        <td class="selectable"><?php echo $name;?></td>
        <td class="selectable"><?php echo $variant_names[$name];?></td>
        <td><?php echo count($data)?></td>
        <td><?php echo $int_num;?></td>
        <td><?php echo $elist;?></td>
        </a>
  </tr>

    <script>
    $( document ).ready(function() {
      $('#variant-table tr').click(function() {
        window.location.href = './details.php?variant=' +$(this).data("protein");

      });
    });


    </script>
    <?php
    }
    ?>
      </tbody>
    </table>
</div>

    <?php
   }
   else{

   ?>
     <form class="form-horizontal" id="target" method="get">

     <input type="hidden" name="search" value="yes">
      <fieldset>

      <!-- Form Name -->
      <legend style='font-weight:300;'>Search for Protein Variants</legend>

      <!-- Text input-->
      <div class="col-md-5">
      <div class="form-group">
        <label class="col-md-3 control-label" for="tissue-input">Protein Name / ID</label>  
        <div class="col-md-8">
        <input id="tissue-input" name="prot" type="text" placeholder="search for a specific variant protein" class="form-control input-md">
          
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="variant-effect">Interaction Effect</label>
        <div class="col-md-7">
        <div class="checkbox">
          <label for="variant-effect-0">
            <input type="checkbox" checked name="variant-effect" id="variant-effect-0" value="gain">
            Gain of Function
          </label>
        </div>
        <div class="checkbox">
          <label for="variant-effect-1">
            <input type="checkbox" checked name="variant-effect1" id="variant-effect-1" value="loss">
            Loss of Function
          </label>
        </div>
        <div class="checkbox">
          <label for="variant-effect-2">
            <input type="checkbox" checked name="variant-effect2" id="variant-effect-2" value="none">
            Neutral (No Change)
          </label>
        </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="data-source-box">Variant Data Sources</label>
        <div class="col-md-7">
          <label class="checkbox-inline" for="data-source-box-0">
            <input type="checkbox" checked name="source" id="data-source-box-0" value="COSMIC">
            COSMIC
          </label>
        </div>
      </div>

      </div>

      <div class="col-md-5">

      <div class="form-group">
        <label class="col-md-4 control-label" for="selectmultiple">Select Specific Tissues</label>
        <div class="col-md-7">
          <select id="selectmultiple" name="tissue[]" class="form-control" multiple="multiple" style="height:160px;">
<?php
$query = "SELECT * FROM tissue_table_browser;";
$query_params = array();
$stmt = $dbh->prepare($query);
$stmt->execute($query_params);
$tissues = array();

while ($row = $stmt->fetch())
{
?>

            <option value="<?php echo $row[1];?>"><?php echo ucwords(str_replace("_"," ", $row[1]));;?></option>

<?php
}
?>
          </select>
        </div>
      </div>


      </div> 

  <div class="col-md-2">
      <div class="form-group">
    <button id="singlebutton" name="singlebutton" class="btn btn-danger" style="margin-top:135px;">Search</button>
    </div>
  </div>  
      </fieldset>
      </form>
  <?php
    }
      include $root_path. 'footer.php';
    ?>
   </div>

	</div>

	</div>

	<script>

	</script>
	</body>

</html>