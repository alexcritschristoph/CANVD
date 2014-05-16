<html>
	<head>
		<title>
			Cancer Network Alterting Variant Database
		</title>
		<link href="./bootstrap.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<style>
			#browse-tabs{
				margin-top:15px;
			}

			h1 a{
				text-decoration: none;
				color:rgb(34, 34, 34);;
			}
			h1 a:hover{
				text-decoration: none;
				color:rgba(33, 33, 33, 0.8);
			}
		</style>
	</head>

	<body style="background:#fafafa">
	<div class="jumbotron" style="margin-bottom:0px;height:100%">
	  <div class="container">
	    <h1><a href="#">The Cancer Network Altering Variant Database</a></h1>
	    <p class="pull-right" style="margin-left:10px;margin-top:5px;"><a class="btn btn-danger" role="button"><i class="fa fa-flask"></i> About </a>
	    <a class="btn btn-default" role="button"><i class="fa fa-question"></i> FAQs</a>
	    <a class="btn btn-default" role="button"><i class="fa fa-envelope-o"></i> Contact</a>
	    </p>
	    <p>The effects of over 800,000 missense mutations are analyzed and stored in the Cancer Network Altering-Variant Database (CAN-VD). CAN-VD stores the PPI interactions mediated by wildtype and variant protein sequences to build and compare the PPI network in the two conditions and understand the effects of mutations on the network and, consequently, the cellular and biological functions of the cancer system.</p>

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
		    <div class="input-group input-group-lg">
			  <input type="search" class="form-control" placeholder="enter a protein name, cancer type, or tissue type.">
			  <span class="input-group-btn">
		        <button class="btn btn-danger" type="button">Search</button>
		      </span>
			</div>

			<ul class="nav nav-tabs" id="browse-tabs">
			  <li class="active"><a href="#">Proteins</a></li>
			  <li><a href="#">Cancer Types</a></li>
			  <li><a href="#">Tumor Tissue</a></li>
			</ul>

			<table class="table table-striped table-hover ">
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
		<div style="padding-top:50px;margin-bottom:15px;font-size:0.8em;font-style:italic;background:#fafafa;">Developed by Alex Crits-Christoph as part of Google Summer of Code under guidance of Dr. Mohamed Helmy. The CAN-VD database was developed by Mohamed Helmy in the Bader Lab at University of Toronto.</div>

	</div>

	</div>
	</body>

</html>