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
    <script src="<?php echo $root_path;?>bootstrap.js"></script>
	</head>

	<body style="background:#fafafa">
	<div class="jumbotron" style="margin-bottom:0px;height:100%">
	  <div class="container">
    <p class="pull-right" style="margin-left:10px;margin-top:25px;"><a class="btn btn-danger" href="<?php echo $root_path;?>about" role="button"><i class="fa fa-flask"></i> About </a>
      <a class="btn btn-default" href="<?php echo $root_path;?>faqs" role="button"><i class="fa fa-question"></i> FAQs</a>
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
        <li class="list-group-item">Interaction Domains <span data-color="alert-info" class="badge "><?php echo number_format(intval($domain_count));?></span></li>
			  <li class="list-group-item">Interactions <span data-color="alert-info" class="badge "><?php echo number_format(intval($interaction_count));?></span></li>
        <li class="list-group-item">Mutations <span data-color="alert-info" class="badge "><?php echo number_format(intval($mutation_count));?></span></li>
			</div>
		</div>

		<div class="col-md-9">
		    <form id="search_form" class="input-group input-group-lg" action="./network/" method="get">
			  <input type="search" id="search_input" name="genename" class="form-control" placeholder="enter a protein name. Examples: CRK, NEDD9">
			  <span class="input-group-btn">
		        <input type="submit" class="btn btn-danger" type="button" id="search_btn">Search</input>
		      </span>
			</form>

			<ul class="nav nav-tabs" id="browse-tabs">
			  <li ><a data-tab="protein">Tissues</a></li>
			  <li class="active"><a data-tab="cancer">Proteins</a></li>
			  <li><a data-tab="tumor">PWMs</a></li>
			</ul>

			<table class="table table-striped table-hover" id="tissue-table">
                <thead>
                  <tr>
                    <th>Tissue</th>
                    <th>Total Variants</th>
                    <th>Gain of Function Variants</th>
                    <th>Loss of Function Variants</th>
                    <th>Total Proteins</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <tbody id="tissue-table-body">
                </tbody>
              </table>

          <script>
              $(function() {
                function update_tissue_view()
                {
                  //var test = $("#protein-page").data("page");
                $.ajax({
                        url: "./tables/tissues.php",
                        type: "post",
                        data: {start:0},
                        success: function(results){
                            $("#tissue-table-body").html('');
                            $("#tissue-table-body").html(results);
                        },
                        error:function(){
                            alert("failure");
                        }
                    });                  
                }

               // update_tissue_view();

            /*    $("#protein-back").on( "click", function() {
                  if ($("#protein-page").data("page") != 0)
                  {
                    $("#protein-page").data("page", $("#protein-page").data("page")- 10);
                    update_protein_view();
                  }
                });

                $("#protein-forward").on( "click", function() {
                  $("#protein-page").data("page", $("#protein-page").data("page")+ 10);
                  update_protein_view();
                });*/

              });
              </script>    
          <div  id="protein-table">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Protein Name</th>
                    <th>Type/Domain</th>
                    <th>Gain of Function Interactions</th>
                    <th>Loss of Function Interactions</th>
                    <th>Total Variants</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <tbody id="protein-table-body">
                </tbody>
              </table>

              <script>
              $(function() {
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
                $("#pwm-page").data("page", $("#pwm-page").data("page")- 10);
                    update_pwm_view();
                });

                $("#pwm-forward").on( "click", function() {
                  $("#pwm-page").data("page", $("#pwm-page").data("page")+ 10);
                  update_pwm_view();
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
                    <th>Logo</th>
                    <th>File</th>
                  </tr>
                </thead>
                <tbody id="pwm-table-body">
                                   
                </tbody>
              </table>

              <ul class="pager" id="pwm-page" data-page=0>
                <li><a id="pwm-back">Previous</a></li>
                <li><a id="pwm-forward">Next</a></li>
              </ul>

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