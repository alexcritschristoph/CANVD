<?php
  $root_path = "../";
include_once('../header.php');
?>


		<p><h2 style="margin-bottom:0px;"> Contact Information for the <span style="color:#ea2f10">Can-VD</span> database and website:</h2></p><br><br>

		<p align="justify"><span style="color:#ea2f10">Can-VD</span> is developed at the laboratory of Professor Gary Bader (<a href='baderlab.org'>Bader Lab</a>) at The <a href='http://tdccbr.med.utoronto.ca/'> Donnelly Centre </a> for Cellular and Biomolecular Research (CCBR) at <a href='http://utoronto.ca/'> The University of Toronto</a>.</p>      
           <p align="justify">The web interface and server for <span style="color:#ea2f10">Can-VD</span> was developed by <a href='mailto:acritsc1@jhu.edu'>Alex Crits-Christoph</a>, Johns Hopkins University, as part of <a href='http://www.google-melange.com/gsoc/homepage/google/gsoc2014'>Google Summer of Code 2014</a>.</p>      
      <p align="justify">For questions and bugs reporting please contact <a href='mailto:mohamed.attiashahata@utoronto.ca'>Mohamed Helmy</a>, The Donnelly Centre, University of Toronto. <br></p>
	  </div>
	<div class="container">
	<br><br><br><br><br>
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
