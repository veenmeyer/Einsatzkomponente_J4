<?php
/**
 * @version     4.0.00
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2022 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
 
// No direct access
defined('_JEXEC') or die;
use Joomla\CMS\Factory;

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
endif;
 
}



	public function postflight($type, $parent) {
		
   }
												
}