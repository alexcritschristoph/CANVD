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
    <link type="text/css" rel="stylesheet" href="<?php echo $root_path;?>jquery.qtip.css" />
    <script type="text/javascript" src="<?php echo $root_path;?>jquery.qtip.js"></script>

    <script src="<?php echo $root_path;?>site.js" ></script>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>
    <script src="https://rawgit.com/cytoscape/cytoscape.js-qtip/master/cytoscape.js-qtip.js"></script>
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

      <p id="main-top-text">The effects of over 800,000 missense mutations are analyzed and stored in the <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase (<span style="color:#ea2f10">Can-VD</span>).</p>

    </div>
  <div class="test" id="network-selection-container" >
  </div>
  <div class="container" id="network-view-container">
  <div class="row">
    <div class="col-md-2">
      <ul class="nav nav-pills">
        <li id="filters_li" class="active"><a href="#" id="filters_btn">Filters</a></li>
        <li id="downloads_li"><a href="#" id="downloads_btn">Download</a></li>
      </ul>
      <div id="filters_panel">
      <p style="font-size:0.9em;margin-bottom:6px;padding-bottom:0;">Viewing <span id="prot_c_2"></span> out of <span id="prot_c_total"></span> total interactions. </p>
      <div class="btn btn-default btn-sm" style="margin-bottom:10px;" id="show_more"> Show more interactions</div>
      <div class="btn btn-default btn-sm" style="margin-bottom:10px;" id="show_all"> Show all interactions</div>
      <table class="table table-striped table-hover ">
        <thead>
          <tr>
            <th>Tissues</th>
          </tr>
        </thead>
        <tbody id="tissues_filter_table">
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
            <td id="cosmic-id">COSMIC <span  id="cosmic-placeholder" data-color='alert-success' class='badge alert-success pull-right'></span></td>
          </tr>

        </tbody>
      </table>
      </div>
      <div id="downloads_panel">
      <p style="font-size:1.2em;">There are multiple formats in which the data in the current view can be downloaded.</p>
      <div class="list-group">
        <span class="list-group-item download-list" style="background:#d6d6d6">Download view as:</span>
        <a href="#" class="list-group-item json-download">Raw JSON Data</a>
        <a href="#" class="list-group-item csv-download">Text Data (CSV)</a>
      </div>

      <div class="list-group">
        <span class="list-group-item download-list" style="background:#d6d6d6">Download ALL interaction data:</span>
        <a href="#" class="list-group-item csv-download-all">Text Data (CSV)</a>
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
            <p>Viewing <b id="prot_c"></b> proteins</p>
            <p>Viewing <b id="mut_c"></b> mutations</p>
            <p>Viewing <b id="tumor_c"></b> tumor types</p>
            <p><b>1</b> interaction domain:</p>
            <p><b id="prot-name">Test</b>: <i id="prot-id">Testing</i></p>            
          </div>
        </div>
        <div class="list-group show-list">
          <span class="list-group-item"><b>Networks</b></span>
          <a class="list-group-item show-item w-prot w-int"><span data-color="alert-info" class="badge alert-info">14</span>Wildtype Proteins </a>
          <a class="list-group-item show-item m-prot m-int"><span data-color="alert-warning" class="badge alert-warning">14</span> Mutant Proteins </a>
        </div>
        <div class="list-group show-list">
          <span class="list-group-item"><b>Mutation Type</b></span>
          <a class="list-group-item show-item g-prot no-int"><span data-color="alert-info" class="badge alert-info">14</span>No Change </a>
          <a class="list-group-item show-item g-prot gain-int"><span data-color="alert-success" class="badge alert-success">14</span>Gain of Interaction </a>
          <a class="list-group-item show-item l-prot loss-int"><span data-color="alert-danger" class="badge alert-danger">14</span> Loss of Interaction </a>
        </div>
        <div class="list-group show-list">
          <span class="list-group-item"><b>Layout Options</b></span>
          <a class="list-group-item layout-select show-item active">Circle</a>
          <a class="list-group-item layout-select show-item">Grid</a>          

        </div>
    </div>
  </div>
  <?php
      include $root_path. 'footer.php';
    ?>

  </div>

  </div>

  <script src="<?php echo $root_path;?>bootstrap.js"></script>

  <script>
  $(function() {

  <?php

  //Visible node count
  if (isset($_GET['limit']))
  {
  ?>
  var net_limit = <?php echo $_GET['limit'];?>;
  <?php
  }
  else{?>
  var net_limit = 100;
    <?php
  }

  //Generate network data
  include_once('../search.php');

  ?>

  var net_nodes = [];
  var net_edges = [];
  var protein_count1;
  var protein_total1;
  var mutation_count1;
  var protein_total_count;
  var tumor_count1;
  var networkData;
  var target_protein1;
  var target_ids1;

  $("#show_more").on("click", function(){
    $("#show_more").html("<div class='spinner2'><div class='cube1'></div><div class='cube2'></div></div>");
    net_limit = net_limit + 100;
    var new_url = window.location.href.replace("&limit", "&oldlimit") + "&limit=" + net_limit;
    window.location.href = new_url
  });

  $("#show_all").on("click", function(){
    $("#show_all").html("<div class='spinner2'><div class='cube1'></div><div class='cube2'></div></div>");
    net_limit = net_limit + 100;
    var new_url = window.location.href.split("&")[0] + "&limit=" + net_limit;
    window.location.href = new_url
  });


  //for each protein, display
  if (all_proteins.length > 1)
  {
  $("#network-view-container").hide();
  $("#network-view-container").prepend("<button class='btn btn-primary btn-sm' id='protein-selection-btn' style='margin-bottom:10px;'>Choose network to display</button>");
    $("#network-selection-container").html("<div class=\"row\"> <div class=\"col-md-12\" style='padding-left:50px;padding-right:50px;'><h4 style='padding-right:30px;'>Several SH3 domain containing proteins were found. Select one to view the network:</h4><table class='table table-striped table-hover'><thead><tr><th>Protein Name</th><th>Total Number of Interaction Partners for this Protein</th><th>Total Number of Mutations for this Protein</th></tr></thead><tbody id='protein-choice-list'></tbody></table></div></div>");
    for (var i = 0; i < all_proteins.length; i++) {
        var keys = [];
        var keystring = "";
        var j = 0;
        for(var k in networkData1[i]) {
          if (j > 0) {
          keys.push(k);
          keystring = keystring+ ", " + k;

          }
          else{
          keys.push(k);
          keystring = k;
          }
          j += 1
        }
        $("#protein-choice-list").append("<tr><td><span style='font-size:1.6em'>" + all_proteins[i].charAt(0).toUpperCase() + all_proteins[i].slice(1) + "</span></td><td>"+total_count[i]+"</td><td>" + mutation_count[i] + "</td>")
    }


  }

  else
  {
    networkData = networkData1[0];
    protein_count1 = protein_count[0];
    protein_total1 = protein_total[0];
    mutation_count1 = mutation_count[0];
    protein_total_count = total_count[0];
    tumor_count1 = tumor_count[0];
    target_protein1 = target_protein[0];
    target_ids1 = target_id_json[0];
    interaction_names1 = interaction_names[0];
    interaction_edges1 = interaction_edges[0];
    interaction_pwms1 = interaction_pwms[0];
    protein_page_setup();
  }



  $('#protein-selection-btn').on("click", function(){
    $("#network-view-container").hide();
    $("#network-selection-container").show();
  });
  $('#protein-choice-list').on( "click", "tr", function() {

    net_nodes = [];
    net_edges = [];
    networkData = networkData1[$(this).index()];
    protein_count1 = protein_count[$(this).index()];
    protein_total1 = protein_total[$(this).index()];
    mutation_count1 = mutation_count[$(this).index()];
    protein_total_count = total_count[$(this).index()];
    tumor_count1 = tumor_count[$(this).index()];
    target_protein1 = target_protein[$(this).index()];
    target_ids1 = target_id_json[$(this).index()];
    interaction_names1 = interaction_names[$(this).index()];
    interaction_edges1 = interaction_edges[$(this).index()];
    interaction_pwms1 = interaction_pwms[$(this).index()];
    protein_page_setup();
    loadCy();
    $('#cy').cytoscape(options);
    $("#network-selection-container").hide();
    $("#network-view-container").show();
  });



  function protein_page_setup()
  {
  if (target_protein.length < 1){
    $("#main_network_column").prepend("<div class=\"alert alert-warning\" style='margin-right:50px;margin-left:50px;'><p class='lead' style='color:white;'>Error: That protein was not found in the database.</p></div>");
  }
  else{
      $("#prot_c").text(protein_count1-1);
      $("#prot_c_2").text(protein_count1-1);
      $("#prot_c_total").text(protein_total_count);

      if (protein_total1 == $("#prot_c_total").text())
      {
        if (parseInt($("#prot_c").text()) < parseInt($("#prot_c_total").text()))
        {
          $("#show_all").show();
        }
        $("#show_more").hide();
      }
      else{
        $("#show_more").show();
      }
      $("#prot-name").text(target_protein1);
      $("#prot-id").text(target_ids1);
      $("#mut_c").text(mutation_count1);
      $("#tumor_c").text(tumor_count1);
      $("#cosmic-placeholder").text(protein_count1 - 1);

  }

  //Create list of nodes
  net_nodes = [];
  net_nodes.push({ data: { id: target_protein1, color: "#d12e2e", name: target_protein1, weight: 65, center: "true"}} )
    var l = 0;
    var prot_wt_count = 0;
    var prot_mut_count = 0;
  for(net in networkData)
  {
    for (n in networkData[net])
    {
      var n_feature = "wt";
      if (Object.keys(networkData[net][n]).length != 0){
        n_feature = "mut";
        prot_mut_count += 1;
      }  
      else {
        prot_wt_count += 1;
      }
      var mut_type = '';
      var this_interaction_edge = {};
      //find the correct interaction_edge
      for (j in interaction_edges1)
      {
        if (interaction_edges1[j]["protein_id"] == n)
        {
          this_interaction_edge = interaction_edges1[j];
        }
      }

      if (this_interaction_edge['Type'] == 'gain of function')
      {
        mut_type = 'gain';
      }
      else if (this_interaction_edge['Type'] == 'loss of function')
      {
        mut_type = 'loss';
      }
      else {
        if (Object.keys(networkData[net][n]).length != 0){
        mut_type = 'norm';
        }
      }
      net_nodes.push( { data: { id: n, name: interaction_names1[n][0], description: interaction_names1[n][1], color: "#292929", gene_id: net, weight: 65, muts: networkData[net][n], feature : n_feature, mut_type: mut_type}} );
      l += 1;
    }

  }

  //Assign 
  $(".m-int").find("span").text(prot_mut_count);
  $(".w-int").find("span").text(prot_wt_count);

  //Create list of edges
  net_edges = [];
  var l = 0;
  var k = 0;
  var gain_count = 0;
  var loss_count = 0;
  var norm_count = 0;
  for(net in networkData)
  {
    for (n in networkData[net])
    {
      var edge_color = "hsla(193, 59%, 45%, 0.78)";
      var edge_style = "solid";
      var this_interaction_edge = {};
      //find the correct interaction_edge
      for (j in interaction_edges1)
      {
        if (interaction_edges1[j]["protein_id"] == n)
        {
          this_interaction_edge = interaction_edges1[j];
        }
      }
      if (this_interaction_edge['Type'] == 'gain of function')
      {
        edge_color = "hsla(129, 93%, 34%, 1)";
        edge_style = "dashed";
        gain_count += 1;
      }
      else if (this_interaction_edge['Type'] == 'loss of function')
      {
        edge_color = "hsla(352, 89%, 52%, 1)";
        edge_style = "dashed";
        loss_count += 1;
      }
      else {
        if (Object.keys(networkData[net][n]).length != 0){
        norm_count += 1;
        }
      }
      net_edges.push( { data: { source: target_protein1, target: n, content: this_interaction_edge, width:(parseFloat(this_interaction_edge['Avg'])*parseFloat(this_interaction_edge['Avg'])*parseFloat(this_interaction_edge['Avg'])*20), feature: "mut", type: edge_style, func:edge_color } });
      l += 1;
    }
    k += 1;
  }

  //Assign
  $(".gain-int").find("span").text(gain_count);
  $(".loss-int").find("span").text(loss_count);
  $(".no-int").find("span").text(norm_count);

  //Create list of tissues for filter list
  var tissues = {};
  for (net in networkData)
  {
    for (n in networkData[net])
    {
      var arr = [];
      for (m in networkData[net][n])
      {
        if (isNaN(tissues[networkData[net][n][m][2]]))
        {
          tissues[networkData[net][n][m][2]] = 1;
        }

        if ($.inArray(networkData[net][n][m][2], arr) == -1)
        {
        tissues[networkData[net][n][m][2]] += 1;
        arr.push(networkData[net][n][m][2]);
        }

      }
    }
  }


  var sortable = [];
  for (var tissue in tissues)
      sortable.push([tissue, tissues[tissue]])

  var sorted_tissues = sortable.sort(function(a, b) {return a[1] - b[1]}).reverse();

  var counter = 0;
  $("#tissues_filter_table").html('');
  for (var tissue in sorted_tissues)
  {
    sorted_tissues[tissue][0] = sorted_tissues[tissue][0].replace("_"," ").replace("_"," ").replace("_"," ");
    if (counter < 9){
    $("#tissues_filter_table").append("<tr><td class='tissue_filter' data-name='"+sorted_tissues[tissue][0].replace("_"," ")+"'>"+sorted_tissues[tissue][0].replace("_"," ")+"<span data-color='alert-success' class='badge alert-success pull-right'>"+sorted_tissues[tissue][1]+"</span></td></tr>");
    counter += 1;
    }
    else if (counter == 9)
    {
      $("#tissues_filter_table").append("<tr id='tissue-load-more'><td><a><i>Show More</i></a></tr></td");
      $("#tissues_filter_table").append("<tr class='hidden_tr'><td class='tissue_filter' data-name='"+sorted_tissues[tissue][0].replace("_"," ")+"'>"+sorted_tissues[tissue][0].replace("_"," ")+"<span data-color='alert-success' class='badge alert-success pull-right'>"+sorted_tissues[tissue][1]+"</span></td></tr>");
    counter += 1;

    }
    else
    {
     $("#tissues_filter_table").append("<tr class='hidden_tr'><td class='tissue_filter' data-name='"+sorted_tissues[tissue][0].replace("_"," ")+"'>"+sorted_tissues[tissue][0].replace("_"," ")+"<span data-color='alert-success' class='badge alert-success pull-right'>"+sorted_tissues[tissue][1]+"</span></td></tr>");

    }
  }

  $("#tissues_filter_table").append("<tr id='tissue-load-less'><td><a><i>Show Less</i></a></tr></td");

  }
 //

  $('body').on( "click", "#cosmic-id", function() {
    if ( $(this).find(".badge").hasClass("alert-success"))
         {
          $(this).find(".badge").removeClass("alert-success");
          cy.$("node[id!='" + target_protein1 + "']").hide();
        }
        else
        {
          $(this).find(".badge").addClass("alert-success");
          cy.$("node[id!='" + target_protein1 + "']").show();
        }
  });

    $(".layout-select").on("click", function(){
    if ($(this).hasClass("active")) {
    }
    else {
      layout_type = $(this).html().toLowerCase();
    if (layout_type == "circle")
    {
      layout_type = "concentric";
    }
    $(".layout-select").removeClass("active");
    $(this).addClass("active");
    loadCy();

    $('#cy').cytoscape(options);

    }

  });

    $(".json-download").on("click", function(){
      $.ajax({
        url:"./save_data.php",
        type: "POST",
        data: {download_data:JSON.stringify(cy.json()['elements'])},
        success:function(result){
      window.location.href = './download.php';         
      }});

    });

    $(".csv-download-all").on("click", function(){
      var new_url = './download_all.php?protein-id=' + target_ids1
      window.location.href= new_url;
    });

    $(".csv-download").on("click", function(){
      var csv_data = cy.json()['elements'];
      var string = "SH3 binding protein\tInteracting proteins\tBiological process\tDisorder\tGene expression\tLocalization\tMolecular function\tPeptide conservation\tProtein expression\tSequence signature\tSurface accessibility\tAverage Interaction Score\n";
      var i = 0;
      for (csv in csv_data['nodes']){
        if (i == 0){
          source = csv_data['nodes'][csv]['data']['name'];
        }
        else
        {
          var data_content = [];
          for (csv2 in csv_data['edges']){
            if (csv_data['edges'][csv2]['data']['target'] == csv_data['nodes'][csv]['data']['id'])
            {
              avg = csv_data['edges'][csv2]['data']['content'];
              break;
            }
          }
          string = string + source + "\t" + csv_data['nodes'][csv]['data']['id'] + "\t" + avg['Biological_process'] + "\t" + avg['Disorder'] + "\t" + avg['Gene_expression'] + "\t" + avg['Localization'] + "\t" + avg["Molecular_function"] + "\t" + avg["Peptide_conservation"] + "\t" + avg["Protein_expression"] + "\t" + avg["Sequence_signature"] + "\t" + avg["Surface_accessibility"] + "\t" + avg['Avg'] + "\n";

        }
        i += 1;
      }
        $.ajax({
        url:"./save_data.php",
        type: "POST",
        data: {download_data:string},
        success:function(result){
      window.location.href = './download.php';         
       }});
          
    });
   $('body').on( "click", ".tissue_filter", function() {
    
         if ( $(this).find(".badge").hasClass("alert-success"))
         {
            $(this).find(".badge").removeClass("alert-success");
            for (net in networkData)
              {
                var found = 0;
                for (n in networkData[net])
                {
                  for (m in networkData[net][n])
                  {
                     var temp = networkData[net][n][m][2].replace("_"," ").replace("_"," ").replace("_"," ");
                     if ($(this).data('name') == temp)
                     {
                        cy.$("node[id='"+Object.keys(networkData[net])[0]+"']").hide();
                     }
                  }
                }
              }
         }
         else
         {
            $(this).find(".badge").addClass("alert-success");
            for (net in networkData)
              {
                var found = 0;
                for (n in networkData[net])
                {
                  for (m in networkData[net][n])
                  {
                     var temp = networkData[net][n][m][2].replace("_"," ").replace("_"," ").replace("_"," ");
                     if ($(this).data('name') == temp)
                     {
                        cy.$("node[id='"+Object.keys(networkData[net])[0]+"']").show();
                     }
                  }
                }
              }
         }

   });

  var layout_type = "concentric";
  $(loadCy = function(){

  options = {
    layout: { name: layout_type },
    name: 'circle',
    showOverlay: true,
    fit:true,

    style: cytoscape.stylesheet()
      .selector('node')
        .css({
          'background-color': 'data(color)',
          'content': 'data(name)',
          'font-size': 14,
          'text-valign': 'center',
          'color': 'white',
          'text-outline-color': 'data(color)',
          'text-outline-width':'3',
          'height': '40',
          'width':'40',
          'border-color': '#fff'
        })
      .selector(':selected')
        .css({
          'background-opacity':'0.9',
          'text-outline-opacity':'0',
          'line-color': '#000',
          'target-arrow-color': '#000',
          'border-color':'#398bc6',
          'border-opacity':'0.8',
          'border-width':'5',
        })
      .selector('edge')
        .css({
          'width': 3,
          'line-color': 'data(func)',
          'line-style': 'data(type)',
          'opacity':'0.4',
          'width':'data(width)',
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
      cy.boxSelectionEnabled(0);
      cy.userPanningEnabled(0);
      var clickedNode = null;
      var clickedEdge = null;
      cy.$('node').on('click', function(e){
        var ele = e.cyTarget;
        clickedNode = ele;
      });

      cy.$('edge').on('click', function(e){
        var ele = e.cyTarget;
        clickedEdge = ele;
      });


      cy.elements('node').qtip({
      content: {
        text: function(event, api) {

            //find the protein's interaction edge data
            if (clickedNode.data("center") != "true")
            {
            var this_edge;
            for (edge in interaction_edges1)
            {
              if (interaction_edges1[edge]['protein_id'] == clickedNode.data("gene_id"))
              {
                this_edge = interaction_edges1[edge];
                console.dir(this_edge['WT']);
              }
            }

            var mut_found = false;
            for (m in clickedNode.data("muts")){
              if (clickedNode.data("muts")[m][4] == 1){
                mut_found = true;
              }
            }

            var html = "";
            if (mut_found)
            {
              var wt_seq = "";
              var mt_seq = "";
              for ( var i = 0; i < this_edge['WT'].length; i++ )
              {
                if (this_edge['WT'].charAt(i) != this_edge['MT'].charAt(i))
                {
                  wt_seq = wt_seq + "<span class='wt'>" + this_edge['WT'].charAt(i) + "</span>";
                  mt_seq = mt_seq + "<span class='mt'>" + this_edge['MT'].charAt(i) + "</span>";
                }
                else
                {
                  wt_seq += this_edge['WT'].charAt(i);
                  mt_seq += this_edge['MT'].charAt(i);
                }
              }
            html = "<div style='overflow-y:scroll;max-height:200px;'><h6 style='margin-top:0;margin-bottom:8px;'><a href='http://ensembl.org/id/"+clickedNode.data("gene_id")+"' target=\"_blank\">" + clickedNode.data("gene_id") + "</a><p style='margin-top:6px;margin-bottom:0;font-style:italic;'>" + clickedNode.data("description") + "</p></h6><p style='margin-left:10px;font-size:1.2em;font-family:monospace;margin-top:12px;margin-right:10px;'>WT: " + wt_seq + " | Score: " + this_edge['WTscore'].slice(0,4) + "</p><p style='margin-left:10px;font-size:1.2em;font-family:monospace;'> MT: " + mt_seq + " | Score: " + this_edge['MTscore'].slice(0,4) + "<img src='../pwms/logos/"+interaction_pwms1[clickedNode.data("gene_id")]+".png' height='60px' style='margin-top:10px;display:block;' class='pwm-img'>" + "<h6 style='margin-top:0;'>Mutations in this protein:</h6><table class='table table-striped muts-table'><thead><tr><th>DNA</th><th>AA Syntax</th><th>Tumor</th></tr></thead><tbody>";

            }

            var muts_string = "";
            

            for (m in clickedNode.data("muts")){
              if (clickedNode.data("muts")[m][4] == 1){
                var row_string = "<tr class='highlighted_mut'><td>" + clickedNode.data("muts")[m][0] + "</td><td>" + clickedNode.data("muts")[m][3] + "</td><td>" + clickedNode.data("muts")[m][2] + "</td></tr>";
                muts_string = row_string + muts_string;
              }
              else
              {
                var row_string = "<tr><td>" + clickedNode.data("muts")[m][0] + "</td><td>" + clickedNode.data("muts")[m][3] + "</td><td>" + clickedNode.data("muts")[m][2] + "</td></tr>";
                muts_string += row_string;
              }
            }

            if (html == "" && muts_string != ""){
              html = "<div style='overflow-y:scroll;max-height:200px;'><h6 style='margin-top:0;margin-bottom:8px;'><a href='http://ensembl.org/id/"+clickedNode.data("gene_id")+"' target=\"_blank\">" + clickedNode.data("gene_id") + "</a><p style='margin-top:6px;margin-bottom:0;font-style:italic;'>" + clickedNode.data("description") + "</p></h6><h6 style='margin-top:0;'>Mutations in this protein:</h6><table class='table table-striped muts-table'><thead><tr><th>DNA</th><th>AA Syntax</th><th>Tumor</th></tr></thead><tbody>";
              return html + muts_string + "</tbody></table></div>";

            }
            else if (html == "" && muts_string == ""){
              html = "<div style='overflow-y:scroll;max-height:200px;'><h6 style='margin-top:0;margin-bottom:8px;'><a href='http://ensembl.org/id/"+clickedNode.data("gene_id")+"' target=\"_blank\">" + clickedNode.data("gene_id") + "</a><p style='margin-top:6px;margin-bottom:0;font-style:italic;'>" + clickedNode.data("description") + "</p></h6><h6 style='margin-top:0;'>No mutations in this protein.</h6>";             
              return html + "</div>";
            }
            else 
            {
              return html + muts_string + "</tbody></table></div>";             
            }
            }
            else{
              return "<div style='padding:10px;font-size:1.5em;line-height:1.8em;'><p><b>SH3 domain. Ensembl ID(s):</b><br><a href='http://ensembl.org/id/" + target_ids1 + "'>" + target_ids1 + "</a></p></div>";
            }
          },
        title: function(event, api) {
          return clickedNode.data("id");
        }
      },
      show: {
        ready: false
      },
      position: {
        my: 'top center',
        at: 'bottom center'
      },
      style: {
        classes: 'qtip-light',
        tip: {
          width: 10,
          height: 8
        }
      }
     });

    cy.elements('edge').qtip({
      content: {
        text: function(event, api) {
            var html = "<div style='overflow-y:scroll;max-height:200px;'><h5 style='margin-left:10px;'>Interaction Evaluation:</h5>"
            var muts_string = "<table class='table table-striped muts-table'><thead><tr><th>Property</th><th>Value</th></tr></thead><tbody>";
            muts_string += "<h6><b>Average: " + clickedEdge.data("content")['Avg'] + "</b></h6>";
            for (m in clickedEdge.data("content")){
              if (isNaN(m) && m != 'IID'  && m != 'Avg'  && m != 'protein_id'  && m != 'Syntax'  && m != 'Type'){
                muts_string += "<tr><td>" + m.replace("_"," ").replace("_"," ").replace("_"," ") + "</td><td>" + clickedEdge.data("content")[m] + "</td></tr>";
              }

              if (m == "Type")
              {
                var the_color = '';
                if (clickedEdge.data("content")[m] == 'loss of function'){
                  the_color = '#d43a3a';
                }
                else{
                  the_color = '#66da49';
                }
                var int_type_var = '';
                if (clickedEdge.data("content")[m] == "loss of function")
                {
                  int_type_var = "Loss of interaction";
                }
                else
                {
                  int_type_var = "Gain of interaction";
                }
                muts_string = muts_string + "<h6 style='color:"+ the_color + "; margin-bottom:5px;'><b>" + int_type_var + "</b></h6>";
              }
            }
            return html + muts_string +  "</tbody></table></div>";
          },
      },
      show: {
        ready: false
      },
      position: {
        my: 'top center',
        at: 'bottom center'
      },
      style: {
        classes: 'qtip-light',
        tip: {
          width: 10,
          height: 8
        }
      }
     });

    }
  };


  if (all_proteins.length == 1){
    $('#cy').cytoscape(options);
  }


});



});
  </script>
  </body>

</html>
