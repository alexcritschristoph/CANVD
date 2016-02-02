<head>
		<title>
			Cancer Variants Database :: Main
		</title>
		<link rel="shortcut icon" href="canvd.ico">
		<link href="<?php echo $root_path;?>bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
		<script src="<?php echo $root_path;?>site.js" ></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $root_path;?>styles.css">
        <script src="<?php echo $root_path;?>bootstrap.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo $root_path;?>jquery.qtip.css" />
        <script type="text/javascript" src="<?php echo $root_path;?>jquery.qtip.js"></script>
        <script src="<?php echo $root_path;?>cytoscape.min.js"></script>
        <script src="https://cdn.rawgit.com/cytoscape/cytoscape.js-qtip/master/cytoscape-qtip.js"></script>

    <style>
        .footer {
            z-index: 1;
            display: block;
            font-size: 26px;
            font-weight: 200;
            text-shadow: 0 1px 0 #fff;
        }

        svg {
            overflow: hidden;
        }

        rect {
            pointer-events: all;
            cursor: pointer;
            stroke: #EEEEEE;
        }

        .chart {
            display: block;
            margin: auto;
        }

        .label {
            stroke: 'white';
            fill: 'white';
            stroke-width: 0;
            margin: 2px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .parent .label {
            font-size: 12px;
            stroke: 'white';
            fill: 'white';
        }

        .child .label {
            font-size: 11px;
        }

        .cell {
            font-size: 11px;
            cursor: pointer
        }


    </style>
	</head>

	<body style="background:#fafafa">
	<div class="jumbotron" style="margin-bottom:0px;height:100%">
	  <div class="container" >
          <span id="title_fix"></span>
	    <h1 id="title_h1" style="margin-bottom:0px;padding-bottom:0px;margin-top:15px;" align="center"><a href="../"><span style="color:#ea2f10">Can-VD</span>: The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase</a></h1>
    <p id="top_btns" style="margin-bottom:20px;margin-top:15px;" align="center">
<a class="btn btn-danger" href="../" role="button"><i class="fa fa-home"></i> Home </a>&nbsp;&nbsp;&nbsp;
<a class="btn btn-default" href="../variants" role="button"><i class="fa fa-flask"></i> Variants </a>&nbsp;&nbsp;&nbsp;
<a class="btn btn-default" href="../datasets" role="button"><i class="fa fa-database"></i> Datasets</a>&nbsp;&nbsp;&nbsp;
<a class="btn btn-default" href="../deposit" role="button"><i class="fa fa-upload"></i> Deposition</a>&nbsp;&nbsp;&nbsp;
<a class="btn btn-default" href="../faqs" role="button"><i class="fa fa-question"></i> About</a>&nbsp;&nbsp;&nbsp;
<a class="btn btn-default" href="../contact" role="button"><i class="fa fa-envelope"></i> Contact</a>&nbsp;&nbsp;&nbsp;
      </p>
