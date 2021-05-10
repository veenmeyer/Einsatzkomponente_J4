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
use Joomla\CMS\Router\Route;

jimport('joomla.application.component.view');

/**
 * View class for a list of Einsatzkomponente.
 */
class EinsatzkomponenteViewEinsatzarchiv extends HtmlView {

    protected $items;
    protected $pagination;
    protected $state;
    protected $params;
    protected $version;

    /**
     * Display the view
     */
    public function display($tpl = null) {
		require_once JPATH_SITE.'/administrator/components/com_einsatzkomponente/helpers/einsatzkomponente.php'; // Helper-class laden
        $app = Factory::getApplication();

        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->params = $app->getParams('com_einsatzkomponente');
        $this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');


		
		$layout_detail = $this->params->get('layout_detail',''); // Detailbericht Layout
		$this->layout_detail_link = '';  
		if ($layout_detail) : $this->layout_detail_link = '&layout='.$layout_detail;  endif; // Detailbericht Layout 'default' ?

		
		$app	= Factory::getApplication();
		$menus	= $app->getMenu();
		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		
 if ($this->params->get('display_home_JSON','1')) {
	 
		foreach ( $this->items as $item )
		{
					
			//$item->auswahl_orga = str_replace(",", " +++ ", $this->auswahl_orga);
			
			if ($item->desc) :
			$item->desc = strip_tags( $item->desc);
			$item->desc = (strlen($item->desc) > $this->params->get('rss_chars','1000')) ? substr($item->desc,0,strrpos(substr($item->desc,0,$this->params->get('rss_chars','1000')+1),' ')).' ...' : $item->desc;
			endif;
			
			if (isset($item->einsatznummer)) :
			$item->einsatznummer = EinsatzkomponenteHelper::ermittle_einsatz_nummer($item->date1,$item->data1_id);
			endif;
			
			// url link to article
			// & used instead of &amp; as this is converted by feed creator
			$link = Route::_('index.php?option=com_einsatzkomponente&view=einsatzbericht'.$this->layout_detail_link.'&id='.$item->id);

			if ($item->auswahl_orga) :
			$item->auswahl_orga = str_replace(",", " +++ ", $item->auswahl_orga);
			endif;

			if ($item->date1) :
		    $item->date1 = date('d.m.Y H:i', $item->date1);
			endif;
			
/* 			if ($item->date2) :
		    $item->date2 = date('d.m.Y H:i', $item->date2);
			endif;
			if ($item->date3) :
		    $item->date3 = date('d.m.Y H:i', $item->date3);
			endif;
 */
		}

		// Set up the data to be sent in the response.
 
// Get the document object.
$document =Factory::getDocument();
 
// Set the MIME type for JSON output.
$document->setMimeEncoding('application/json');
 
// Change the suggested filename.
JResponse::setHeader('Content-Disposition','attachment;filename="einsatzarchiv.json"');
 


		
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
;
            throw new Exception(implode("\n", $errors));
        }

		// Output the JSON data.
		echo json_encode($this->items,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 }
		jexit();
        parent::display($tpl);
    }


}