<?php

//output format 1: protein id, tissue type, variant #, interaction #

//output format 2: protein id, tissue type, variant id, effect
  $root_path = "../";
  include_once('../common.php');

  //Check to see which options are set?
  //Form query
    //Which tissues are specified?
  	$start = 0;
	 if(!isset($_GET['current_count'])){
	 	$start = 0;
	 }
	 else {
	 	$start = $_GET['current_count'];
	 }
    if(isset($_GET['tissue'])){
    $tissues = $_GET['tissue'];
    $plist = '\'' . implode('\',\'', $tissues) . '\'';
    }            
    
    //First look for proteins in T_Mutations with correct tumor site, source, and protein name.
    $query = '';
    $protein = '';
    $source = '';
    if (isset($_GET['prot']) && $_GET['prot'] == ''){
      unset($_GET['prot']); 
    }

   // $query = 'SELECT EnsPID, `gene name` FROM T_Mutations WHERE tumour_site IN(' . $plist . ') GROUP BY EnsPID LIMIT [start],20;';
   // $query_params = array();
    if(isset($_GET['prot']) && isset($_GET['tissue']) && isset($_GET['source']))
    {
      $protein = (string)$_GET['prot'];
      $source = $_GET['source'];
      $query_params = array(':source' => $source . "%", ':prot' => $protein);
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE source LIKE :source and `gene name` LIKE :prot and tumour_site IN(' . $plist . ') LIMIT ' . $start . ',20;';
      $query2 = 'SELECT  count(ID) from T_Mutations WHERE source LIKE :source and `gene name` LIKE :prot and tumour_site IN(' . $plist . ') ;';
    }
    else if (isset($_GET['prot']) && isset($_GET['tissue']))
    {
      $protein = $_GET['prot'];
      $query_params = array(':prot' => $protein);
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE `gene name` LIKE :prot and tumour_site IN(' . $plist . ') LIMIT ' . $start . ',20;';
      $query2 = 'SELECT  count(ID) from T_Mutations WHERE `gene name` LIKE :prot and tumour_site IN(' . $plist . ')  ;';

    }
    else if (isset($_GET['prot']) && isset($_GET['source']))
    {
      $protein = (string)$_GET['prot'];
      $source = (string)$_GET['source'];
      $query_params = array(':source' => $source . "%", ':prot' => $protein);
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE source LIKE :source and `gene name` LIKE :prot LIMIT ' . $start . ',20;';
      $query2 = 'SELECT  count(ID) from T_Mutations WHERE source LIKE :source and `gene name` LIKE :prot ;';

    }
     else if (isset($_GET['source']) && isset($_GET['tissue']))
    {
      $source = $_GET['source'];
      $query_params = array(':source' => $source . "%");
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE source LIKE :source and tumour_site IN(' . $plist . ') LIMIT ' . $start . ',20;';
      $query2 = 'SELECT  count(ID) from T_Mutations WHERE source LIKE :source and tumour_site IN(' . $plist . ') ;';

    }
    else if (isset($_GET['source']))
    {
      $source = $_GET['source'];
      $query_params = array(':source' => $source . "%");
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE source LIKE :source LIMIT ' . $start . ',20;';
      $query2 = 'SELECT  count(ID) from T_Mutations WHERE source LIKE :source  ;';

    }
    else if (isset($_GET['protein']))
    {
      $protein = $_GET['protein'];
      $query_params = array(':prot' => $protein);
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE `gene name` LIKE :prot LIMIT ' . $start . ',20;';
      $query2 = 'SELECT  count(ID) from T_Mutations WHERE `gene name` LIKE :prot  ;';

    }
    else if (isset($_GET['tissue']))
    {
	$query_params = array();
      $query = 'SELECT EnsPID, tumour_site, `gene name`, mut_syntax_aa FROM T_Mutations WHERE tumour_site IN(' . $plist . ') LIMIT ' . $start . ',20;';
      $query2 = 'SELECT  count(ID) from T_Mutations WHERE tumour_site IN(' . $plist . ')  ;';

    }


    if (!isset($_GET['is_ajax'])){
	    $stmt = $dbh->prepare($query2);
	    $stmt->execute($query_params);
	    $mut_count = $stmt->fetch()[0];    	
	    echo "<script>var mut_count = '" . number_format($mut_count) . "';</script>";

	    //Get total number of proteins
	    $query3 = "SELECT COUNT(DISTINCT `EnsPID`) as distinct_proteins FROM T_Mutations WHERE tumour_site IN(" . $plist . ");";
	    $stmt = $dbh->prepare($query3);
	    $stmt->execute($query_params);
	    $prot_count = $stmt->fetch()[0];
	    echo "<script>var prot_count = '" . number_format($prot_count) . "';</script>"; 
    }

    if (isset($_GET['is_tissue'])){
		$stmt = $dbh->prepare($query2);
	    $stmt->execute($query_params);
	    $mut_count = $stmt->fetch()[0];    	
	    echo "<tr id='mut_c' data-count=". number_format($mut_count). "></tr>";

	    //Get total number of proteins
	    $query3 = "SELECT COUNT(DISTINCT `EnsPID`) as distinct_proteins FROM T_Mutations WHERE tumour_site IN(" . $plist . ");";
	    $stmt = $dbh->prepare($query3);
	    $stmt->execute($query_params);
	    $prot_count = $stmt->fetch()[0];
	    echo "<tr id='prot_c' data-count=". number_format($prot_count). "></tr>";
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
        
        <?php echo $plist;?>
        <?php echo $name;?>
        <?php echo $variant_names[$name];?>
        <?php echo count($data)?>
        <?php echo $int_num;?>
        <?php echo $elist;?>
        </a>
  </tr>
    <?php
    }
    ?>
