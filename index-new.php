<?php
	$root_path = "./";
  include_once('./common.php');

  //Generate sitewide database statistics
  include_once('./generate_stats.php');
?>

<html>
	<head>
		<title>
			Cancer Variants Database :: Main
		</title>
		<link rel="shortcut icon" href="canvd.ico">
		<link href="<?php echo $root_path;?>bootstrap.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
		<script src="<?php echo $root_path;?>site.js" ></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $root_path;?>styles.css">
    <link href="./slider.css" rel="stylesheet">
    <script src="<?php echo $root_path;?>bootstrap.js"></script>
    <script src="./bootstrap-slider.js"></script>
    <script src="Chart.js"></script>
	</head>

	<body style="background:#fafafa">
	
	<div class="jumbotron" style="margin-bottom:0px;height:100%">
	  <div class="container">
	    <h1 id="title_h1" align="center"><a href="<?php echo $root_path;?>"><span style="color:#ea2f10">Can-VD</span>: The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase</a></h1>
	    </div>
	     <div class="container">
	     <p id="top_btns" align="center">
	     <a class="btn btn-danger" href="<?php echo $root_path;?>variants" role="button"><i class="fa fa-flask"></i> Variants </a>&nbsp;&nbsp;&nbsp;
	     <a class="btn btn-default" href="<?php echo $root_path;?>downloads" role="button"><i class="fa fa-download"></i> Downloads</a>&nbsp;&nbsp;&nbsp;
	     <a class="btn btn-default" href="<?php echo $root_path;?>faqs" role="button"><i class="fa fa-question"></i> About</a>&nbsp;&nbsp;&nbsp;
      	 <a class="btn btn-default" href="<?php echo $root_path;?>contact" role="button"><i class="fa fa-envelope-o"></i> Contact</a>
      </p>
	    <p align="justify">The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase (<span style="color:#ea2f10">Can-VD</span>) is an online resource for the assessment of the impact of cancer mutations on protein-protein interactions (PPI) networks. <a href='faqs/'>Read more...</a></p>
	  <div class="container">
	  <br>
	  <div class="container">
	
	</body>

</html>
