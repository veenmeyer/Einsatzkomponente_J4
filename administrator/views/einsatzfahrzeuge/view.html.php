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
/**
 * View class for a list of Einsatzkomponente.
 */
class EinsatzkomponenteViewEinsatzfahrzeuge extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		EinsatzkomponenteHelper::addSubmenu('einsatzfahrzeuge');
        
		$this->addToolbar();
        
		$version = new JVersion;
        if ($version->isCompatible('3.0')) :
        $this->sidebar = JHtmlSidebar::render();
		endif;

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
		$state	= $this->get('State');
		$canDo	= EinsatzkomponenteHelper::getActions($state->get('filter.category_id'));
		JToolBarHelper::title(JText::_('COM_EINSATZKOMPONENTE_TITLE_EINSATZFAHRZEUGE'), 'einsatzfahrzeuge.png');
        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/einsatzfahrzeug';
        if (file_exists($formPath)) {
            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('einsatzfahrzeug.add','JTOOLBAR_NEW');
		    }
		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('einsatzfahrzeug.edit','JTOOLBAR_EDIT');
		    }
        }
		if ($canDo->get('core.edit.state')) {
            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('einsatzfahrzeuge.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('einsatzfahrzeuge.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'einsatzfahrzeuge.delete','JTOOLBAR_DELETE');
            }
            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('einsatzfahrzeuge.archive','Fahrzeug a.D.');
            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('einsatzfahrzeuge.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'einsatzfahrzeuge.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    //JToolBarHelper::trash('einsatzfahrzeuge.trash','JTOOLBAR_TRASH');
                JToolBarHelper::deleteList('', 'einsatzfahrzeuge.delete','JTOOLBAR_DELETE');
			    JToolBarHelper::divider();
		    }
        }
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_einsatzkomponente');
		}
        
		$version = new JVersion;
        if ($version->isCompatible('3.0')) :
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_einsatzkomponente&view=einsatzfahrzeuge');
		$options = array ();
		$options[] = JHtml::_('select.option', '1', 'JPUBLISHED');
		$options[] = JHtml::_('select.option', '0', 'JUNPUBLISHED');
		$options[] = JHtml::_('select.option', '2', 'Fahrzeug a.D.');
		$options[] = JHtml::_('select.option', '-2', 'JTRASHED');
		$options[] = JHtml::_('select.option', '*', 'JALL');
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.state'), true)
		);
		endif;
		
        $this->extra_sidebar = '';
        
	}
    
	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.name' => JText::_('COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_NAME'),
		'a.detail1' => JText::_('COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL1'),
		'a.detail2' => JText::_('COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL2'),
		'a.department' => JText::_('COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DEPARTMENT'),
		'a.detail3' => JText::_('COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL3'),
		'a.link' => JText::_('COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_LINK'),
		'a.image' => JText::_('COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_IMAGE'),
		'a.state' => JText::_('JSTATUS'),
		'a.created_by' => JText::_('COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_CREATED_BY'),
		);
	}
    
}
