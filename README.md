**Legacy Can-VD**

NOTE: Can-VD has been renamed to DV-IMPACT, and the most up-to-date repository for DV-IMPACT is available [here](https://github.com/MoHelmy/DV-IMPACT).

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
