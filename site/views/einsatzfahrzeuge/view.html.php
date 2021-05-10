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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

jimport('joomla.application.component.view');

/**
 * View class for a list of Einsatzkomponente.
 *
 * @since  1.6
 */
class EinsatzkomponenteViewEinsatzfahrzeuge extends HtmlView
{
	protected $items;
	protected $pagination;
	protected $state;
	protected $params;
    protected $version;
	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		require_once JPATH_SITE.'/administrator/components/com_einsatzkomponente/helpers/einsatzkomponente.php'; // Helper-class laden
		$app = Factory::getApplication();

		$this->state      = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->params     = $app->getParams('com_einsatzkomponente');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		//Komponentenversion aus Datenbank lesen
		$this->version 		= EinsatzkomponenteHelper::getVersion (); 

		$document = Factory::getDocument();

        // Import CSS
		$document->addStyleSheet('components/com_einsatzkomponente/assets/css/einsatzkomponente.css');
		$document->addStyleSheet('components/com_einsatzkomponente/assets/css/responsive.css');
		// Bootstrap laden
		HTMLHelper::_('behavior.framework', true);
		
		if ($this->params->get('display_fahrzeuge_bootstrap','0') == '1') :
		HTMLHelper::_('bootstrap.framework');
		$document->addStyleSheet($this->baseurl . '/media/jui/css/bootstrap.min.css');
		$document->addStyleSheet($this->baseurl.'/media/jui/css/icomoon.css');
		endif;
		if ($this->params->get('display_fahrzeuge_bootstrap','0') == '2') :
		$document->addStyleSheet('components/com_einsatzkomponente/assets/css/bootstrap/bootstrap.min.css');
		$document->addStyleSheet('components/com_einsatzkomponente/assets/css/bootstrap/bootstrap-responsive.min.css');
		endif;
		
		// Import CSS aus Optionen
		$document->addStyleDeclaration($this->params->get('fahrzeuge_css','')); 
		
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		$this->_prepareDocument();
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function _prepareDocument()
	{
		$app   = Factory::getApplication();
		$menus = $app->getMenu();
		$title = null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', Text::_('COM_EINSATZKOMPONENTE_DEFAULT_PAGE_TITLE'));
		}

		$title = $this->params->get('page_title', '');

		if (empty($title))
		{
			$title = $app->get('sitename');
		}
		elseif ($app->get('sitename_pagetitles', 0) == 1)
		{
			$title = Text::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		}
		elseif ($app->get('sitename_pagetitles', 0) == 2)
		{
			$title = Text::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}

	/**
	 * Check if state is set
	 *
	 * @param   mixed  $state  State
	 *
	 * @return bool
	 */
	public function getState($state)
	{
		return isset($this->state->{$state}) ? $this->state->{$state} : false;
	}
}
