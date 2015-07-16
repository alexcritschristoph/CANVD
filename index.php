<?php
	$root_path = "./";
  include_once('./common.php');

  //Generate sitewide database statistics
  include_once('./generate_stats.php');
	include_once('./header.php');

?>

      <span id="title_fix"></span>

	    <p align="justify">The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase (<span style="color:#ea2f10">Can-VD</span>) is an online resource for the assessment of the impact of cancer mutations on protein-protein interactions (PPI) networks. <a href='faqs/'>Read more...</a></p>

	  </div>
	<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="list-group">
			  <li class="list-group-item" style="background:#f04124;color:white;font-size:1.1em;">
			    Can-VD Statistics
			  </li>
			  <li class="list-group-item">Proteins <span data-color="alert-info" class="badge "><?php echo number_format(intval($protein_count));?></span></li>
        <li class="list-group-item">Domains/PWMs<span data-color="alert-info" class="badge "><?php echo number_format(intval($domain_count));?> / <?php echo number_format(intval($pwm_count));?></span></li>
		<li class="list-group-item">Interactions <span data-color="alert-info" class="badge "><?php echo number_format(intval($interaction_count));?></span></li>
        <li class="list-group-item">Variants <span data-color="alert-info" class="badge "><?php echo number_format(intval($mutation_count));?></span></li>
        <li class="list-group-item">Rewiring Effects <span data-color="alert-info" class="badge "><?php echo number_format(intval($rewire_count));?></span></li>

			</div>

      <div class="panel panel-default">
        <div class="panel-heading" style="background:#f04124;color:white;font-size:0.8em;font-weight:300;">
        <a href="./announce/" style="color:white;">Announcements and News</a>
        </div>
        <div class="panel-body" style="font-size:0.8em;">

         <?php
                             $query = 'SELECT *
                                      FROM announcements WHERE `show_homepage`=1 AND `show`=1 ORDER BY id DESC;';
                             $query_params = array();
                             $stmt = $dbh->prepare($query);
                             $stmt->execute($query_params);

                              while ($row = $stmt->fetch())
                              {

                                ?>
        <div style="margin-bottom:15px;">
        <span  style="display:block;margin-bottom:1px;"><a href="./announce/"><b style="display:block;"><?php echo $row[2];?></b></a><i style="padding-right:5px;font-size:0.75em;"><?php echo $row[1];?> </i></span>
        <?php #echo '<p align='justify'>';
        echo substr($row[3], 0, strpos($row[3], ".") + 1);

        ?>
        <br><a href='announce/'>Read more...</a>
        </div>
        <?php
      }
      ?>
        </div>
        </div>
		</div>

		<div class="col-md-9">
		    <form id="search_form" action="./network/" method="get" >
        <div class="input-group input-group-lg">
			  <input type="search" id="search_input" name="genename" class="form-control" placeholder="Enter a protein name or Ensembl ID. Examples: LYN, CRK, ENSP00000348602" >
			  <span class="input-group-btn">
		        <button type="submit" class="btn btn-danger" type="button" id="search_btn">Search</button>
            <button class="btn btn-default" type="button" id="advanced_btn">Advanced</button>
		      </span>
      </div>
      <div id="advanced-search-box" style="Display:none">
      <div class="form-signin">

	<div class="col-md-12" style="margin-bottom:10px;">        <h3 style="">Mutation Types</h3 >
	</div>
	<div class="col-md-4">
        <div class="form-group">
        <label class="control-label">Mutation Type</label>
        <input type='hidden' value='true' name="main_search">
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
<div class="col-md-3" >
      <div class="form-group">
        <label class="control-label">Variant Data Sources</label><br>
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
      </form>
      </div>
      <div id="browse-and-tabs">
			<ul class="nav nav-tabs" id="browse-tabs">
			  <li class="active" ><a data-tab="protein">Tissues/Cancer Types</a></li>
			  <li><a data-tab="cancer">Proteins</a></li>
			  <li><a data-tab="tumor">PWMs</a></li>
			</ul>

      <div  id="tissue-table">
			<table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Tissue</th>
                    <th>Total Variants (Mutations)</th>
                    <th>Gain of Interaction</th>
                    <th>Loss of Interaction</th>
                    <th>Total Proteins</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <tbody id="tissue-table-body">
                </tbody>
              </table>
              <ul class="pager" id="tissue-page" data-page=0>
                <li><a id="tissue-back">Previous</a></li>
                <span class='num-viewer'> Viewing <span id="tissue-start">1</span>-<span id="tissue-end">10</span> of <span id="tissue-total">40</span></span>
                <li><a id="tissue-forward">Next</a></li>
              </ul>
      </div>
          <div  id="protein-table">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Protein ID</th>
                    <th>Protein Name</th>
                    <th>Domain</th>
                    <th>Gain of Interactions</th>
                    <th>Loss of Interactions</th>
                    <th>Total Interactions</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <tbody id="protein-table-body">
                </tbody>
              </table>

              <script>
              $(function() {

                $("#search_form").on("submit", function( event ){
                    if ($("#search_input").val() == ''){
                      event.preventDefault();
                    }
                    else
                    {
                      $("#search_btn").html("<div class='spinner3' style='margin-left:10px;margin-right:10px;'><div class='cube1 cube3'></div><div class='cube2 cube3'></div></div>");
                    }
                });

                //Get total counts for the tables
		var tissue_total = 0;
		var pwm_total = 0;
		var protein_total = 0;
                $.ajax({
                    url: "./tables/get_totals.php",
                    type: "post",
                    dataType: 'json',
		    async: false,
                    success: function(results){
                      $("#tissue-total").html(results[0]);
		      tissue_total = results[0];
		      //alert(tissue_total);
                      $("#pwm-total").html(results[1]);
		      pwm_total = results[1];
                      $("#protein-total").html(results[2]);
		      protein_total = results[2];
                    },
                    error:function(){
                    }
                });

                $('#sl1').slider();
                $('#sl2').slider();
                $('#sl3').slider();
                $('#sl4').slider();
                $('#sl5').slider();
                $('#sl6').slider();
                $('#sl7').slider();
                $('#sl8').slider();
                $('#sl9').slider();
                $('#sl10').slider();
                function update_protein_view()
                {
                $("#protein-table").fadeOut('fast');
                  var test = $("#protein-page").data("page");
                  $("#protein-start").html(test);
                  if ($("#protein-page").data("page") +10 < protein_total){
		  $("#protein-end").html(test+10);
		  }
		  else{
		 $("#protein-end").html(protein_total);
		 }
                $.ajax({
                        url: "./tables/proteins.php",
                        type: "post",
                        data: {start:test},
                        success: function(results){
                            if (onTheClick)
                            {
                            $("#protein-table").fadeIn('fast');
                            }
                            $("#protein-table-body").html('');
                            $("#protein-table-body").html(results);
                        },
                        error:function(){
                        }
                    });
                }

                update_protein_view();
                var onTheClick = false;
                $("#protein-back").on( "click", function() {
                  onTheClick = true;
                  if ($("#protein-page").data("page") != 0)
                  {
                $("#protein-page").data("page", $("#protein-page").data("page")- 10);
                    update_protein_view();
                  }
                });

                $("#protein-forward").on( "click", function() {
                  onTheClick = true;
		  if($("#protein-page").data("page") +10< protein_total){
		  //alert($("#protein-page").data("page") +10);
		  //alert(protein_total);
                  $("#protein-page").data("page", $("#protein-page").data("page")+ 10);

                  update_protein_view();
		  }
                });


                function update_pwm_view()
                {
                  var test = $("#pwm-page").data("page");
                  $("#pwm-start").html(test);
		  if($("#pwm-page").data("page") +10< pwm_total){
                  $("#pwm-end").html(test+10);
		  }
		  else{
		  $("#pwm-end").html(pwm_total);
		  }
                $.ajax({
                        url: "./tables/pwm.php",
                        type: "post",
                        data: {start:test},
                        success: function(results){
                            if (results ==''){

                            }
                            else{
                            $("#pwm-table-body").html('');
                            $("#pwm-table-body").html(results);
                            }

                        },
                        error:function(){
                        }
                    });
                }

                update_pwm_view();

                $("#pwm-back").on( "click", function() {
                  if ($("#pwm-page").data("page") != 0)
                  {
                $("#pwm-page").data("page", $("#pwm-page").data("page")- 10);
                    update_pwm_view();
                  }
                });

                $("#pwm-forward").on( "click", function() {
		if($("#pwm-page").data("page") +10< pwm_total){
                  $("#pwm-page").data("page", $("#pwm-page").data("page")+ 10);
                  update_pwm_view();
		}
                });


                function update_tissue_view()
                {
                  var test = $("#tissue-page").data("page");
                  ///alert($("#tissue-page").data("page") + 10);
		  //alert(tissue_total);
		  $("#tissue-start").html(test);
		  if($("#tissue-page").data("page") +10 < tissue_total){
                  $("#tissue-end").html($("#tissue-page").data("page") +10);
		  //alert(test+10);
		  }
	   	  else{
		  $("#tissue-end").html(tissue_total);
		  }
                $.ajax({
                        url: "./tables/tissues.php",
                        type: "post",
                        data: {start:test},
                        success: function(results){
                          if (results ==''){
                          }
                          else {
                            $("#tissue-table-body").html('');
                            $("#tissue-table-body").html(results);
                          }
                        },
                        error:function(){
                        }
                    });
                }

                update_tissue_view();

                $("#tissue-back").on( "click", function() {
                  if ($("#tissue-page").data("page") != 0)
                  {
                $("#tissue-page").data("page", $("#tissue-page").data("page")- 10);
                    update_tissue_view();
                  }
                });

                $("#tissue-forward").on( "click", function() {
		 if ($("#tissue-page").data("page")+ 10 < tissue_total){
                  $("#tissue-page").data("page", $("#tissue-page").data("page")+ 10);
                  update_tissue_view();
		}
                });

                $("#advanced_btn").on( "click", function() {
                  if ($("#advanced_btn").text() == 'Advanced'){
                    $("#advanced_btn").addClass("btn-info");
                    $("#advanced_btn").text("Basic");
                    $("#browse-and-tabs").hide();
                    $("#advanced-search-box").show();
                  }
                  else{
                    $("#advanced_btn").removeClass("btn-info");
                    $("#advanced_btn").text("Advanced");
                    $("#browse-and-tabs").show();
                    $("#advanced-search-box").hide();
                  }

                });

                $("body").on( "click", ".pwm-img", function() {
                  $("#testing").modal('show');
                  $("#actual-image-content").css("padding-top", "15px");
                  $("#actual-image-content").html($(this).clone().css("height", "200px"));
                  $("#actual-image-content").append($(this).data("content"));
                });


              });
              </script>

              <ul class="pager" id="protein-page" data-page=0>
                <li><a id="protein-back">Previous</a></li>
                <span class='num-viewer'> Viewing <span id="protein-start">1</span>-<span id="protein-end">20</span> of <span id="protein-total">40</span></span>
                <li><a id="protein-forward">Next</a></li>
              </ul>

          </div>
          <div class="modal fade" id="testing">
          <div class="modal-dialog">
            <div class="modal-content">
            <p id="actual-image-content" class="row text-center">
            </p>
          </div>
          </div>
          </div>
          <div id="pwm-table">
              <table class="table table-striped table-hover" id="pwm-actual-table">
                <thead>
                  <tr>
                    <th>PWM</th>
                    <th>Logo</th>
                    <th>PWM</th>
                    <th>Logo</th>
                  </tr>
                </thead>
                <tbody id="pwm-table-body">

                </tbody>
              </table>

              <ul class="pager" id="pwm-page" data-page=0>
                <li><a id="pwm-back">Previous</a></li>
                <span  class='num-viewer'> Viewing <span id="pwm-start">1</span>-<span id="pwm-end">20</span> of <span id="pwm-total">40</span></span>
                <li><a id="pwm-forward">Next</a></li>
              </ul>
              <script>
              $(function () {
    $('#example').popover();
});
              </script>
          </div>
    </div>
		</div>
	</div>
		<?php
      		include $root_path. 'footer.php';
		?>

	</div>

	</div>
	</body>

</html>
