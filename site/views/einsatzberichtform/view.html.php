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
JLoader::import('helpers.einsatzkomponente', JPATH_SITE.'/administrator/components/com_einsatzkomponente');
JLoader::import('helpers.osm', JPATH_SITE.'/administrator/components/com_einsatzkomponente'); 
/**
 * View to edit
 */
class EinsatzkomponenteViewEinsatzberichtForm extends HtmlView {
    protected $state;
    protected $item;
    protected $form;
    protected $params;
	protected $copy;
    /**
     * Display the view
     */
    public function display($tpl = null) {
        
		$app	= Factory::getApplication();
        $user		= Factory::getUser();
       
	    $this->copy  = Factory::getApplication()->input->getInt('copy','0');

        $this->state = $this->get('State');
        $this->item = $this->get('Data');
        $this->params = $app->getParams('com_einsatzkomponente');
   		$this->form		= $this->get('Form');
		$this->gmap_config = EinsatzkomponenteHelper::load_gmap_config(); // GMap-Config aus helper laden 
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }
 
 		$document = Factory::getDocument();
		
		// Bootstrap laden
	//	HTMLHelper::_('behavior.framework', true);
		
		if ($this->params->get('display_home_bootstrap','0') == '1') :
	//	HTMLHelper::_('bootstrap.framework');
	//	$document->addStyleSheet($this->baseurl . '/media/jui/css/bootstrap.min.css');
	//	$document->addStyleSheet($this->baseurl.'/media/jui/css/icomoon.css');
		endif;
		if ($this->params->get('display_home_bootstrap','0') == '2') :
	//	$document->addStyleSheet('components/com_einsatzkomponente/assets/css/bootstrap/bootstrap.min.css');
	//	$document->addStyleSheet('components/com_einsatzkomponente/assets/css/bootstrap/bootstrap-responsive.min.css');
		endif;

	//	$document->addStyleSheet('components/com_einsatzkomponente/assets/css/einsatzkomponente.css');
		$document->addStyleDeclaration($this->params->get('edit_css','')); 


		
		// Enter-Taste abstellen
		echo '<script type="text/javascript">

function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}

document.onkeypress = stopRKey;

</script> ';

        
   //     if($this->_layout == 'edit') {
    //         $authorised = $user->authorise('core.edit', 'com_einsatzkomponente');
    //         if ($authorised !== true) {
   //            throw new Exception(JText::_('ALERTNOAUTHOR'));
   //         }
  //     }
        
 
        $this->_prepareDocument();
        parent::display($tpl);
    }
	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app	= Factory::getApplication();
		$menus	= $app->getMenu();
		$title	= null;
		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', Text::_('com_einsatzkomponente_DEFAULT_PAGE_TITLE'));
		}
		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = Text::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = Text::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
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
    
}
