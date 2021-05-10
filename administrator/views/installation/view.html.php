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
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
jimport('joomla.application.component.view');
class EinsatzkomponenteViewInstallation extends HtmlView
{
  function display($tpl = null) 
  {
    $this->addToolBar();
 
    // Display the template
    parent::display($tpl);
  }
        
	protected function addToolbar()
	{
		Factory::getApplication()->input->set('hidemainmenu', true);
		JToolBarHelper::title(Text::_('Installationsmanager'), 'upload');
	}
	
	
}
?>
