<?php
  $root_path = "../";
?>

<html>
	<?php
	$root_path = "../";
  include_once('../header.php');
?>	
      <p><h2 style="margin-bottom:30px;"> Frequently Asked Questions about <span style="color:#ea2f10">Can-VD</span></h2></p>
		<br>
			    <p align="justify">The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase (<span style="color:#ea2f10">Can-VD</span>) is an online resource for the assessment of the impact of cancer mutations on protein-protein interactions (PPI) networks. <span style="color:#ea2f10">Can-VD</span> stores the PPI interaction networks mediated by wildtype and cancer variants and visualizes the overlay of the two networks in order to understand the effects of mutations on the network, and consequently, their cellular and biological impact. The effects of over 800,000 cancer missense mutations are analyzed and stored in <span style="color:#ea2f10">Can-VD</span>. Furthermore, <span style="color:#ea2f10">Can-VD</span> provides the full sequences of the wildtype and cancer variant proteins, with a comprehensive search and download interface to easily build a customized protein dataset for cancer genomics and proteomics. </p>
		<br>
		<p><b>Important  note:</b> The currently available data in <span style="color:#ea2f10">Can-VD</span> is for <b>TESTING ONLY</b> and is not final. Please do not use to make any scientific inferences or predictions.</p>
		<br>
      <p><b>1. What is <span style="color:#ea2f10">Can-VD</span>?</b></p>
      <p>The Cancer Variants Database (<span style="color:#ea2f10">Can-VD</span>) is an online resource for cancer mutations impacts on protein-protein interactions (PPI). </p>
      <p><b>2. What type of predictions are available in <span style="color:#ea2f10">Can-VD</span>?</b></p>
      <p><span style="color:#ea2f10">Can-VD</span> is designed to store the predictions of cancer mutations impact on several types of PPIs, such as domain-based PPI and kinase-substrate interactions. Currently, <span style="color:#ea2f10">Can-VD</span> stores the data of SH3-domain based PPIs and the predicted effects of 800,000 cancer missense mutations obtained from <a href='http://cancer.sanger.ac.uk/cancergenome/projects/cosmic/'>COSMIC database</a>. </p>
   	  <p><b>3. What are the types of data stored in <span style="color:#ea2f10">Can-VD</span>?</b></p>
      <p>-<span style="color:#ea2f10">Can-VD</span> includes data covering:<br>
		1- PPI predictions<br>
		2- Mutation impacts on the predicted PPIs.<br>
		3- Evaluation of the predictions using 9 different genomic and context metrics.<br>
		4- Network information in JSON and tab-delimited formats.<br>
		5- Binding motifs (PWMs) in three different formats and sequence logos. <br>
		6- Protein sequences, including wildtypes and variants.<br>
		7- Mutation information including source, tissue, frequency, etc.<br>
		</p>
       <p><b>4. How do I obtain sequences for all variants of particular protein?</b></p>
      <p>- To obtain cancer variants of particular protein, please use the Variants page accessed in the header, and enter a protein name on the Protein name/ID text box, then click search. <span style="color:#ea2f10">Can-VD</span> accepts gene symbol and Ensembl IDs only. In the search result, click the name of your protein of interest (if the search result has more than one protein), to go to the details page. The details page list all the variants of this protein available in<span style="color:#ea2f10">Can-VD</span>. Use the download links to download the sequence(s) of particular variants or the download button on the top of the results section to download all of them in a single fasta file.    </p>
      
        <p><b>5. How do I obtain sequences for all variants of particular cancer type or tissue?</b></p>
      <p>- To obtain cancer variants of particular cancer type or tissue, please use the Variants page accessed in the header, and select one or more cancer type(s) or tissue(s), then click search. In the search result, click the download button to download the information for the protein displayed in the current view, or click the name of your protein of interest (if the search result has more than one protein), to go to the details page. The details page list all the variants of this protein available in <span style="color:#ea2f10">Can-VD</span>. Use the download links to download the sequence(s) of particular variants or the download button on the top of the results section to download all of them in a single fasta file.    </p>
      
        <p><b>6. How can <span style="color:#ea2f10">Can-VD</span> contribute towards research in cancer proteomics?</b></p>
      <p>-<span style="color:#ea2f10">Can-VD</span> provides the full sequence of the wildtype proteins and corresponding mutants with information of the mutation position, reference amino acid, and mutant amino acid. It provides all variants in a single FASTA file, ready to be used directly as a database for protein identification in any standard mass spectrometry-based proteomics data analysis workflow, and can be used in the identifical of specific variants in cancer samples. </p>
      
        <p><b>7. What is the version of Ensembl databases used in <span style="color:#ea2f10">Can-VD</span> and why?</b></p>
      <p>- <span style="color:#ea2f10">Can-VD</span> was developed using the protein sequencers of Ensembl database v62, the same version used in the SH3 study (submitted). </p>
      
        <p><b>8. Can I use <span style="color:#ea2f10">Can-VD</span> data with Cytoscape? </b></p>
      <p>- <span style="color:#ea2f10">Can-VD</span> network visualization was developed using Cytoscape.JS. The interaction network is available in two different formats, as a JSON document and in a tab-delimited format. Both can be downloaded from the download tab in left panel of the network page. </p>
      
        <p><b>9. What is the <span style="color:#ea2f10">Can-VD</span> advanced search options?</b></p>
      <p>- <span style="color:#ea2f10">Can-VD</span> provides a few advanced search options to customize search results including limiting the mutation type and mutation source database.
</p>
      
  
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