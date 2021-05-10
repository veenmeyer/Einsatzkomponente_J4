<?php
/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
 
// no direct access
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;


// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_einsatzkomponente')) 
{
	throw new Exception(Text::_('ALERTNOAUTHOR'));
}

// Require specific controller if requested
if($controller = Factory::getApplication()->input->getWord('controller')) {
    $classname	= 'EinsatzkomponenteController'.$controller;
	$path = JPATH_COMPONENT.'/controllers/'.$controller.'.php';
        require_once $path;
	$classname	= 'EinsatzkomponenteController'.$controller;
	$controller = new $classname( );
    $controller->execute(Factory::getApplication()->input->get('task'));
	$controller->redirect();
}

// Include dependancies
jimport('joomla.application.component.controller');
$controller	= BaseController::getInstance('Einsatzkomponente');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
