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
class EinsatzkomponenteViewEinsatzbildmanager extends JViewLegacy
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
		$this->authors	= $this->get('Authors');
		$this->params = JComponentHelper::getParams('com_einsatzkomponente');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		EinsatzkomponenteHelper::addSubmenu('einsatzbildmanager');
        
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
		JToolBarHelper::title(JText::_('COM_EINSATZKOMPONENTE_TITLE_EINSATZBILDMANAGER'), 'einsatzbildmanager.png');
        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/einsatzbilderbearbeiten';
        if (file_exists($formPath)) {
            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('einsatzbilderbearbeiten.add','JTOOLBAR_NEW');
		    }
		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('einsatzbilderbearbeiten.edit','JTOOLBAR_EDIT');
		    }
        }
		if ($canDo->get('core.edit.state')) {
            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('einsatzbildmanager.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('einsatzbildmanager.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'einsatzbildmanager.delete','JTOOLBAR_DELETE');
            }
//            if (isset($this->items[0]->state)) {
//			    JToolBarHelper::divider();
//			    JToolBarHelper::archiveList('einsatzbildmanager.archive','JTOOLBAR_ARCHIVE');
//            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('einsatzbildmanager.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
			JToolBarHelper::custom( 'einsatzbildmanager.thumb', 'edit','edit', 'Thumbs erstellen',  true );
		
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'einsatzbildmanager.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    //JToolBarHelper::trash('einsatzbildmanager.trash','JTOOLBAR_TRASH');
                JToolBarHelper::deleteList('', 'einsatzbildmanager.delete','JTOOLBAR_DELETE');
			    JToolBarHelper::divider();
		    }
        }
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_einsatzkomponente');
		}
    
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_einsatzkomponente&view=einsatzbildmanager');
        
		
		//Filter for the field created_by
		$this->extra_sidebar = '<div class="div_side_filter">';
		$this->extra_sidebar .= '<small><label for="filter_created_by">Erstellt von</label></small>';
		$this->extra_sidebar .= JHtmlList::users('filter_created_by', $this->state->get('filter.created_by'), 1, 'onchange="this.form.submit();"');
		$this->extra_sidebar .= '</div>';

		$options = array ();
		$options[] = JHtml::_('select.option', '1', 'JPUBLISHED');
		$options[] = JHtml::_('select.option', '0', 'JUNPUBLISHED');
		$options[] = JHtml::_('select.option', '*', 'JALL');
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.state'), true)
		);
	}
    
	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.image' => JText::_('COM_EINSATZKOMPONENTE_EINSATZBILDMANAGER_IMAGE'),
		'a.report_id' => JText::_('COM_EINSATZKOMPONENTE_EINSATZBILDMANAGER_REPORT_ID'),
		'a.comment' => JText::_('COM_EINSATZKOMPONENTE_EINSATZBILDMANAGER_COMMENT'),
		'a.thumb' => JText::_('COM_EINSATZKOMPONENTE_EINSATZBILDMANAGER_THUMB'),
		'a.state' => JText::_('JSTATUS'),
		'a.created_by' => JText::_('COM_EINSATZKOMPONENTE_EINSATZBILDMANAGER_CREATED_BY'),
		);
	}
    
}
