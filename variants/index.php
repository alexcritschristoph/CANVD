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
     <form class="form-horizontal" id="target">
      <fieldset>

      <!-- Form Name -->
      <legend style='font-weight:300;'>Search for Protein Variants</legend>

      <!-- Text input-->
      <div class="col-md-5">
      <div class="form-group">
        <label class="col-md-3 control-label" for="tissue-input">Protein Name / ID</label>  
        <div class="col-md-8">
        <input id="tissue-input" name="tissue-input" type="text" placeholder="search for a specific variant protein" class="form-control input-md">
          
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
            <input type="checkbox" checked name="variant-effect" id="variant-effect-1" value="loss">
            Loss of Function
          </label>
        </div>
        <div class="checkbox">
          <label for="variant-effect-2">
            <input type="checkbox" checked name="variant-effect" id="variant-effect-2" value="none">
            Neutral (No Change)
          </label>
        </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="data-source-box">Variant Data Sources</label>
        <div class="col-md-7">
          <label class="checkbox-inline" for="data-source-box-0">
            <input type="checkbox" checked name="data-source-box" id="data-source-box-0" value="COSMIC">
            COSMIC
          </label>
        </div>
      </div>

      </div>

      <div class="col-md-5">

      <div class="form-group">
        <label class="col-md-4 control-label" for="selectmultiple">Filter by Tissue Type</label>
        <div class="col-md-7">
          <select id="selectmultiple" name="selectmultiple" class="form-control" multiple="multiple" style="height:160px;">
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


  <div class="col-md-11">
  <table class="table table-striped">
      <thead>
        <tr>
          <th>Tissue</th>        
          <th>Protein ID</th>
          <th>Protein Name</th>
          <th>Number of Variants</th>
          <th>Effect</th>
        </tr>
      </thead>
      <tbody id="variants-results">
        <tr>
          <td>1</td>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <td>3</td>
          <td>Larry</td>
          <td>the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>
</div>
   </div>
  <?php
      include $root_path. 'footer.php';
    ?>

	</div>

	</div>

	<script>
  $( "#target" ).submit(function( event ) {
  event.preventDefault();
  var foo = []; 
  $('#selectmultiple :selected').each(function(i, selected){ 
    foo[i] = $(selected).text(); 
  });
	$.ajax({
      url: "../tables/variants.php",
      type: "post",
      data: {start:JSON.stringify(foo)},
      success: function(results){
          $("#variants-results").html(results);
      },
      error:function(){
          alert("failure");
      }
  });   
  });
	</script>
	</body>

</html>