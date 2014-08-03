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

	<body style="background:#fafafa;height:110%;">
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
      <li class="active"><a href="#">Showing <span id="current_count">20</span> out of <span id="total_num"></span> Variants in <span id="prot_current"></span> out of <span id="prot_num"></span> Proteins</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle filter-dropdown" data-toggle="dropdown">Filter Interaction <b class="caret"></b></a>

        <ul class="dropdown-menu">
          <li><a href="#">Gain of Interaction</a></li>
          <li><a href="#">Loss of Interaction</a></li>
        </ul>
      </li>

      <li class="dropdown">
      <a href="#" class="dropdown-toggle filter-dropdown" data-toggle="dropdown">Filter Tissue <b class="caret"></b></a>
        <ul class="dropdown-menu">

          <?php
            $tissues = $_GET['tissue'];
            foreach ($tissues as $tissue_name)
            {
             ?><li><a href="#" class="tissue-filter"><?php echo $tissue_name;?></a></li><?php
            }
          ?>
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle download-dropdown" data-toggle="dropdown">Download <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="#">Download Current</a></li>
          <li><a href="#">Download All</a></li>
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
    var processing;

    $( document ).ready(function() {

      $(".tissue-filter").on("click", function(){
        $("#current_count").text("0");
        $("#variants-results").empty();
        tissues_selected = [$(this).html()];
        $("#variants-results").parent().after("<img id='loader' style='display:block;margin-left:500px;margin-right:auto;width:25px;' src='./ajax-loader.gif'>");
        $.ajax({
          url: "./variant_load.php",
          type: "GET",
          data: { is_ajax: "yes", is_tissue: "yes", tissue:tissues_selected, current_count:parseInt($("#current_count").text())+20},
          success: function(results){
            $("#current_count").html(parseInt($("#current_count").text())+20);
            $("#variants-results").append(results);
            $("#total_num").html($("#mut_c").data("count"));
            $("#prot_num").html($("#prot_c").data("count"));

            $("#prot_current").html($("#variants-results tr").length);
            $("#loader").remove();
            processing = false;
          },
          error:function(){
              alert("failure");
          }
        });  

      });

       $(document).scroll(function(e){

        if (processing)
            return false;

        if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.9){
          processing = true;
          $("#variants-results").parent().after("<img id='loader' style='display:block;margin-left:500px;margin-right:auto;width:25px;' src='./ajax-loader.gif'>");
          $.ajax({
          url: "./variant_load.php",
          type: "GET",
          data: { is_ajax: "yes", tissue:tissues_selected, current_count:parseInt($("#current_count").text())+20},
          success: function(results){
            $("#current_count").html(parseInt($("#current_count").text())+20);
            $("#variants-results").append(results);
            $("#prot_current").html($("#variants-results tr").length);
            $("#loader").remove();
            processing = false;
          },
          error:function(){
              alert("failure");
          }
      });  

        }
       });
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
      $("#prot_num").html(prot_count);
      $("#prot_current").html($("#variants-results tr").length);
      $('#variant-table tbody').on("click", "tr", function() {
        window.location.href = './details.php?variant=' +$(this).data("protein") + '&tissues=' + tissues_selected;

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