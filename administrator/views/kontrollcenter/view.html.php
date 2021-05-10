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
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
jimport('joomla.application.component.view');
/**
 * View class for a list of Einsatzkomponente.
 */
class EinsatzkomponenteViewKontrollcenter extends HtmlView
{
	protected $items;
	protected $pagination;
	protected $state;
	protected $params;
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->params = ComponentHelper::getParams('com_einsatzkomponente');
		
		//$this->gmap_config = EinsatzkomponenteHelper::load_gmap_config(); // GMap-Config aus helper laden 
		
		// Check for errors.
		// if (count($errors = $this->get('Errors'))) {
			// throw new Exception(implode("\n", $errors));
		// }
        
		EinsatzkomponenteHelper::addSubmenu('kontrollcenter');
        
		$this->addToolbar();
		
        $this->sidebar = JHtmlSidebar::render();
		
		parent::display($tpl);
	}
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/einsatzkomponente.php';
		JToolBarHelper::title(Text::_('COM_EINSATZKOMPONENTE_TITLE_KONTROLLCENTER'), 'organisationen.png');
		JToolBarHelper::preferences('com_einsatzkomponente');
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_einsatzkomponente&view=kontrollcenter');
		
        $this->extra_sidebar = ''; 
        
        
	}
    
    
}
