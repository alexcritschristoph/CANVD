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
    <p class="pull-right" style="margin-left:10px;margin-top:25px;"><a class="btn btn-danger" id="test" href="<?php echo $root_path;?>variants" role="button"><i class="fa fa-flask"></i> Variants </a>
      <a class="btn btn-default" href="<?php echo $root_path;?>faqs" role="button"><i class="fa fa-question"></i> About</a>
      <a class="btn btn-default" href="<?php echo $root_path;?>contact" role="button"><i class="fa fa-envelope-o"></i> Contact</a>
      </p>
      <h1><a href="<?php echo $root_path;?>"><span style="color:#ea2f10">Can-VD</span>: The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase</a></h1>
      <p><h2 style="margin-bottom:30px;"> Frequently Asked Questions about CANVD</h2></p>

      <p><b>Integer interdum, tellus et vehicula dictum</b></p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque blandit sagittis. Aenean porttitor porta velit sed consequat. Phasellus gravida commodo massa. Etiam faucibus dui vitae dui tristique sodales. Aenean posuere dui vulputate consectetur tincidunt. Nam aliquam quam neque, vitae posuere augue tristique a. Ut aliquam, elit tempor aliquam consectetur, augue eros malesuada nisi, sed rhoncus nibh ante eget velit. Maecenas in feugiat magna. Quisque quam augue, gravida eget nisl scelerisque, malesuada sagittis dolor. Curabitur adipiscing neque mi, euismod dictum est facilisis in.</p>
	    <p><b>Duis elit dui, suscipit eu volutpat at, elementum vitae lorem.</b></p>
      <p>Pellentesque ut sem condimentum, varius massa congue, fermentum nunc. Fusce laoreet vitae massa eget tempus. Nunc placerat, eros dictum sodales fringilla, risus elit laoreet quam, eu venenatis sem massa sit amet tortor. Aenean tristique imperdiet ante at viverra. Vestibulum eget commodo nisi, ac pharetra dui. Maecenas in mauris sit amet lacus laoreet dapibus. Vivamus in nibh vel nunc laoreet viverra non rhoncus dolor. Ut arcu enim, rhoncus eu bibendum vel, tristique id enim.</p>
    </div>
	<div class="container">
	
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
        { data: { source: 'j', target: 'e', type: 'dashed', func:'#388f58' } },
        { data: { source: 'j', target: 'k', type: 'dashed', func:'#388f58' } },
        { data: { source: 'j', target: 'g', func:'#388f58', func: '#dc2c0f' }  },

        { data: { source: 'e', target: 'j', func:'#39b3d7' }  },
        { data: { source: 'e', target: 'k', type: 'dashed', func:'#388f58' } },

        { data: { source: 'k', target: 'j' , func:'#39b3d7'}  },
        { data: { source: 'k', target: 'e', type: 'dashed', func: '#dc2c0f' } },
        { data: { source: 'k', target: 'g', type: 'dashed', func: '#dc2c0f' } },

        { data: { source: 'g', target: 'j' , func:'#39b3d7' } }
      ],
    },

    ready: function(){
      cy = this;
    }
  };

  $('#cy').cytoscape(options);

});
	</script>
	</body>

</html>