<?php
	$root_path = "./";
  include_once('./common.php');

  //Generate sitewide database statistics
  include_once('./generate_stats.php');
?>

<html>
	<head>
		<title>
			Cancer Variants Database
		</title>
		<link href="<?php echo $root_path;?>bootstrap.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
		<script src="<?php echo $root_path;?>site.js" ></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $root_path;?>styles.css">
    <link href="./slider.css" rel="stylesheet">
    <script src="<?php echo $root_path;?>bootstrap.js"></script>
    <script src="./bootstrap-slider.js"></script>
	</head>

	<body style="background:#fafafa">
	<div class="jumbotron" style="margin-bottom:0px;height:100%">
	  <div class="container">
    <p class="pull-right" style="margin-left:10px;margin-top:25px;"><a class="btn btn-danger" href="<?php echo $root_path;?>about" role="button"><i class="fa fa-flask"></i> Variants </a>
      <a class="btn btn-default" href="<?php echo $root_path;?>faqs" role="button"><i class="fa fa-question"></i> About</a>
      <a class="btn btn-default" href="<?php echo $root_path;?>contact" role="button"><i class="fa fa-envelope-o"></i> Contact</a>
      </p>
	    <h1><a href="<?php echo $root_path;?>"><span style="color:#ea2f10">Can-VD</span>: The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase</a></h1>
	    
	    <p>The effects of over 800,000 missense mutations are analyzed and stored in the <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase (<span style="color:#ea2f10">Can-VD</span>). <span style="color:#ea2f10">Can-VD</span> stores the PPI interactions mediated by wildtype and variants protein sequences to build and compare the PPI network in the two conditions and understand the effects of mutations on the network and, consequently, the cellular and biological functions of the cancer system.</p>

	  </div>
	<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="list-group">
			  <li class="list-group-item" style="background:#f04124;color:white;font-size:1.1em;">
			    Can-VD Statistics
			  </li>
			  <li class="list-group-item">Proteins <span data-color="alert-info" class="badge "><?php echo number_format(intval($protein_count));?></span></li>			  
        <li class="list-group-item">Domains <span data-color="alert-info" class="badge "><?php echo number_format(intval($domain_count));?></span></li>
			  <li class="list-group-item">Interactions <span data-color="alert-info" class="badge "><?php echo number_format(intval($interaction_count));?></span></li>
        <li class="list-group-item">Variants <span data-color="alert-info" class="badge "><?php echo number_format(intval($mutation_count));?></span></li>
        <li class="list-group-item">PWMs <span data-color="alert-info" class="badge "><?php echo number_format(intval($pwm_count));?></span></li>

			</div>

      <div class="panel panel-default">
        <div class="panel-heading" style="background:#f04124;color:white;font-size:0.8em;font-weight:300;">
        <a href="./announce/" style="color:white;">Announcements and News</a>
        </div>
        <div class="panel-body" style="font-size:0.8em;">

         <?php
                             $query = 'SELECT *
                                      FROM announcements WHERE `show_homepage`=1 ORDER BY id DESC;';
                             $query_params = array();
                             $stmt = $dbh->prepare($query);
                             $stmt->execute($query_params);

                              while ($row = $stmt->fetch())
                              {

                                ?>
        <div style="margin-bottom:15px;">
        <span  style="display:block;margin-bottom:1px;"><a href="./announce/"><b style="display:block;"><?php echo $row[2];?></b></a><i style="padding-right:5px;font-size:0.75em;"><?php echo $row[1];?> </i></span>
        <?php echo $row[3];?>
        </div>
        <?php
      }
      ?>
        </div>
        </div>
		</div>

		<div class="col-md-9">
		    <form id="search_form" class="input-group input-group-lg" action="./network/" method="get">
			  <input type="search" id="search_input" name="genename" class="form-control" placeholder="Enter a protein name or Ensembl ID. Examples: CRK, ENSP00000348602">
			  <span class="input-group-btn">
		        <button type="submit" class="btn btn-danger" type="button" id="search_btn">Search</button>
            <button class="btn btn-default" type="button" id="advanced_btn">Advanced</button>
		      </span>
			</form>

      <div id="advanced-search-box" style="Display:none">
      <form class="form-signin" role="form">
        <div class="col-md-6">
        <p class="form-signin-heading">Advanced Search Options:</p>        
        <input type="email" style="display:block;margin-top:15px;margin-bottom:15px;" placeholder="Max # of Interactions" required autofocus>
        <label class="checkbox" style="margin-top:15px;">
          <input type="checkbox" value="remember-me"> Mutant Networks Only
        </label>
        <label class="checkbox" style="margin-top:5px;">
          <input type="checkbox" value="remember-me"> Gain of Interaction Only
        </label>

        <label class="checkbox" style="margin-top:5px;">
          <input type="checkbox" value="remember-me"> Loss of Interaction Only
        </label>
        </div>

        <div class="col-md-6">
        <p>Interaction Evaluation Ranges</p>

        <div style="padding-top:10px;">
        <input type="text" style="width:200px;" data-slider-min="0" data-slider-max="1" data-slider-step="0.25" data-slider-value="[0,1]" id="sl1" ><span style="padding-left:15px;font-size:1em;">Gene Expression</span></div>
        <div style="padding-top:10px;">
        <input type="text" style="width:200px;" data-slider-min="0" data-slider-max="1" data-slider-step="0.25" data-slider-value="[0,1]" id="sl2" ><span style="padding-left:15px;padding-top:10px;font-size:1em;">Protein Expression</span></div>
        <div style="padding-top:10px;">
        <input type="text" style="width:200px;padding-left:25px;" data-slider-min="0" data-slider-max="1" data-slider-step="0.25" data-slider-value="[0,1]" id="sl3" ><span style="padding-left:15px;padding-top:10px;font-size:1em;">Disorder</span></div>
        <div style="padding-top:10px;">
        <input type="text" style="width:200px;" data-slider-min="0" data-slider-max="1" data-slider-step="0.25" data-slider-value="[0,1]" id="sl4" ><span style="padding-left:15px;padding-top:10px;font-size:1em;">Surface Accessibility</span></div>
        <div style="padding-top:10px;">
        <input type="text" style="width:200px;" data-slider-min="0" data-slider-max="1" data-slider-step="0.25" data-slider-value="[0,1]" id="sl5" ><span style="padding-left:15px;padding-top:10px;font-size:1em;">Peptide Conversation</span></div>
        <div style="padding-top:10px;">
        <input type="text" style="width:200px;" data-slider-min="0" data-slider-max="1" data-slider-step="0.25" data-slider-value="[0,1]" id="sl6" ><span style="padding-left:15px;padding-top:10px;font-size:1em;">Molecular Function</span></div>
        <div style="padding-top:10px;">
        <input type="text" style="width:200px;" data-slider-min="0" data-slider-max="1" data-slider-step="0.25" data-slider-value="[0,1]" id="sl7" ><span style="padding-left:15px;padding-top:10px;font-size:1em;">Biological Process</span></div>
        <div style="padding-top:10px;">
        <input type="text" style="width:200px;" data-slider-min="0" data-slider-max="1" data-slider-step="0.25" data-slider-value="[0,1]" id="sl8" ><span style="padding-left:15px;padding-top:10px;font-size:1em;">Localization</span></div>
        <div style="padding-top:10px;">
        <input type="text" style="width:200px;" data-slider-min="0" data-slider-max="1" data-slider-step="0.25" data-slider-value="[0,1]" id="sl9" ><span style="padding-left:15px;padding-top:10px;font-size:1em;">Sequence Signature</span></div>
        <div style="padding-top:10px;">
        <input type="text" style="width:200px;" data-slider-min="0" data-slider-max="1" data-slider-step="0.25" data-slider-value="[0,1]" id="sl10" ><span style="padding-left:15px;padding-top:10px;font-size:1em;">Average</span></div>
             
        </div>
      </form>
      </div>
      <div id="browse-and-tabs">
			<ul class="nav nav-tabs" id="browse-tabs">
			  <li class="active" ><a data-tab="protein">Tissues</a></li>
			  <li><a data-tab="cancer">Proteins</a></li>
			  <li><a data-tab="tumor">PWMs</a></li>
			</ul>

      <div  id="tissue-table">
			<table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Tissue</th>
                    <th>Total Variants</th>
                    <th>Gain of Function</th>
                    <th>Loss of Function</th>
                    <th>Total Proteins</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <tbody id="tissue-table-body">
                </tbody>
              </table>
              <ul class="pager" id="tissue-page" data-page=0>
                <li><a id="tissue-back">Previous</a></li>
                <li><a id="tissue-forward">Next</a></li>
              </ul>
      </div>    
          <div  id="protein-table">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Ensembl ID</th>
                    <th>Protein Name</th>
                    <th>Type/Domain</th>
                    <th>Gain of Function</th>
                    <th>Loss of Function</th>
                    <th>Total Variants</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <tbody id="protein-table-body">
                </tbody>
              </table>

              <script>
              $(function() {

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
                  var test = $("#protein-page").data("page");
                $.ajax({
                        url: "./tables/proteins.php",
                        type: "post",
                        data: {start:test},
                        success: function(results){
                            $("#protein-table-body").html('');
                            $("#protein-table-body").html(results);
                        },
                        error:function(){
                            alert("failure");
                        }
                    });                  
                }

                update_protein_view();

                $("#protein-back").on( "click", function() {
                  if ($("#protein-page").data("page") != 0)
                  {
                $("#protein-page").data("page", $("#protein-page").data("page")- 10);
                    update_protein_view();
                  }
                });

                $("#protein-forward").on( "click", function() {
                  $("#protein-page").data("page", $("#protein-page").data("page")+ 10);
                  update_protein_view();
                });


                function update_pwm_view()
                {
                  var test = $("#pwm-page").data("page");
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
                            alert("failure");
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
                  $("#pwm-page").data("page", $("#pwm-page").data("page")+ 10);
                  update_pwm_view();
                });


                function update_tissue_view()
                {
                  var test = $("#tissue-page").data("page");
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
                            alert("failure");
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
                  $("#tissue-page").data("page", $("#tissue-page").data("page")+ 10);
                  update_tissue_view();
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

              });
              </script>

              <ul class="pager" id="protein-page" data-page=0>
                <li><a id="protein-back">Previous</a></li>
                <li><a id="protein-forward">Next</a></li>
              </ul>

          </div>
          <div id="pwm-table">
              <table class="table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>PWM</th>
                    <th>Domain/Pattern</th>
                    <th>Protein</th>
                    <th>Type</th>
                    <th>Logo</th>
                    <th>Files</th>
                  </tr>
                </thead>
                <tbody id="pwm-table-body">
                                   
                </tbody>
              </table>

              <ul class="pager" id="pwm-page" data-page=0>
                <li><a id="pwm-back">Previous</a></li>
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