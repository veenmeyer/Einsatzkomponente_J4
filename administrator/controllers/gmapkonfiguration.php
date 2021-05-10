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
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

jimport('joomla.application.component.controllerform');

/**
 * Gmapkonfiguration controller class.
 */
class EinsatzkomponenteControllerGmapkonfiguration extends FormController
{

    function __construct() {
        $this->view_list = 'gmapkonfigurationen';
        $this->view = 'gmapkonfiguration';
        parent::__construct();
    }

 public function reset ()
    {
		$reports_gmap_gmap_id = '1';
		$reports_gmap_gmap_zoom_level = '12';
		$reports_gmap_gmap_zoom_control = '';
		$reports_gmap_gmap_zoom = '12';
		$reports_gmap_gmap_onload = 'HYBRID';
		$reports_gmap_gmap_width = '600';
		$reports_gmap_gmap_height = '300';
		$reports_gmap_gmap_alarmarea = '53.28071418254047,7.416630163574155|53.294772929932165,7.4492458251952485|53.29815865222114,7.4767116455077485|53.31313468829642,7.459888830566342|53.29949234792138,7.478256597900327|53.29815865222114,7.506409063720639|53.286461382800795,7.521686926269467|53.26726681991669,7.499027624511655|';
		$reports_gmap_start_lat = '53.286871867528056';
		$reports_gmap_start_lang = '7.475510015869147';
		$reports_gmap_showall = '1';
		$reports_gmap_gmap_zoom_level_home = '12';
		$reports_gmap_gmap_max_zoom = '14';
		
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->update("#__eiko_gmap_config");
		
		$query->set('
		gmap_zoom_level = "'.$reports_gmap_gmap_zoom_level.'",
		gmap_onload = "'.$reports_gmap_gmap_onload.'",
		gmap_width = "'.$reports_gmap_gmap_width.'",
		gmap_height = "'.$reports_gmap_gmap_height.'",
		gmap_alarmarea = "'.$reports_gmap_gmap_alarmarea.'",
		start_lat = "'.$reports_gmap_start_lat.'",
		start_lang = "'.$reports_gmap_start_lang.'",
		state = "1",
		created_by ="1" ' );
		
		$query->where('id = "1" ');
		//var_dump((string) $query);exit;
		$db->setQuery($query);
		try
		{
			$db->execute();
		}
		catch (RuntimeException $e)
		{
			throw new Exception($e->getMessage(), 500);
		}
	
		$this->setMessage('Alle GMAP-Daten wurden auf Anfangseinstellungen zurückgesetzt');
		$this->setRedirect(Route::_('index.php?option=' . $this->option . '&view=' . $this->view.'&layout=edit&id=1', false));
    }	


}