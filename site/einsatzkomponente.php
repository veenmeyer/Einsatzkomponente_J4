<?php
/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Added for Joomla 3.0
if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
};

// Include dependancies
jimport('joomla.application.component.controller');
// Execute the task.
$controller	= JControllerLegacy::getInstance('Einsatzkomponente');

		$params = JComponentHelper::getParams('com_einsatzkomponente');
		
		$db = JFactory::getDbo();
		$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = "com_einsatzkomponente"');
		$parameter = json_decode( $db->loadResult(), true );
        $version = $parameter['version'];

		//------------------------------------------------------------------------
        if($version!=str_replace("Premium","",$version)):
		$params->set('eiko', '1');
		endif;  



//		$view		= JFactory::getApplication()->input->getCmd('view');
//        JFactory::getApplication()->input->set('view', $view);
//		
//		$layout		= JFactory::getApplication()->input->getCmd('layout');
//        JFactory::getApplication()->input->set('layout', $layout);
//		
//		$task		= JFactory::getApplication()->input->get('task');
//		if ($task == "einsatzbericht.edit") : 
//        JFactory::getApplication()->input->set('task', 'edit');
//		endif;
		
//		
//echo 'View :'.JFactory::getApplication()->input->get('view').'<br/>';
//echo 'Layout :'.JFactory::getApplication()->input->get('layout').'<br/>';
//echo 'Task :'.JFactory::getApplication()->input->get('task').'<br/>';
		
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
