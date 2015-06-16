**Can-VD README**


The Cancer Variants Database (Can-VD) is an online resource for the assessment of the impact of cancer mutations on protein-protein interactions (PPI) networks. Can-VD stores the PPI interaction networks mediated by wildtype and cancer variants and visualizes the overlay of the two networks to understand the effects of mutations on the network and consequently their cellular and biological impact. The effects of over 800,000 cancer missense mutations are analyzed and stored in Can-VD. Furthermore, Can-VD provides the full sequences of the wildtype and cancer variant proteins, with a comprehensive search and download interface to easily build a customized protein databases for cancer genomics and proteomics. 

![CAN-VD Screenshot](http://i.imgur.com/qwGZyAy.png)


**Code Overview:**

A quick introduction to the important source code files of Can-VD:

index.php - HTML/PHP for the front landing page.

generate_stats.php - HTML/PHP for generating database statistics.

logout.php - Logs the administrator user out of the portal.

PDOext.class.php - An extension of PHP's PDO class, gives a few basic extra functions.

jquery.tooltip.css/js - CSS and JS files for the tooltip extension.

search.php - runs and handles searches for network data.

site.js - some javascript which is primarily used on the front page.

styles.css - the custom styles for Can-VD.

common.php - Settings and configuration common to all PHP files.

./tables/ - PHP files for the generation of the browsing tables on the main page.

./admin/ - PHP files for the administration panel.

./variants/index.php - PHP/HTML for the variant search page.

./variants/details.php - PHP/HTML for the variant details page.

/variants/variant_load.php - AJAX PHP for loading variant search results.

./network/index.php - PHP/HTML for display of the network page. Called by search.php.

./network/download.php - Handles network downloads.
