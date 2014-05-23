<?php
	$root_path = "./";
?>

<html>
	<head>
		<title>
			Cancer Variant Database
		</title>
		<link href="<?php echo $root_path;?>bootstrap.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
		<script src="<?php echo $root_path;?>site.js" ></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $root_path;?>styles.css">

	</head>

	<body style="background:#fafafa">
	<div class="jumbotron" style="margin-bottom:0px;height:100%">
	  <div class="container">
	    <h1><a href="<?php echo $root_path;?>"><span style="color:#ea2f10">CAN-VD</span>: The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariant <span style="color:#ea2f10">D</span>atabase</a></h1>
	    <p class="pull-right" style="margin-left:10px;margin-top:5px;"><a class="btn btn-danger" href="<?php echo $root_path;?>about" role="button"><i class="fa fa-flask"></i> About </a>
	    <a class="btn btn-default" href="<?php echo $root_path;?>faqs" role="button"><i class="fa fa-question"></i> FAQs</a>
	    <a class="btn btn-default" href="<?php echo $root_path;?>contact" role="button"><i class="fa fa-envelope-o"></i> Contact</a>
	    </p>
	    <p>The effects of over 800,000 missense mutations are analyzed and stored in the <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariant <span style="color:#ea2f10">D</span>atabase (CAN-VD). CAN-VD stores the PPI interactions mediated by wildtype and variant protein sequences to build and compare the PPI network in the two conditions and understand the effects of mutations on the network and, consequently, the cellular and biological functions of the cancer system.</p>

	  </div>
	<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="list-group">
			  <a href="#" class="list-group-item active">
			    All Proteins (3000)
			  </a>
			  <a href="#" class="list-group-item">Matching hits (5)</a>
			  <a href="#" class="list-group-item">Selected proteins (3)</a>			  
			  <a href="#" class="list-group-item">View Network</a>
			</div>
		</div>

		<div class="col-md-9">
		    <form id="search_form" class="input-group input-group-lg" action="./network/" method="post">
			  <input type="search" id="search_input" class="form-control" placeholder="enter a protein name, cancer type, or tissue type.">
			  <span class="input-group-btn">
		        <input type="submit" class="btn btn-danger" type="button" id="search_btn">Search</input>
		      </span>
			</form>

			<ul class="nav nav-tabs" id="browse-tabs">
			  <li class="active"><a data-tab="protein">Proteins</a></li>
			  <li><a data-tab="cancer">Cancer Types</a></li>
			  <li><a data-tab="tumor">Tumor Tissue</a></li>
			</ul>

			<table class="table table-striped table-hover" id="prots-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Protein Name</th>
                    <th>Mutations</th>
                    <th>Interaction Partners</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>6</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                </tbody>
              </table>

              <table class="table table-striped table-hover" id="cancer-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Cancer Type</th>
                    <th>Number of Proteins</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>                  
                </tbody>
              </table>

              <table class="table table-striped table-hover" id="tissue-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tissue Type</th>
                    <th>Number of Proteins</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>                  
                </tbody>
              </table>
          <ul class="pagination">
			  <li><a href="#">&laquo;</a></li>
			  <li class="active"><a href="#">1</a></li>
			  <li><a href="#">2</a></li>
			  <li><a href="#">3</a></li>
			  <li><a href="#">4</a></li>
			  <li><a href="#">5</a></li>
			  <li><a href="#">&raquo;</a></li>
		  </ul>
		</div>
	</div>
		<?php
      		include $root_path. 'footer.php';
		?>

	</div>

	</div>
	</body>

</html>