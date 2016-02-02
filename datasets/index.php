<?php
	$root_path = "../";
  include_once('./common.php');

?>

<html>
    
<?php
	$root_path = "../";
  include_once('../header.php');
?>	
	   <p><h2 style="margin-bottom:30px;"> Datasets Available in <span style="color:#ea2f10">Can-VD</span></h2></p>
		<br>
			    <p align="justify">The <span style="color:#ea2f10">Can</span>cer <span style="color:#ea2f10">V</span>ariants <span style="color:#ea2f10">D</span>atabase (<span style="color:#ea2f10">Can-VD</span>) was designed to incoporate multiple datasets from studies on the impact of cancer mutations on domain-based protein-protein interactions (PPI). This page lists all the datasets that are currently available in <span style="color:#ea2f10">Can-VD</span> with short description of each dataset, the description of the processing and formatting steps, the compliance with the <span style="color:#ea2f10">Can-VD</span> data standard, and the published study corresponding to the dataset.   </p>
		<br>
	<p><b>1- Phosphokinase-binding Domain Dataset </p>
      <p>This data set describe assessment of cancer mutations impact on PPI mediated through phosphokinase-binding domains.   </p>  
      <p><u> Brief description of the processing and formatting steps</u></p>
      <p align="justify">The published data in the supplementary martials and the website associated with the study contains most of the data items required by <span style="color:#ea2f10">Can-VD</span> standard. We used these data directly after few processing and formatting steps to deposit the data into <span style="color:#ea2f10">Can-VD</span>. We also requested the full sequences of the proteins used in the analysis from the authors. Furthermore, additional information such as the protein names and Ensembl IDs were obtained from online resources. The compliance of the published dataset with the <span style="color:#ea2f10">Can-VD</span> proposed standard is ~80% due to the original unavailability of the full sequences of the proteins with the published article or in the associated website. </p>
      <p>Compliance of published data with <span style="color:#ea2f10">Can-VD</span> data-reporting standard:   <span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star-o"></i></span></p>  
      <p>Compliance of processed data with <span style="color:#ea2f10">Can-VD</span> data-reporting standard:   <span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span></p>  </p>  
    <p><a href="http://www.nature.com/nmeth/journal/vaop/ncurrent/full/nmeth.3396.html">Wagih O. <i>et al</i>, Nature Methods, 2015. doi:10.1038/nmeth.3396</a></p>
<br><br>
<p><b>2- SH2 Domain Dataset </p>
      <p>This data set describe assessment of cancer mutations impact on PPI mediated through the SH2 domains.   </p>  
      <p><u>Brief description of the processing and formatting steps</u></p>
    <p align="justify">For this dataset, we mostly used data requested from authors. The method used to generate the original data provided a single metric that indicates the assessment result of the mutation impact. Therefore, the authors, kindly, offered to re-do the analysis after modifying their pipeline to generate independent wildtype (WT) and mutant (MT) scores. To obtain the protein full sequences, we requested the UniProt IDs of the employed proteins and downloaded the full sequences from UniProt. The method used in this study is PWM-independent. Therefore, we requested the authors to provide PWMs, for visualization purposes, by converting the PEMs to PWMs. The PWMs provided by the authors were missing the Cysteine (C) amino acid due to experimental procedures. We added dummy C column to the PWMs with values of 0 to make the PWM format compatible with the standard formats that work with visualization and scoring tools and algorithms. The mutation description was reported in non-standard notation. The position of the mutation was relative to the start of the binding-peptide rather than the start of the protein. Thus, we had to calculate the correct mutations position using the equation P<i>m</i> = P<i>pho</i> + P<i>r</i> - 8, where P<i>m</i> is the mutation position, P<i>pho</i> is the phosphosite position, and P<i>r</i> is the reported mutations position in the data recived from the authors. Furthermore, this study evaluates the impact of the mutations that occurs in the SH2 domains and not only binding peptides. Since <span style="color:#ea2f10">Can-VD</span> does not support this type of information, we only kept the assessment of mutations in the binding peptides (~45% of the dataset) and eliminated the remaining data. The compliance of the original published dataset with the <span style="color:#ea2f10">Can-VD</span> proposed standard was ~50%.  </p>
    <p>- Compliance of published data with <span style="color:#ea2f10">Can-VD</span> data-reporting standard:   <span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star-half-o"></i></span><span style="color:#ea2f10"><i class="fa fa-star-o"></i></span><span style="color:#ea2f10"><i class="fa fa-star-o"></i></span></p>  
      <p>- Compliance of processed data with <span style="color:#ea2f10">Can-VD</span> data-reporting standard:   <span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span><span style="color:#ea2f10"><i class="fa fa-star"></i></span></p>  </p>  
    <p><a href="http://www.nature.com/nmeth/journal/vaop/ncurrent/full/nmeth.3396.html">AlQuraishi M. <i>et al</i>, Nature Genetics, 2014. doi:10.1038/ng.3138</a></p>
<br>
<?php
      include $root_path. 'footer.php';
    ?>

	  </body>
</html>
