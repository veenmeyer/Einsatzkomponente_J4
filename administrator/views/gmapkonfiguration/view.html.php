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

jimport('joomla.application.component.view');
JLoader::import('helpers.einsatzkomponente', JPATH_SITE.'/administrator/components/com_einsatzkomponente');
JLoader::import('helpers.osm', JPATH_SITE.'/administrator/components/com_einsatzkomponente'); 


/**
 * View to edit
 */
class EinsatzkomponenteViewGmapkonfiguration extends JViewLegacy
{
	protected $state;
	protected $item;
	protected $form;
	protected $params;
	protected $gmap_config;
	protected $einsatzgebiet;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');
		$this->params = JComponentHelper::getParams('com_einsatzkomponente');

		$this->gmap_config = EinsatzkomponenteHelper::load_gmap_config(); // GMap-Config aus helper laden 

	  	 $alarmareas1  = $this->gmap_config->gmap_alarmarea;  // Einsatzgebiet  ---->
	 	 $alarmareas = explode('|', $alarmareas1);
	     $this->einsatzgebiet='[';
		  for($i = 0; $i < count($alarmareas)-1; $i++)
		  {
			  	  $areas = explode(',', $alarmareas[$i]);
				  $this->einsatzgebiet=$this->einsatzgebiet.'['.$areas[0].','.$areas[1].'],';
		  }
		$areas = explode(',', $alarmareas[0]);
		//$this->einsatzgebiet=$this->einsatzgebiet.'['.$areas[0].','.$areas[1].'],';
	    $this->einsatzgebiet=substr($this->einsatzgebiet,0,strlen($this->einsatzgebiet)-1);
	    $this->einsatzgebiet=$this->einsatzgebiet.']';	
		
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
        if (isset($this->item->checked_out)) {
		    $checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        } else {
            $checkedOut = false;
        }
		$canDo		= EinsatzkomponenteHelper::getActions();

		JToolBarHelper::title(JText::_('COM_EINSATZKOMPONENTE_TITLE_GMAPKONFIGURATION'), 'gmapkonfiguration.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit')||($canDo->get('core.create'))))
		{

			JToolBarHelper::apply('gmapkonfiguration.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('gmapkonfiguration.save', 'JTOOLBAR_SAVE');
		}
		if (empty($this->item->id)) {
			JToolBarHelper::cancel('gmapkonfiguration.cancel', 'JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('gmapkonfiguration.cancel', 'JTOOLBAR_CLOSE');
		}
		
		JToolBarHelper::divider();
		
		if (!$checkedOut && ($canDo->get('core.admin'))){
			JToolBarHelper::custom('gmapkonfiguration.reset', 'refresh.png', 'refresh_f2.png', 'COM_EINSATZKOMPONENTE_GMAP_ALLE_WERTE_ZURUECKSETZEN', false);		}


	}
}
