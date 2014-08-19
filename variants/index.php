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
      <li class="active"><a href="#">Showing <span id="current_count"></span> out of <span id="total_num"></span> Variants in <span id="prot_current"></span> out of <span id="prot_num"></span> Proteins</a></li>
<!--        -->

      <li class="dropdown">
      <a href="#" class="dropdown-toggle filter-dropdown" data-toggle="dropdown">Filter Tissue <b class="caret"></b></a>
        <ul class="dropdown-menu" id="filter-tissue-list">
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle download-dropdown" data-toggle="dropdown">Download <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="#" id='download-current'>Download Current View</a></li>
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
    var mut_types = <?php echo json_encode($_GET['mut_type']);?>;
    var prot_name = <?php echo json_encode($_GET['prot']);?>;
    var prot_source = <?php echo json_encode($_GET['source']);?>;
    var processing;

    $( document ).ready(function() {
      if (tissues_selected.length > 0){
        for (index = 0; index < tissues_selected.length; ++index) {
        $("#filter-tissue-list").append("<li><a href='#' class='tissue-filter' data-tissue='" + tissues_selected[index] + "'>" + tissues_selected[index].replace("_", " ").charAt(0).toUpperCase() + tissues_selected[index].replace("_", " ").slice(1) + "</a></li>");
        }
      }


      $(".tissue-filter").on("click", function(){
        $("#current_count").text("0");
        $("#prot_current").text("0");
        $("#variants-results").empty();
        tissues_selected = [$(this).data("tissue")];
        $("#variants-results").parent().after("<div class='spinner'><div class='bounce1'></div><div class='bounce2'></div><div class='bounce3'></div></div>");
        $.ajax({
          url: "./variant_load.php",
          type: "GET",
          data: { is_ajax: "yes", is_tissue: "yes", tissue:tissues_selected, current_count:parseInt($("#prot_current").text()), prot:prot_name, source:prot_source, mut_type:mut_types},
          success: function(results){
            $("#variants-results").append(results);

            var variant_count = 0;
            $('#variants-results').children('tr').each(function () {
             if ($.isNumeric($(this).find(".mut-count").text())){
               variant_count += parseInt($(this).find(".mut-count").text());
             }
            });
            $("#current_count").html(variant_count);

            $("#total_num").html($("#mut_c").data("count"));
            $("#prot_num").html($("#prot_c").data("count"));

            $("#prot_current").html($("#variants-results .normal").length);
            $(".spinner").remove();
            processing = false;
          },
          error:function(){
          }
        });  

      });




       $(document).scroll(function(e){

        if (processing)
            return false;

        if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.9){
          processing = true;
          $("#variants-results").parent().after("<div class='spinner'><div class='bounce1'></div><div class='bounce2'></div><div class='bounce3'></div></div>");
          $.ajax({
          url: "./variant_load.php",
          type: "GET",
          data: { is_ajax: "yes", tissue:tissues_selected, current_count:parseInt($("#prot_current").text()), prot:prot_name, source:prot_source, mut_type:mut_types},
          success: function(results){
            $("#variants-results").append(results);
            //Get current # of variants
            var variant_count = 0;
            $('#variants-results').children('tr').each(function () {
              console.log($(this).find(".mut-count").text());
            if ($.isNumeric($(this).find(".mut-count").text())){
             variant_count += parseInt($(this).find(".mut-count").text());
           }
            });
            $("#current_count").html(variant_count);

            $("#prot_current").html($("#variants-results .normal").length);
            $(".spinner").remove();
            processing = false;
          },
          error:function(){
          }
      });  

        }
       });

      $("#total_num").html(mut_count);
      $("#prot_num").html(prot_count);
      var variant_count = 0;
      $('#variants-results').children('tr').each(function () {
       if ($.isNumeric($(this).find(".mut-count").text())){
         variant_count += parseInt($(this).find(".mut-count").text());
       }
      });
      $("#current_count").html(variant_count);
      $("#prot_current").html($("#variants-results .normal").length);


      $('#variant-table tbody').on("click", "tr", function() {
        window.location.href = './details.php?variant=' +$(this).data("protein") + '&tissues=' + tissues_selected;
      });

      $("#download-current").on("click", function(){
        window.location.href = './download.php?tissue=' + tissues_selected + '&source=' + '<?php echo json_encode($_GET["source"]);?>' + '&type=' + '<?php echo json_encode($_GET["mut_type"]);?>' + '&end=' + $('#prot_current').text() <?php if(isset($_GET['prot'])){ ?> + '&prot=' + "<?php echo $_GET['prot'];?>"<?php } ?>;
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
     <input type='hidden' value='true' name="variant_search">
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
        <label class="col-md-3 control-label" for="variant-effect">Mutation Type</label>
        <div class="col-md-7">
        <?php
        //Get all database mutation types.
        $query = "SELECT DISTINCT mut_description FROM T_Mutations;";
        $query_params = array();
        $stmt = $dbh->prepare($query);
        $stmt->execute($query_params);

        while ($row = $stmt->fetch())
        {
        ?>
        <div class="checkbox">
          <label>
            <input type="checkbox" checked name="mut_type[]" id="variant-effect-0" value="<?php echo $row[0] ?>">
            <?php echo $row[0] ?>
          </label>
        </div>
        <?php
      }
      ?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">Variant Data Sources</label>
        <div class="col-md-7">
              <?php
      //Get all database sources.
       $query = "SELECT DISTINCT Source FROM T_Mutations;";
        $query_params = array();
        $stmt = $dbh->prepare($query);
        $stmt->execute($query_params);

        while ($row = $stmt->fetch())
        {
      ?>
          <label class="checkbox-inline" for="data-source-box-0">
            <input type="checkbox" checked name="source[]" id="data-source-box-0" value="<?php echo trim($row[0]); ?>">
            <?php echo $row[0]; ?>
          </label>
          <?php }?>
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
    <script>
    $(function(){
      $("#singlebutton").on("click", function(){
          $("#singlebutton").html("<div class='spinner3'><div class='cube1 cube3'></div><div class='cube2 cube3'></div></div>");
      });
    });
    </script>

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