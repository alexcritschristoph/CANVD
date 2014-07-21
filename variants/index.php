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
    <div class="col-md-12">
    <div class="navbar navbar-inverse">
  <div class="navbar-header">
    <a class="navbar-brand" href="#">Variant Browser</a>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Showing <span id="current_count">20</span> out of <span id="total_num">2930</span> Total Matches</a></li>
      <li><button href="#" class="btn btn-default" style="color:black;font-size:1.5em;height:42px;" id="click-more" >+</button></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle filter-dropdown" data-toggle="dropdown">Filter by <b class="caret"></b></a>

        <ul class="dropdown-menu">
          <li><a href="#"></a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li class="divider"></li>
          <li class="dropdown-header">Dropdown header</li>
          <li><a href="#">Separated link</a></li>
          <li><a href="#">One more separated link</a></li>
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle download-dropdown" data-toggle="dropdown">Download <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li class="divider"></li>
          <li><a href="#">Separated link</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
  <table class="table table-striped table-hover" id="variant-table">
      <thead>
        <tr>
          <th>Tissue</th>        
          <th>Protein ID</th>
          <th>Protein Name</th>
          <th>Variants in Tissue(s)</th>
          <th>Interactions</th>
          <th>Effect(s)</th>
        </tr>
      </thead>
      <tbody id="variants-results">
    <?php include('./variant_load.php');?>

    <script>
    var tissues_selected = <?php echo json_encode($_GET['tissue']);?>;
    $( document ).ready(function() {

      $("#click-more").on("click", function(){
        $("#click-more").html("<img src='./ajax-loader.gif'>");
        $("#click-more").attr('disabled','disabled');
      $.ajax({
          url: "./variant_load.php",
          type: "GET",
          data: { is_ajax: "yes", tissue:tissues_selected, current_count:parseInt($("#current_count").text())+20},
          success: function(results){
            $("#current_count").html(parseInt($("#current_count").text())+20);
            $("#variants-results").append(results);
            $("#click-more").html("+");
            $("#click-more").removeAttr('disabled');
          },
          error:function(){
              alert("failure");
          }
      });        
    });


      $("#total_num").html(mut_count);
      $('#variant-table tr').click(function() {
        window.location.href = './details.php?variant=' +$(this).data("protein");

      });
    });


    </script>    
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