Can-VD README.

1. Description of the Can-VD stack
Can-VD uses a Linux, Apache, MySQL, PHP stack.

2. Setting up the Can-VD stack
	A. Installing the stack:
	sudo apt-get install apache2 mysql-common mysql-client mysql-server php5 php5-mysql
	B. Set 'PSSWD' in the file /var/www/admin/upload_text.php, line 23, to the server's MySQL password.
	C. Set 'PASSWORD' in the file /var/www/common.php, line 14, to the server's MySQL password (and / or username).
	D. Run sudo chmod -R 775 on the /var/www/proteins/ and /var/www/pwms/ directories if they are changed or moved.
	E. Run sudo chown -v www-data -R /var/www/admin/upload/

3. Can-VD code 

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

APPENDIX

1. Structure of the Can-VD database
The following MySQL code will generate the structure of the database:

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `canvd` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `canvd`;

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `show` int(11) NOT NULL DEFAULT '1',
  `show_homepage` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

CREATE TABLE IF NOT EXISTS `tissue_table_browser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tissue` varchar(255) NOT NULL,
  `variants` int(11) NOT NULL,
  `proteins` int(11) NOT NULL,
  `gain` int(11) NOT NULL,
  `loss` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

CREATE TABLE IF NOT EXISTS `T_Domain` (
  `Domain` varchar(255) DEFAULT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `Isoform` varchar(255) DEFAULT NULL,
  `GeneName` varchar(255) DEFAULT NULL,
  `EnsGID` varchar(255) DEFAULT NULL,
  `EnsPID` varchar(255) DEFAULT NULL,
  `ProteinLength` varchar(255) DEFAULT NULL,
  `DomainStartPos` varchar(255) DEFAULT NULL,
  `DomainEndPos` varchar(255) DEFAULT NULL,
  `DomainSequence` text,
  `OtherEnsemblGenes` text,
  `OtherEnsemblProteins` text,
  `OriginalID` varchar(255) DEFAULT NULL,
  `Ac_Geneart` varchar(255) DEFAULT NULL,
  `Purification` varchar(255) DEFAULT NULL,
  `ELISAForPhageDisplay` varchar(255) DEFAULT NULL,
  `PCR` varchar(255) DEFAULT NULL,
  `Position` varchar(255) DEFAULT NULL,
  `Specificity` varchar(255) DEFAULT NULL,
  `UniquePep` varchar(255) DEFAULT NULL,
  `Note` varchar(255) DEFAULT NULL,
  `EnsTID` varchar(255) DEFAULT NULL,
  KEY `Domain` (`Domain`),
  KEY `GeneName` (`GeneName`),
  KEY `Domain_2` (`Domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `T_Ensembl` (
  `EnsPID` varchar(255) DEFAULT NULL,
  `EnsTID` varchar(255) DEFAULT NULL,
  `EnsGID` varchar(255) DEFAULT NULL,
  `Version` varchar(255) DEFAULT NULL,
  `GeneName` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Sequence` text,
  KEY `GeneName` (`GeneName`),
  KEY `Description` (`Description`),
  KEY `EnsPID` (`EnsPID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `T_Interaction` (
  `IID` varchar(255) DEFAULT NULL,
  `PWM` varchar(255) DEFAULT NULL,
  `Domain_EnsPID` varchar(255) DEFAULT NULL,
  `Interaction_EnsPID` varchar(255) DEFAULT NULL,
  `Start` varchar(255) DEFAULT NULL,
  `End` varchar(255) DEFAULT NULL,
  `Score` varchar(255) DEFAULT NULL,
  `Type` varchar(255) DEFAULT NULL,
  KEY `IID` (`IID`),
  KEY `Domain_EnsPID` (`Domain_EnsPID`),
  KEY `Interaction_EnsPID` (`Interaction_EnsPID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `T_Interactions_Eval` (
  `IID` int(11) DEFAULT NULL,
  `Gene_expression` double DEFAULT NULL,
  `Protein_expression` double DEFAULT NULL,
  `Disorder` double DEFAULT NULL,
  `Surface_accessibility` double DEFAULT NULL,
  `Peptide_conservation` double DEFAULT NULL,
  `Molecular_function` double DEFAULT NULL,
  `Biological_process` double DEFAULT NULL,
  `Localization` double DEFAULT NULL,
  `Sequence_signature` double DEFAULT NULL,
  `Avg` double DEFAULT NULL,
  KEY `IID` (`IID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `T_Interaction_MT` (
  `IID` varchar(255) DEFAULT NULL,
  `WT` varchar(255) DEFAULT NULL,
  `MT` varchar(255) DEFAULT NULL,
  `KmerNo` varchar(255) DEFAULT NULL,
  `WTscore` varchar(255) DEFAULT NULL,
  `MTscore` varchar(255) DEFAULT NULL,
  `VID` varchar(255) DEFAULT NULL,
  `Int_EnsPID` varchar(255) DEFAULT NULL,
  `Mut_Syntax` varchar(255) DEFAULT NULL,
  `DeltaScore` varchar(255) DEFAULT NULL,
  `LOG2` varchar(255) DEFAULT NULL,
  `Eval` varchar(255) DEFAULT NULL,
  `PWM` varchar(255) DEFAULT NULL,
  KEY `IID` (`IID`),
  KEY `IID_2` (`IID`),
  KEY `Int_EnsPID` (`Int_EnsPID`),
  KEY `Int_EnsPID_2` (`Int_EnsPID`),
  KEY `Mut_Syntax` (`Mut_Syntax`),
  KEY `Int_EnsPID_3` (`Int_EnsPID`),
  KEY `Eval` (`Eval`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `T_Mutations` (
  `ID` varchar(255) NOT NULL DEFAULT '',
  `MUTATION_ID` varchar(255) DEFAULT NULL,
  `mut_description` varchar(255) DEFAULT NULL,
  `mut_syntax_cds` varchar(255) DEFAULT NULL,
  `mut_syntax_aa` varchar(255) DEFAULT NULL,
  `GRCh37 start` varchar(255) DEFAULT NULL,
  `GRCh37 stop` varchar(255) DEFAULT NULL,
  `mut_nt` varchar(255) DEFAULT NULL,
  `mut_aa` varchar(255) DEFAULT NULL,
  `examined_samples` varchar(255) DEFAULT NULL,
  `tumour_site` varchar(255) DEFAULT NULL,
  `mutated_samples` varchar(255) DEFAULT NULL,
  `Mutation_Source_ID` varchar(255) DEFAULT NULL,
  `gene name` varchar(255) DEFAULT NULL,
  `EnsTID` varchar(255) DEFAULT NULL,
  `EnsPID` varchar(255) DEFAULT NULL,
  `EnsGID` varchar(255) DEFAULT NULL,
  `Source` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `EnsPID` (`EnsPID`),
  KEY `tumour_site` (`tumour_site`),
  KEY `ID_2` (`ID`),
  KEY `Source` (`Source`),
  KEY `gene name` (`gene name`),
  KEY `mut_description` (`mut_description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `T_PWM` (
  `PWM` varchar(255) DEFAULT NULL,
  `APlus` varchar(255) DEFAULT NULL,
  `AMinus` varchar(255) DEFAULT NULL,
  `Domain` varchar(255) DEFAULT NULL,
  KEY `PWM` (`PWM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;