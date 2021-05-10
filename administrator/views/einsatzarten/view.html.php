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
use Joomla\CMS\Version;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Toolbar\ToolbarHelper;
jimport('joomla.application.component.view');
/**
 * View class for a list of Einsatzkomponente.
 */
class EinsatzkomponenteViewEinsatzarten extends HtmlView
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
        
		EinsatzkomponenteHelper::addSubmenu('einsatzarten');
        
		$this->addToolbar();
        
		$version = new Version;
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
		ToolbarHelper::title(Text::_('COM_EINSATZKOMPONENTE_TITLE_EINSATZARTEN'), 'einsatzarten.png');
        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/einsatzart';
        if (file_exists($formPath)) {
            if ($canDo->get('core.create')) {
			    ToolbarHelper::addNew('einsatzart.add','JTOOLBAR_NEW');
		    }
		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    ToolbarHelper::editList('einsatzart.edit','JTOOLBAR_EDIT');
		    }
        }
		if ($canDo->get('core.edit.state')) {
            if (isset($this->items[0]->state)) {
			    ToolbarHelper::divider();
			    ToolbarHelper::custom('einsatzarten.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    ToolbarHelper::custom('einsatzarten.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                ToolbarHelper::deleteList('', 'einsatzarten.delete','JTOOLBAR_DELETE');
            }
//            if (isset($this->items[0]->state)) {
//			    ToolbarHelper::divider();
//			    ToolbarHelper::archiveList('einsatzarten.archive','JTOOLBAR_ARCHIVE');
//            }
            if (isset($this->items[0]->checked_out)) {
            	ToolbarHelper::custom('einsatzarten.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    ToolbarHelper::deleteList('', 'einsatzarten.delete','JTOOLBAR_EMPTY_TRASH');
			    ToolbarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    //ToolbarHelper::trash('einsatzarten.trash','JTOOLBAR_TRASH');
				ToolbarHelper::deleteList('', 'einsatzarten.delete','JTOOLBAR_DELETE');
			    ToolbarHelper::divider();
		    }
        }
		if ($canDo->get('core.admin')) {
			ToolbarHelper::preferences('com_einsatzkomponente');
		}
        
		$version = new Version;
        if ($version->isCompatible('3.0')) :
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_einsatzkomponente&view=einsatzarten');
		$options = array ();
		$options[] = HTMLHelper::_('select.option', '1', 'JPUBLISHED');
		$options[] = HTMLHelper::_('select.option', '0', 'JUNPUBLISHED');
		$options[] = HTMLHelper::_('select.option', '*', 'JALL');
		JHtmlSidebar::addFilter(
			Text::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			HTMLHelper::_('select.options', $options, "value", "text", $this->state->get('filter.state'), true)
		);
		endif;
		
        $this->extra_sidebar = '';
        
	}
    
	protected function getSortFields()
	{
		return array(
		'a.id' => Text::_('JGRID_HEADING_ID'),
		'a.title' => Text::_('COM_EINSATZKOMPONENTE_EINSATZARTEN_TITLE'),
		'a.marker' => Text::_('COM_EINSATZKOMPONENTE_EINSATZARTEN_MARKER'),
		'a.beschr' => Text::_('COM_EINSATZKOMPONENTE_EINSATZARTEN_BESCHR'),
		'a.icon' => Text::_('COM_EINSATZKOMPONENTE_EINSATZARTEN_ICON'),
		'a.list_icon' => Text::_('COM_EINSATZKOMPONENTE_EINSATZARTEN_LIST_ICON'),
		'a.ordering' => Text::_('JGRID_HEADING_ORDERING'),
		'a.state' => Text::_('JSTATUS'),
		);
	}
    
}
