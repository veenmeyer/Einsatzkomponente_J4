<?php
/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
 
// No direct access
defined('_JEXEC') or die;
class com_einsatzkomponenteInstallerScript {
	public function install($parent) {
		
		// $parent is the class calling this method
		$parent->getParent()->setRedirectURL('index.php?option=com_einsatzkomponente&view=installation');
	}
	public function uninstall($parent) {
		echo '<h1>Die Datenbanktabellen müssen Sie manuell löschen ...</h1>';
   }
										
	public function update($parent) {
		// $parent is the class calling this method 
		
		$parent->getParent()->setRedirectURL('index.php?option=com_einsatzkomponente&view=installation');
		
   }
   
   
function preflight( $type, $parent ) {
 
	// abort if the release being installed is not newer than the currently installed version
	if ( $type == 'update' ) :
		
		// Überflüssige Files löschen
		jimport( 'joomla.filesystem.file' );
		jimport( 'joomla.filesystem.folder' );

		if( JFolder::exists(JPATH_ROOT.'/components/com_einsatzkomponente/views/einsatzberichte_neu') )
		{
		JFolder::delete(JPATH_ROOT.'/components/com_einsatzkomponente/views/einsatzberichte_neu');
		}	
		if( JFile::exists(JPATH_ROOT.'/components/com_einsatzkomponente/models/forms/filter_einsatzberichte_neu.xml') )
		{
		JFile::delete(JPATH_ROOT.'/components/com_einsatzkomponente/models/forms/filter_einsatzberichte_neu.xml');
		}	
		if( JFile::exists(JPATH_ROOT.'/components/com_einsatzkomponente/controllers/einsatzberichte_neu.php') )
		{
		JFile::delete(JPATH_ROOT.'/components/com_einsatzkomponente/controllers/einsatzberichte_neu.php');
		}	
		
		
			// ------------------ Update -------------------------------------------------------------------------
			$db = JFactory::getDbo();
			$query = "CREATE TABLE IF NOT EXISTS #__eiko_ausruestung (id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,asset_id INT(10) UNSIGNED NOT NULL DEFAULT '0',name VARCHAR(255)  NOT NULL ,image VARCHAR(255)  NOT NULL ,beschreibung TEXT NOT NULL ,created_by INT(11)  NOT NULL ,checked_out INT(11)  NOT NULL ,checked_out_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',ordering INT(11)  NOT NULL ,state TINYINT(1)  NOT NULL ,PRIMARY KEY (id)) DEFAULT COLLATE=utf8_general_ci;";
			$db->setQuery($query);
			try {
			$result = $db->execute();
			} catch (Exception $e) {
			echo '<h2>Fehler in Query: '.$query.' : </h2>';  
			print_r ($e).'<br/><br/>';exit;
			}

			$db = JFactory::getDbo();
			$query = "CREATE TABLE IF NOT EXISTS #__eiko_tickerkat ( id int(11) unsigned NOT NULL AUTO_INCREMENT,  asset_id int(10) unsigned NOT NULL DEFAULT '0',  title varchar(255) NOT NULL,  image varchar(255) NOT NULL,  beschreibung TEXT NOT NULL,  ordering int(11) NOT NULL,  state tinyint(1) NOT NULL,  created_by int(11) NOT NULL,  checked_out int(11) NOT NULL,  checked_out_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  PRIMARY KEY (id)) DEFAULT COLLATE=utf8_general_ci;";
			$db->setQuery($query);
			try {
			$result = $db->execute();
			} catch (Exception $e) {
			echo '<h2>Fehler in Query: '.$query.' : </h2>';  
			print_r ($e).'<br/><br/>';exit;
			}
		// -------------------------------------------------------------------------------------------------
		
endif;
 
	//echo '<p>' . JText::_('Einsatzkomponente ' . $type . ' ' . $rel) . '</p>';
}



	public function postflight($type, $parent) {
	
		
   }
												
												
												
}