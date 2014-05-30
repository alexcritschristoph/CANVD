<?php
  $root_path = "../";
  include_once('../common.php');
?>

<html>
	<head>
		<title>
			Cancer Variants Database
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
	    <h1><a href="<?php echo $root_path;?>"><span style="color:#ea2f10">CAN-VD</span>: The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase</a></h1>
	    <p class="pull-right" style="margin-left:10px;margin-top:5px;"><a class="btn btn-danger" href="<?php echo $root_path;?>about" role="button"><i class="fa fa-flask"></i> About </a>
	    <a class="btn btn-default" href="<?php echo $root_path;?>faqs" role="button"><i class="fa fa-question"></i> FAQs</a>
	    <a class="btn btn-default" href="<?php echo $root_path;?>contact" role="button"><i class="fa fa-envelope-o"></i> Contact</a>
	    </p>
	    <p>The effects of over 800,000 missense mutations are analyzed and stored in the <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase (CAN-VD).</p>

	  </div>
	<div class="container">
	<div class="row">
		<div class="col-md-2">
			<ul class="nav nav-pills">
			  <li id="filters_li" class="active"><a href="#" id="filters_btn">Filters</a></li>
			  <li id="downloads_li"><a href="#" id="downloads_btn">Download</a></li>
			</ul>
      <div id="filters_panel">
			<table class="table table-striped table-hover ">
        <thead>
          <tr>
            <th>Tissues</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Example 1<i class="fa fa-check pull-right" style="padding-top:3px;color:#43ac6a;"></i></td>
          </tr>
          <tr>
            <td>Example 2<i class="fa fa-check pull-right" style="padding-top:3px;color:#43ac6a;"></i></td>
          </tr>
          <tr>
            <td>Example 3<i class="fa fa-check pull-right" style="padding-top:3px;color:#43ac6a;"></i></td>
          </tr>
          <tr>
            <td>Example 4<i class="fa fa-check pull-right" style="padding-top:3px;color:#43ac6a;"></i></td>
          </tr>
        </tbody>
      </table>

      <table class="table table-striped table-hover ">
        <thead>
          <tr>
            <th>Cancers</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Example 1<i class="fa fa-check pull-right" style="padding-top:3px;color:#43ac6a;"></i></td>
          </tr>
          <tr>
            <td>Example 2<i class="fa fa-check pull-right" style="padding-top:3px;color:#43ac6a;"></i></td>
          </tr>
          <tr>
            <td>Example 3<i class="fa fa-check pull-right" style="padding-top:3px;color:#43ac6a;"></i></td>
          </tr>
          <tr>
            <td>Example 4<i class="fa fa-check pull-right" style="padding-top:3px;color:#43ac6a;"></i></td>
          </tr>
        </tbody>
      </table>

      <table class="table table-striped table-hover ">
        <thead>
          <tr>
            <th>Data Sources</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Source 1<i class="fa fa-check pull-right" style="padding-top:3px;color:#43ac6a;"></i></td>
          </tr>
          <tr>
            <td>Source 2<i class="fa fa-check pull-right" style="padding-top:3px;color:#43ac6a;"></i></td>
          </tr>
        </tbody>
      </table>
      </div>
      <div id="downloads_panel">
      <p style="font-size:1.2em;">There are multiple formats in which the data in the current view can be downloaded.</p>
      <div class="list-group">
        <span class="list-group-item download-list" style="background:#d6d6d6">Download as:</span>
        <a href="#" class="list-group-item">Raw Data Format (CSV)</a>
        <a href="#" class="list-group-item">Cytoscape Readable File</a>
        <a href="#" class="list-group-item">MySQL Data</a>
      </div>
      </div>
		</div>

		<div class="col-md-8" id="main_network_column" style="padding-right:0;">
		    	<div id="cy"></div>
		</div>
    <div class="col-md-2" style="padding:0;margin:0;">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title stats-title">Network Statistics</h3>
          </div>
          <div class="panel-body stats-body">
            <p><b id="prot_c"></b> total proteins</p>
            <p><b id="mut_c"></b> total mutations</p>
            <p><b id="tumor_c"></b> tumor types</p>
            <p><b></b> interaction domain</p>
          </div>
        </div>
        <div class="list-group show-list">
          <span class="list-group-item"><b>Networks</b></span>
          <a class="list-group-item show-item w-prot"><span data-color="alert-info" class="badge alert-info">14</span>Wildtype Proteins </a>
          <a class="list-group-item show-item m-prot"><span data-color="alert-danger" class="badge alert-danger">14</span> Mutant Proteins </a>
          <a class="list-group-item show-item w-int"><span data-color="alert-info" class="badge alert-info">14</span>Wildtype Interactions </a>
          <a class="list-group-item show-item m-int"><span data-color="alert-danger" class="badge alert-danger">14</span>Mutant Interactions </a>
        </div>
        <div class="list-group show-list">
          <span class="list-group-item"><b>Mutation Type</b></span>
          <a class="list-group-item show-item g-prot"><span data-color="alert-success" class="badge alert-success">14</span>Gain of Function </a>
          <a class="list-group-item show-item l-prot"><span data-color="alert-warning" class="badge alert-warning">14</span> Loss of Function </a>
        </div>
    </div>
	</div>
  <?php
      include $root_path. 'footer.php';
    ?>

	</div>

	</div>

  <script>
  $(function() {

  <?php
  //Generate network data
  include_once('../search.php');
  ?>

  if (protein_count == "1"){
    $("#main_network_column").prepend("<div class=\"alert alert-warning\" style='margin-right:50px;margin-left:50px;'><p class='lead' style='color:white;'>Error: That protein was not found in the database.</p></div>");
  }
  else{
      $("#prot_c").text(protein_count);
      $("#mut_c").text(mutation_count);
      $("#tumor_c").text(tumor_count);

  }

  //Create list of nodes
  var net_nodes = [];
  net_nodes.push({ data: { id: target_protein, name: target_protein, weight: 65, }} )
  for(net in networkData) 
  { 
    for (n in networkData[net])
    
    {
      net_nodes.push( { data: { id: n, name: n, weight: 65, }} );
    }

  }

  //Create list of edges
  var net_edges = [];
  for(net in networkData) 
  { 
    for (n in networkData[net])
    {
      net_edges.push( { data: { source: target_protein, target: n, feature: "mut", type: 'solid', func:'#6FB1FC' } });
    }
  }

	$(loadCy = function(){

  options = {
    layout: { name: "random" },
  	name: 'circle',
    showOverlay: true,
    minZoom: 0.5,
    maxZoom: 2,
    fit:true,

    style: cytoscape.stylesheet()
      .selector('node')
        .css({
          'background-color': '#292929',
          'content': 'data(name)',
          'font-size': 10,
          'text-valign': 'center',
          'color': 'white',
          'text-outline-color': '#292929',
          'text-outline-width':'2',
          'height': '20',
          'width':'20',
          'border-color': '#fff'
        })
      .selector(':selected')
        .css({
          'background-color': '#a8a8a8',
          'text-outline-color': '#c4c4c4',
          'background-opacity':'0.5',
          'text-outline-opacity':'0',
          'line-color': '#000',
          'target-arrow-color': '#000',
          'border-color':'hsla(0, 84%, 54%, 0.77)',
          'border-opacity':'0.5',
          'border-width':'2',
        })
      .selector('edge')
        .css({
          'width': 3,
          'line-color': 'data(func)',
          'line-style': 'data(type)',
          'opacity':'0.3',
          'target-arrow-shape': 'triangle',
          'target-arrow-color': 'data(func)'
        })
    ,

    elements: {
      nodes: net_nodes,

      edges: net_edges,

      /*[
        { data: { source: 'j', target: 'e', feature: "mut", type: 'dashed', func:'hsla(37, 98%, 46%, 0.69)' } },
        { data: { source: 'j', target: 'k', feature: "mut", type: 'dashed', func:'#f04124' } },
        { data: { source: 'j', target: 'g', func:'hsla(37, 98%, 46%, 0.69)', func: 'hsla(37, 98%, 46%, 0.69)' }  },

        { data: { source: 'e', target: 'j', func:'#5bc0de' }  },
        { data: { source: 'e', target: 'k', feature: "mut", type: 'dashed', func:'hsla(37, 98%, 46%, 0.69)' } },

        { data: { source: 'k', target: 'j' , func:'#5bc0de'}  },
        { data: { source: 'k', target: 'e', feature: "mut", type: 'dashed', func: '#f04124' } },
        { data: { source: 'k', target: 'g', feature: "mut", type: 'dashed', func: '#f04124' } },

        { data: { source: 'g', target: 'j' , func:'#39b3d7' } }
      ],*/
    },

    ready: function(){
      cy = this;
      cy.userZoomingEnabled(0);
    }
  };

  $('#cy').cytoscape(options);


});
});
	</script>
	</body>

</html>