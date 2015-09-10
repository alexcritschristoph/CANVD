<?php
	$root_path = "../";
  include_once('./common.php');

?>

<html>
    
<?php
	$root_path = "../";
  include_once('../header.php');
?>	
	   <p><h2 style="margin-bottom:30px;"> Available Datasets in <span style="color:#ea2f10">Can-VD</span></h2></p>
		<br>
			    <p align="justify">The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase (<span style="color:#ea2f10">Can-VD</span>) was designed as a host for all data sets results from studying the impact of cancer mutations in domain-based protein-protein interactions (PPI). This page lists all the datasets that are currently available in <span style="color:#ea2f10">Can-VD</span> with short description of the each dataset, the description of the processing and formatting steps, the compliance with <span style="color:#ea2f10">Can-VD</span> data standard and the publish study corresponds to the dataset.   </p>
		<br>
	<p><b>1- Phosphokinase-binding Domain Dataset </p>
      <p>This data set describe assessment of cancer mutations impact on PPI mediated through the phosphokinase-binding domains.   </p>  
      <p align="justify">- Brief description of the processing and formatting steps: The published data in the supplementary martials and the website associated with the study contains most of the data items required by <span style="color:#ea2f10">Can-VD</span> standard. We used these data directly or after few processing and formatting steps to despite the data into <span style="color:#ea2f10">Can-VD</span>. However, we requested the full sequences of the proteins used in the analysis from the authors as they used one protein per gene. Furthermore, some information such as the protein names and Ensembl IDs were Obtained from online resources. The compliance of the published dataset with <span style="color:#ea2f10">Can-VD</span> proposed standard is ~80%. </p>
      <p>Compliance of published data with <span style="color:#ea2f10">Can-VD</span> data-reporting standard:   <span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star-o"></i></span></p>  
      <p>Compliance of processed data with <span style="color:#ea2f10">Can-VD</span> data-reporting standard:   <span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span></p>  </p>  
    <p><a href="http://www.nature.com/nmeth/journal/vaop/ncurrent/full/nmeth.3396.html">Wagih O. <i>et al</i>, Nature Methods, 2015. doi:10.1038/nmeth.3396</a></p>
<br><br>
<p><b>2- SH2 Domain Dataset </p>
      <p>This data set describe assessment of cancer mutations impact on PPI mediated through the SH2 domains.   </p>  
    <p align="justify">- Brief description of the processing and formatting steps: For this dataset, we mostly used data requested from authors. The method used to generate the original data provides single value that indicates the assessment result of the mutation impact. Therefore, the authors, kindly, offered to re-do the analysis after modifying their pipeline to generate independent wildtype (WT) and mutant (MT) scores. To obtain the protein full sequences, we requested the UniProt IDs of the employed proteins and downloaded the full sequences from UniProt. The method used in this study is PWM-independent. Therefore, we requested the authors to provide PWM, for visualization purposes, by converting the PEMs to PWMs. The PWMs provided by the authors were missing the Cysteine (C) amino acid due to experimental procedures. We added dummy C column to the PWM with values of 0 to make the PWM format compatible with the standard formats that works with visualization and scoring tools and algorithms. The mutation description was reported in non-standard notation. The position of the mutation was relative to the start of binding-peptide rather than the start of the protein. Thus, we had to calculate the correct mutations position through P<i>m</i> = P<i>pho</i> + P<i>r</i> - 8, where P<i>m</i> is the mutation position, P<i>pho</i> is the phosphosite position and P<i>r</i> is the reported mutations position in the data recived from the authors. Furthermore, this study evaluates the impact of the mutations that occurs in the SH2 domains, not only the binding peptides. Since <span style="color:#ea2f10">Can-VD</span> does not support this type of information, we kept the assessment of mutations in the binding peptides only (~45%) and eliminated the remaining data. The compliance of the published dataset with <span style="color:#ea2f10">Can-VD</span> proposed standard is ~50%.  </p>
    <p>- Compliance of published data with <span style="color:#ea2f10">Can-VD</span> data-reporting standard:   <span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star-half-o"></i></span><span style="color:#ea2f10"><i class="fa fa-star-o"></i></span><span style="color:#ea2f10"><i class="fa fa-star-o"></i></span></p>  
      <p>- Compliance of processed data with <span style="color:#ea2f10">Can-VD</span> data-reporting standard:   <span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span></p>  </p>  
    <p><a href="http://www.nature.com/nmeth/journal/vaop/ncurrent/full/nmeth.3396.html">AlQuraishi M. <i>et al</i>, Nature Genetics, 2014. doi:10.1038/ng.3138</a></p>
<br>
<?php
      include $root_path. 'footer.php';
    ?>

	  </body>
</html>
