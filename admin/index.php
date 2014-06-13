<?php
  $root_path = "../";
  include_once($root_path . './common.php');
  session_start();
?>

<html>
	<head>
		<title>
			Cancer Variant Database: Admin
		</title>
		<link href="<?php echo $root_path;?>bootstrap.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
    <script src="<?php echo $root_path;?>site.js" ></script>
		<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $root_path;?>styles.css">
    <style>

    .admin-table-item:hover{
      cursor:pointer;
      *:focus {
    }
    outline: 0;
}
  .btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 999px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
    </style>
	</head>

	<body style="background:#fafafa;">
	<div class="jumbotron" style="margin-bottom:0px;height:100%">
	  <div class="container" style="margin-bottom:15px;">
	    <h1><a href="<?php echo $root_path;?>"><span style="color:#ea2f10">CAN-VD</span>: The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariant <span style="color:#ea2f10">D</span>atabase</a></h1>
	    <p class="pull-right" style="margin-left:10px;margin-top:5px;"><a class="btn btn-danger" href="<?php echo $root_path;?>about" role="button"><i class="fa fa-flask"></i> About </a>
	    <a class="btn btn-default" href="<?php echo $root_path;?>faqs" role="button"><i class="fa fa-question"></i> FAQs</a>
	    <a class="btn btn-default" href="<?php echo $root_path;?>contact" role="button"><i class="fa fa-envelope-o"></i> Contact</a>
	    </p>

    <?php
        $failure = false;
        $error = '';
        if (isset($_POST['username']))
        {
          $query = 'SELECT password
          FROM admin
          WHERE username = :usr;';

          $query_params = array(':usr' => $_POST['username']);
          $stmt = $dbh->prepare($query);
          $stmt->execute($query_params);
          $pass = $stmt->fetch()[0];
          //check password
          if (password_verify($_POST['password'],$pass))
          {
            $_SESSION['user']=$_POST['username'];
          }

          else
          {
            $failure = true;
            $error = "<div class=\"alert alert-warning\" style='margin-right:450px;margin-left:50px;'><p class='lead' style='color:white;'>Error: Wrong Username or Password.</p></div>";
          }
        }

        else 
        {
          $failure = true;
        }

        if ($failure)
        {
          if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin')
          {
            $failure = false;
          }
        }
        if ($failure)
        {
          echo $error;
          ?>

            <form class="form-signin" role="form" action="../admin/" method="post">
              <h2 class="form-signin-heading">Please sign in</h2>

              <input type="input" name="username" style="margin-left:120px;margin-top:40px;margin-bottom:20px;width:300px;" class="input-group" placeholder="Username" required autofocus>
              <input type="password" name="password" style="margin-left:120px;margin-top:20px;margin-bottom:20px;width:300px;" class="input-group input-group-lg" placeholder="Password" required>
              <button class="btn btn-md btn-primary" style="margin-top:20px;margin-left:200px;" type="submit">Sign in</button>
            </form>
          <?php
        }
        else
        {
?>
            <form action="../logout.php" method="post">
                      <button class="btn btn-md btn-info pull-right" type="submit" style="margin-top:5px;">Log out</button>
            </form>
                          <h2 style="margin-top:20px;"> CANVD Administration Panel </h2>

                          <div class="row" style="margin-top:50px;">
                            <div class="col-md-3">
                              <div class="list-group" id="admin-list">
                                <div class="list-group-item" style="background:#f5f5f5;color:black;font-size:1.1em;">
                                  CANVD Tables:
                                </div>
                                <?php
                                $query = 'SHOW TABLES;';

                                  //Parametized SQL prevents SQL injection
                                  $query_params = array();
                                  $stmt = $dbh->prepare($query);
                                  $stmt->execute($query_params);
                                  while ($row = $stmt->fetch())
                                  {
                                    if(substr( $row[0], 0, 1 ) === 'T')
                                  {
                                ?>
                                <a class="list-group-item admin-table-item">
                                  <?php 
                                  
                                    echo $row[0]; 
                                  ?>
                                </a>
                                <?php
                                  }
                                  }
                                ?>

                                <script>
                                $(function() {

                                  $("#admin-list").on( "click", "a", function() {
                                    $("#table-name-header").text($(this).text());
                                    $("#panel-content").show();
                                  });

                                  $(document).on('change', '.btn-file :file', function() {
                                      var input = $(this),
                                          numFiles = input.get(0).files ? input.get(0).files.length : 1,
                                          label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                                      input.trigger('fileselect', [numFiles, label]);
                                  });

                                  $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
                                      console.log(numFiles);
                                      console.log(label);
                                      $(".btn-file").text(label);
                                  });
                                });
                                  </script>
                              </div>
                              </div>
                              <div class="col-md-8">
                              <div class="panel panel-default">
                                <div class="panel-heading" id="table-name-header">Select A Table To The Left....</div>
                                <div class="panel-body">
                                  <div id="panel-content" style="display:none"> <!-- style="display:none"-->
                                    <p id="table-name"></p>
                                    <p>
                                    <p>Note: To upload data to CANVD, files must be tab separated text files with the appropriate column structure
                                    needed for each table.</p>

                                    <form action="upload_text.php" method="post"
                                    enctype="multipart/form-data">
                                    <label for="file">Select a Text File to upload:</label>
                                    <input type="file" name="file" id="file"><br>
                                    <div data-toggle="buttons" style="margin-top:5px;">
                                        <label>
                                            <input type="radio" name="action" value="add" checked>
                                        Add this data to the table </label>
                                        <label>
                                            <input type="radio" name="action" value="replace">
                                        Replace the ENTIRE table with this data </label>
                                    </div>

                                    <button class="btn btn-md btn-success" style="margin-top:15px;margin-left:200px;" type="submit">Submit</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                              </div>
                          </div>
<?php
        }
    ?>


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