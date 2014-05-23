<?php
  $root_path = "../";
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
	    <h1><a href="<?php echo $root_path;?>"><span style="color:#ea2f10">CAN-VD</span>: The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariant <span style="color:#ea2f10">D</span>atabase</a></h1>
	    <p class="pull-right" style="margin-left:10px;margin-top:5px;"><a class="btn btn-danger" href="<?php echo $root_path;?>about" role="button"><i class="fa fa-flask"></i> About </a>
	    <a class="btn btn-default" href="<?php echo $root_path;?>faqs" role="button"><i class="fa fa-question"></i> FAQs</a>
	    <a class="btn btn-default" href="<?php echo $root_path;?>contact" role="button"><i class="fa fa-envelope-o"></i> Contact</a>
	    </p>
	    <p>The effects of over 800,000 missense mutations are analyzed and stored in the <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariant <span style="color:#ea2f10">D</span>atabase (CAN-VD).</p>

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

		<div class="col-md-8" style="padding-right:0;">
		    	<div id="cy"></div>
		</div>
    <div class="col-md-2" style="padding:0;margin:0;">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title stats-title">Network Statistics</h3>
          </div>
          <div class="panel-body stats-body">
            <p><b>6</b> total proteins</p>
            <p><b>3</b> total mutations</p>
            <p><b>2</b> tumor types</p>
            <p><b>1</b> interaction domain</p>
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
	$(loadCy = function(){

  options = {
  	name: 'circle',
    showOverlay: true,
    minZoom: 0.5,
    maxZoom: 2,
    fit:true,

    style: cytoscape.stylesheet()
      .selector('node')
        .css({
          'background-color': '#c4c4c4',
          'content': 'data(name)',
          'font-family': 'helvetica',
          'font-size': 14,
          'text-valign': 'center',
          'color': '#0b1a1e',
          'width': 'mapData(weight, 30, 80, 20, 50)',
          'height': 'mapData(height, 0, 200, 10, 45)',
          'border-color': '#fff'
        })
      .selector(':selected')
        .css({
          'background-color': '#f04124',
          'line-color': '#000',
          'target-arrow-color': '#000',
          'text-outline-color': '#000'
        })
      .selector('edge')
        .css({
          'width': 2,
          'line-color': 'data(func)',
          'line-style': 'data(type)',
          'target-arrow-shape': 'triangle'
        })
    ,

    elements: {
      nodes: [
        {
          data: { id: 'j', name: 'ProtJ', weight: 65, height: 150 }
        },

        {
          data: { id: 'e', name: 'ProtE', weight: 65, height: 150 }
        },

        {
          data: { id: 'k', name: 'ProtK', weight: 65, height: 150 }
        },

        {
          data: { id: 'g', name: 'ProtG', weight: 65, height: 150 }
        }
      ],

      edges: [
        { data: { source: 'j', target: 'e', feature: "mut", type: 'dashed', func:'#388f58' } },
        { data: { source: 'j', target: 'k', feature: "mut", type: 'dashed', func:'#388f58' } },
        { data: { source: 'j', target: 'g', func:'#388f58', func: '#dc2c0f' }  },

        { data: { source: 'e', target: 'j', func:'#39b3d7' }  },
        { data: { source: 'e', target: 'k', feature: "mut", type: 'dashed', func:'#388f58' } },

        { data: { source: 'k', target: 'j' , func:'#39b3d7'}  },
        { data: { source: 'k', target: 'e', feature: "mut", type: 'dashed', func: '#dc2c0f' } },
        { data: { source: 'k', target: 'g', feature: "mut", type: 'dashed', func: '#dc2c0f' } },

        { data: { source: 'g', target: 'j' , func:'#39b3d7' } }
      ],
    },

    ready: function(){
      cy = this;
      cy.userZoomingEnabled(0);
    }
  };

  $('#cy').cytoscape(options);

});
	</script>
	</body>

</html>