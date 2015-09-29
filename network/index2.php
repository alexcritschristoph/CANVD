<?php
  $root_path = "../";
  include_once('../common.php');
  include_once('../header.php');
?>

      <p id="main-top-text">The impacts of missense mutations on <b id="prot-name" style="color:#ea2f10"></b>  protein interactions in <b id="tumor_c2" style="color:#ea2f10"></b> tumor types.</p>

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
          <div class="list-group show-list" id="domains_list">
            <span class="list-group-item"><b>Domains</b></span>

          </div>

          <div class="list-group show-list" id="sources_list">
            <span class="list-group-item"><b>Mutation Sources:</b></span>
          </div>

      <div class="list-group show-list" id="tissue_list">
        <span class="list-group-item"><b>Mutations in Tissues:</b></span>

      </div>

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
            <p> <b id="prot_c"></b> proteins interact with the <b id="dm_c"></b> domain of <b id="prot-name2"></b> In <b id="tumor_c"></b> tumor types</p>
            <!--<p>With total of <b id="mut_c"></b> mutations</p>  (<i id="prot-id">Testing</i>) 	-->

          </div>
        </div>

        <div class="list-group show-list">
          <span class="list-group-item"><b>Mutation Effect</b></span>
          <a class="list-group-item show-item w-prot w-int"><span data-color="wt-pt" class="badge wt-pt">0</span>Wildtype Proteins </a>
          <a class="list-group-item show-item g-prot no-int"><span data-color="noch-pt" class="badge noch-pt" ></span>Neutral </a>
          <a class="list-group-item show-item g-prot gain-int"><span data-color="gn-pt" class="badge gn-pt" ></span>Gain of Interaction </a>
          <a class="list-group-item show-item l-prot loss-int"><span data-color="ls-pt" class="badge ls-pt" ></span> Loss of Interaction
              <a class="list-group-item show-item g-prot no-int"><span data-color="both-pt" class="badge both-pt" ></span>Gain / Loss </a>

          </a>
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
  var net_limit = 50;
    <?php
  }

  //Generate network data
  include_once('../search2.php');

  ?>
  console.log(networkData);

  //Update statistics
  function update() {
      var domain_type = networkData[active_domain].domain_info.Type;
      var prot_num = Object.keys(networkData[active_domain].mut_int).length;
      var gene_name = networkData[active_domain].domain_info.DomainName;
      $("#prot_c").text(prot_num);
      $("#dm_c").text(domain_type);
      $("#prot-name2").text(gene_name);
      $("#prot-name").text(gene_name);
      //count mutation effects
      var gain_count = 0;
      var loss_count = 0;
      var neutral_count = 0;
      var both_count = 0;
      for (int in networkData[active_domain].mut_int)
      {
          interaction = networkData[active_domain].mut_int[int];
          if (interaction == "gain")
          {
              gain_count = gain_count + 1;
          }
          else if (interaction == "loss") {
              loss_count = loss_count + 1;
          }
          else if (interaction == "neutral") {
              neutral_count = neutral_count + 1;
          }
          else if (interaction == "both") {
              both_count = both_count + 1;
          }
      }
      $(".noch-pt").text(neutral_count);
      $(".gn-pt").text(gain_count);
      $(".ls-pt").text(loss_count);
      $(".both-pt").text(both_count);
      //get tissue unique list
      tissues = [];
      mutations = networkData[active_domain].muts;
      sources = {};
      for (mut in mutations)
      {
          if ($.inArray(mutations[mut].Tissue, tissues) == -1)
          {
              tissues.push(mutations[mut].Tissue);
          }

          if ($.inArray(mutations[mut].Source, Object.keys(sources)) != -1)
          {
              sources[mutations[mut].Source] =  sources[mutations[mut].Source] + 1;
          }
          else {
              sources[mutations[mut].Source] = 1;
          }
      }
      $("#tumor_c").text(tissues.length);
      $("#tumor_c2").text(tissues.length);

      for (source in Object.keys(sources))
      {
          sour = Object.keys(sources)[source]
          $("#sources_list").find(".show-item").remove();
          $("#sources_list").append('<span class="list-group-item show-item source-item"><span class="badge">'  + sources[sour] + '</span>'+ sour + '</span>');
      }
      //Create tissue list

      $("#tissue_list").find(".show-item").remove();
      var i = 0;
      for (tissue in tissues)
      {
          if (i < 4)
          {
              $("#tissue_list").append('<a class="list-group-item show-item "><span class="badge tissue-item">'  + 5 + '</span>'+ tissues[tissue] + ' </a>');
          }
          else
          {
              $("#tissue_list").append('<a class="list-group-item show-item tissue_load_more" style="background:#E7E7E7">Load More</a>');
              break;
          }
          i += 1;
      }

      //Add nodes and edges
      net_nodes = [];
      net_edges = [];
      net_nodes.push({ data: { id: gene_name, color: "#d12e2e", name: gene_name, weight: 100, center: "true"}} )
      var interactions = networkData[active_domain].mut_int;
      var interaction_data = networkData[active_domain].gene_info;
      for (node in interactions)
      {
          //Add nodes
          net_nodes.push( { data: { id: node, name: interaction_data[node].GeneName, description: interaction_data[node].Description, color: "#292929", gene_id: node, weight: 100, muts: "", mut_type: interactions[node]}} );

          //Add edges
          var edge_color, edge_style;

          if (interactions[node] == "loss")
            edge_color = "#d7191c", edge_style = "dashed";
          if (interactions[node] == "gain")
            edge_color = "#2c7bb6", edge_style = "dashed";
          if (interactions[node] == "both")
            edge_color = "#e9a3c9", edge_style = "dashed";
          if (interactions[node] == "neutral")
            edge_color = "#fdb863", edge_style = "dotted";

          net_edges.push( { data: { source: gene_name, target: node, content: "Interaction", width:3, type: interactions[node], color: edge_color, style: edge_style } });
      }
      console.log(net_edges);
        options = {
          layout: { name: layoutType },
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
                'line-color': 'data(color)',
                'line-style': 'data(style)',
                'opacity':'0.9',
                'width':'data(width)',
                'target-arrow-shape': 'triangle',
                'target-arrow-color': 'data(color)',

              })
          ,

          elements: {
            nodes: net_nodes,
            edges: net_edges,

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

          }
        };

        $('#cy').cytoscape(options);
    }

    var active_domain = "";
    for (active_domain in networkData) break;

    //Create domain list
    for (domain in networkData)
    {
        if (domain == active_domain)
        {
            $("#domains_list").append('<a data-domain="' + domain + '" class="list-group-item show-item active"><span class="badge domain">' + Object.keys(networkData[domain].gene_info).length + '</span>'+ networkData[domain].domain_info.DomainName + ' : ' + networkData[domain].domain_info.Type + ' </a>');
        }
        else {
            $("#domains_list").append('<a data-domain="' + domain + '" class="list-group-item show-item"><span class="badge domain">'  + Object.keys(networkData[domain].gene_info).length + '</span>'+ networkData[domain].domain_info.DomainName + ' : ' + networkData[domain].domain_info.Type + ' </a>');
        }
        console.log(domain);
    }

    var layoutType = "concentric";
    update();

    //On clicking domain
    $("#domains_list a").on('click', function(){
        active_domain = $(this).data("domain");
        $("#domains_list a").removeClass("active");
        $(this).addClass("active");
        update();
    });

    //On changing layout
    $(".layout-select").on("click", function(){
        $(".layout-select").removeClass("active");
        $(this).addClass("active");
        if ($(this).text() == "Circle"){
            layoutType = "concentric";
        }
        else {
            layoutType = "grid";
        }

        update();
    })

    //Tissue load more
    $("#tissue_list").on("click", ".tissue_load_more", function(){
        $(".tissue_load_more").hide();
        var i = 0;
        for (tissue in tissues)
        {
            if (i >= 4)
            {
                $("#tissue_list").append('<a class="list-group-item show-item"><span class="badge tissue-item">'  + 5 + '</span>'+ tissues[tissue] + ' </a>');
            }
            i += 1;
        }
    });

});
  </script>
  </body>

</html>

