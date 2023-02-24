<?php

/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
defined('_JEXEC') or die;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;


jimport('joomla.application.component.modellist');
/**
 * Methods supporting a list of Einsatzkomponente records.
 */
class EinsatzkomponenteModelEinsatzarchiv extends ListModel
{

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'ordering', 'a.ordering',
                'alerting', 'a.alerting',
                'tickerkat', 'a.tickerkat',
                'data1', 'a.data1',
                'image', 'a.image',
     //           'images', 'a.images',
                'date1', 'a.date1',
                'year', 'a.date1',
                'date2', 'a.date2',
                'date3', 'a.date3',
                'address', 'a.address',
                'summary', 'a.summary',
                'auswahl_orga', 'a.auswahl_orga',
                'vehicles', 'a.vehicles',
     //           'ausruestung', 'a.ausruestung',
                'boss', 'a.boss',
     //           'boss_ftm', 'a.boss_ftm',
                'boss2', 'a.boss2',
     //           'boss2_ftm', 'a.boss2_ftm',
                'people', 'a.people',
     //           'people_ftm', 'a.people_ftm',
                'desc', 'a.desc',
                'gmap_report_latitude', 'a.gmap_report_latitude',
                'gmap_report_longitude', 'a.gmap_report_longitude',
                'gmap', 'a.gmap',
                'status_fb', 'a.status_fb',
                'presse_label', 'a.presse_label',
                'presse', 'a.presse',
                'presse2_label', 'a.presse2_label',
                'presse2', 'a.presse2',
                'presse3_label', 'a.presse3_label',
                'presse3', 'a.presse3',
                'updatedate', 'a.updatedate',
                'createdate', 'a.createdate',
                'einsatzticker', 'a.einsatzticker',
                'department', 'a.department',
                'notrufticker', 'a.notrufticker',
                'status', 'a.status',
                'article_id', 'a.article_id',
                'counter', 'a.counter',
                'state', 'a.state',
                'created_by', 'a.created_by',
                'modified_by', 'a.modified_by',
                'params', 'a.params',

            );
        }
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since    1.6
     */
    protected function populateState($ordering = null, $direction = null)
    {


        // Initialise variables.
        $app = Factory::getApplication();
		$params = $app->getParams('com_einsatzkomponente');
		$page_limit = $params->get('display_home_pagination_limit','');
		$show_pagination = $params->get('display_home_pagination','1');
		if (!$page_limit) : $page_limit = $app->getCfg('list_limit'); endif;
		if (!$show_pagination) : $page_limit = ''; endif; 
        // List state information
        $limit = $app->getUserStateFromRequest('list.limit', 'limit',$page_limit); 
        $this->setState('list.limit', $limit);

		// List state information
		$input = Factory::getApplication()->input;
		$limitstart = $input->getUInt('limitstart', 0);
		$this->setState('list.start', $limitstart);


		
		// Behebt Fehler : 
		// Notice: Undefined property: Joomla\CMS\Object\CMSObject::$params in /home/site/models/einsatzarchiv.php on line 115
		if (isset($this->state->params))
		{
			$params = $this->state->params;
		}		
		
		

		if ($menu = $app->getMenu()->getActive())
		{
			$menuParams = $menu->getParams();
		}
		else
		{
			$menuParams = new Registry;
		}


		$this->setState('list.limit', $limit);

		
// Filter aus Menülink abfangen 

if (!$app->input->getInt('list', 0)) : // Prüfen ob zurück aus Detailansicht
$params = $app->getParams('com_einsatzkomponente');

$this->setState('filter.year', $params->get('filter_year',''));
$app->setUserState( $this->context . '.filter.year',  $params->get('filter_year','') );

$this->setState('filter.auswahl_orga', $params->get('filter_auswahl_orga',''));
$app->setUserState( $this->context . '.filter.auswahl_orga',  $params->get('filter_auswahl_orga','') );
 
$this->setState('filter.alerting', $params->get('filter_alerting',''));
$app->setUserState( $this->context . '.filter.alerting',  $params->get('filter_alerting','') );

$this->setState('filter.tickerkat', $params->get('filter_tickerkat',''));
$app->setUserState( $this->context . '.filter.tickerkat',  $params->get('filter_tickerkat','') );

$this->setState('filter.data1', $params->get('filter_data1',''));
$app->setUserState( $this->context . '.filter.data1',  $params->get('filter_data1','') );

$this->setState('filter.vehicles', $params->get('filter_vehicles',''));
$app->setUserState( $this->context . '.filter.vehicles',  $params->get('filter_vehicles','') );

$this->setState('filter.date1_from_dateformat', $params->get('filter_date1_from_dateformat',''));
$app->setUserState( $this->context . '.filter.date1_from_dateformat',  $params->get('filter_date1_from_dateformat','') );

$this->setState('filter.date1_to_dateformat', $params->get('filter_date1_to_dateformat',''));
$app->setUserState( $this->context . '.filter.date1_to_dateformat',  $params->get('filter_date1_to_dateformat','') ); 

endif;

        // Receive & set filters
        if ($filters = $app->getUserStateFromRequest($this->context . '.filter', 'filter', array(), 'array'))
        {
		

            foreach ($filters as $name => $value)
            {
                $this->setState('filter.' . $name, $value);
				//echo 'filter.'.$name.': '.$value.'<br/>';
				
            }
        }
        $this->setState('list.ordering', $app->input->get('filter_order'));
        $this->setState('list.direction', $app->input->get('filter_order_Dir'));
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return    JDatabaseQuery
     * @since    1.6
     */
    protected function getListQuery()
    {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query
                ->select(
                        $this->getState(
                                'list.select', 'DISTINCT a.*'
                        )
        );

        $query->from('#__eiko_einsatzberichte AS a');


    // Join over the users for the checked out user.
    //$query->select('uc.name AS editor');
    //$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
    
		// Join over the foreign key 'alerting'
		$query->select('#__eiko_alarmierungsarten_1662662.title AS alarmierungsarten_title_1662662');
		$query->join('LEFT', '#__eiko_alarmierungsarten AS #__eiko_alarmierungsarten_1662662 ON #__eiko_alarmierungsarten_1662662.id = a.alerting');
		// Join over the foreign key 'tickerkat'
		$query->select('#__eiko_tickerkat_1662677.title AS einsatzkategorien_title_1662677');
		$query->join('LEFT', '#__eiko_tickerkat AS #__eiko_tickerkat_1662677 ON #__eiko_tickerkat_1662677.id = a.tickerkat');
		// Join over the foreign key 'data1'
		$query->select('#__eiko_einsatzarten_1662650.title AS einsatzarten_title_1662650');
		$query->join('LEFT', '#__eiko_einsatzarten AS #__eiko_einsatzarten_1662650 ON #__eiko_einsatzarten_1662650.id = a.data1');
		// Join over the foreign key 'images'
	//	$query->select('#__eiko_images_1662871.image AS einsatzbildmanager_image_1662871');
	//	$query->join('LEFT', '#__eiko_images AS #__eiko_images_1662871 ON #__eiko_images_1662871.id = a.images');
		// Join over the foreign key 'auswahlorga'
		$query->select('#__eiko_organisationen_1662678.name AS organisationen_name_1662678');
		$query->join('LEFT', '#__eiko_organisationen AS #__eiko_organisationen_1662678 ON #__eiko_organisationen_1662678.id = a.auswahl_orga');
		// Join over the foreign key 'vehicles'
		$query->select('#__eiko_fahrzeuge_1662679.name AS einsatzfahrzeuge_name_1662679');
		$query->join('LEFT', '#__eiko_fahrzeuge AS #__eiko_fahrzeuge_1662679 ON #__eiko_fahrzeuge_1662679.id = a.vehicles');
		// Join over the foreign key 'ausruestung'
	//	$query->select('#__eiko_ausruestung_1662798.name AS ausruestungen_name_1662798');
	//	$query->join('LEFT', '#__eiko_ausruestung AS #__eiko_ausruestung_1662798 ON #__eiko_ausruestung_1662798.id = a.ausruestung');
		// Join over the foreign key 'boss_ftm'
	//	$query->select('#__eiko_fahrzeuge_1662881.name AS einsatzfahrzeuge_name_1662881');
	//	$query->join('LEFT', '#__eiko_fahrzeuge AS #__eiko_fahrzeuge_1662881 ON #__eiko_fahrzeuge_1662881.id = a.boss_ftm');
		// Join over the foreign key 'boss2_ftm'
	//	$query->select('#__eiko_fahrzeuge_1662882.name AS einsatzfahrzeuge_name_1662882');
	//	$query->join('LEFT', '#__eiko_fahrzeuge AS #__eiko_fahrzeuge_1662882 ON #__eiko_fahrzeuge_1662882.id = a.boss2_ftm');
		// Join over the foreign key 'people_ftm'
	//	$query->select('#__eiko_fahrzeuge_1662879.name AS einsatzfahrzeuge_name_1662879');
	//	$query->join('LEFT', '#__eiko_fahrzeuge AS #__eiko_fahrzeuge_1662879 ON #__eiko_fahrzeuge_1662879.id = a.people_ftm');
		// Join over the foreign key 'article_id'
		$query->select('#__content_1662648.title AS content_title_1662648');
		$query->join('LEFT', '#__content AS #__content_1662648 ON #__content_1662648.id = a.article_id');
		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		// Join over the modified by field 'created_by'
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');
		
			$user = Factory::getUser();
			$userId = $user->get('id');
			$canCreate = $user->authorise('core.create', 'com_einsatzkomponente');
			$canEdit = $user->authorise('core.edit', 'com_einsatzkomponente');
			$canCheckin = $user->authorise('core.manage', 'com_einsatzkomponente');
			$canChange = $user->authorise('core.edit.state', 'com_einsatzkomponente');
			$canDelete = $user->authorise('core.delete', 'com_einsatzkomponente');
			
		if ($canCreate or $canEdit or $canChange or $canDelete) :
			$query->where('(a.state = 1 or a.state = 0)');
			else:
			$query->where('a.state = 1');
			endif;
			

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            if (stripos($search, 'id:') === 0)
            {
                $query->where('a.id = ' . (int) substr($search, 3));
            }
            else
            {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.address LIKE '.$search.'  OR  a.summary LIKE '.$search.'  OR  a.boss LIKE '.$search.'  OR  a.boss2 LIKE '.$search.'  OR  a.desc LIKE '.$search.' )');
            }
        }

        

		//Filtering alerting
		$filter_alerting = $this->state->get("filter.alerting");
		if ($filter_alerting) {
			$query->where("a.alerting = ".$db->quote($filter_alerting));
		}

		//Filtering tickerkat
		$filter_tickerkat = $this->state->get("filter.tickerkat");
		if ($filter_tickerkat) {
			$query->where("a.tickerkat = ".$db->quote($filter_tickerkat));
		}

		//Filtering data1
		$filter_data1 = $this->state->get("filter.data1");
		if ($filter_data1) {
			$query->where("a.data1 = ".$db->quote($filter_data1));
		}

		//Filtering date1

		//Checking "_dateformat"
		$filter_date1_from = $this->state->get("filter.date1_from_dateformat");
		if ($filter_date1_from && preg_match("/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/", $filter_date1_from) && date_create($filter_date1_from) ) {
			$query->where("a.date1 >= ".$db->quote($filter_date1_from));
		}
		$filter_date1_to = $this->state->get("filter.date1_to_dateformat");
		if ($filter_date1_to && preg_match("/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/", $filter_date1_to) && date_create($filter_date1_to) ) {
			$query->where("a.date1 <= ".$db->quote($filter_date1_to));
		}

		//Filtering auswahlorga
			$filter_auswahlorga = $this->state->get("filter.auswahl_orga"); 
//			if ($filter_auswahlorga) {
//			$query->where("FIND_IN_SET(" . $filter_auswahlorga. ",a.auswahl_orga)");
//		 }

		// Filter Menüparameter auswahlorga
			if ($filter_auswahlorga) {
			        $app = Factory::getApplication();
					$params = $app->getParams('com_einsatzkomponente');
					$array = array();
					if (count($filter_auswahlorga)>1) :
					
					$string = '';
					foreach($filter_auswahlorga  as $value):
					if (count($filter_auswahlorga)>1 AND $value) :
					$string .= "FIND_IN_SET(" . $db->quote($value) . ",a.auswahl_orga) OR ";
					endif;
					endforeach;
				$string = substr ( $string, 0, -3 );
				$query->where($string);
				else:
				$query->where("FIND_IN_SET(" . $db->quote($filter_auswahlorga['0']) . ",a.auswahl_orga)");
				endif;
			}
		 
		//Filtering vehicles
		$filter_vehicles = $this->state->get("filter.vehicles");
		if ($filter_vehicles) {
			$query->where("FIND_IN_SET(" . $db->quote($filter_vehicles) . ",a.vehicles)");
		}

		//Filtering ausruestung
	//	$filter_ausruestung = $this->state->get("filter.ausruestung");
	//	if ($filter_ausruestung) {
	//		$query->where("FIND_IN_SET(" . $filter_ausruestung. ",a.ausruestung)");
	//	}

		//Filtering boss_ftm
	//	$filter_boss_ftm = $this->state->get("filter.boss_ftm");
	//	if ($filter_boss_ftm) {
	//		$query->where("a.boss_ftm = '".$db->escape($filter_boss_ftm)."'");
	//	}

		//Filtering boss2_ftm
	//	$filter_boss2_ftm = $this->state->get("filter.boss2_ftm");
	//	if ($filter_boss2_ftm) {
	//		$query->where("a.boss2_ftm = '".$db->escape($filter_boss2_ftm)."'");
	//	}

		//Filtering people_ftm
	//	$filter_people_ftm = $this->state->get("filter.people_ftm");
	//	if ($filter_people_ftm) {
	//		$query->where("FIND_IN_SET(" . $filter_people_ftm. ",a.people_ftm)");
	//	}

		//Filtering created_by
		$filter_created_by = $this->state->get("filter.created_by");
		if ($filter_created_by) {
			$query->where("a.created_by = ".$db->quote($filter_created_by));
		}
		//Filtering created_by
		$filter_modified_by = $this->state->get("filter.modified_by");
		if ($filter_modified_by) {
			$query->where("a.modified_by = ".$db->quote($filter_modified_by));
		}

		//Filtering year
		$filter_year = $this->state->get("filter.year");
		if ($filter_year) {
			$query->where("a.date1 LIKE ".$db->quote($db->escape($filter_year) . "%"));
		}

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn)
        {
            //$query->order($db->escape($orderCol . ' ' . $orderDirn));
        }
            $query->order($db->escape('a.date1' . ' ' . 'DESC'));
        return $query;
    }

    public function getItems()
    {
		//$items = parent::getItems();
		
		// Get a storage key.
		$store = $this->getStoreId();

		// Try to load the data from internal storage.
		if (isset($this->cache[$store]))
		{
			return $this->cache[$store];
		}

		// Load the list items.
		$query = $this->_getListQuery();

		try
		{
			$items = $this->_getList($query, $this->getStart(), $this->getState('list.limit'));
		}
		catch (RuntimeException $e)
		{
			$this->setError($e->getMessage());

			return false;
		}


		// Add the items to the internal cache.
		$this->cache[$store] = $items;

        foreach($items as $item){
	

			if ($item->date1) {
				$item->date1 		= strtotime($item->date1);
				$item->date1_month 	= date('n', $item->date1);
				$item->date1_year 	= date('Y', $item->date1);
			}
	
	
	
	
	
			if (isset($item->alerting) && $item->alerting != '') {
					$db = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('title,image')
							->from('#__eiko_alarmierungsarten')
							->where('id = ' . $db->quote($db->escape($item->alerting)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$item->alerting = $results->title;
						$item->alerting_image = $results->image;
					}
			}

			if (isset($item->tickerkat) && $item->tickerkat != '') {
					$db = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('title,image')
							->from('#__eiko_tickerkat')
							->where('id = ' . $db->quote($db->escape($item->tickerkat)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$item->tickerkat = $results->title;
						$item->tickerkat_image = $results->image;
					}
			}

			if (isset($item->data1) && $item->data1 != '') {
					$db = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('id,title,list_icon,marker,icon')
							->from('#__eiko_einsatzarten')
							->where('id = ' . $db->quote($db->escape($item->data1)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$item->data1 = $results->title;
						$item->data1_id = $results->id;
						$item->list_icon = $results->list_icon;
						$item->icon = $results->icon;
						$item->marker = $results->marker;
					}
			}

			

					$db = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('count(image)')
							->from('#__eiko_images')
							->where('report_id = ' . $item->id);
					$db->setQuery($query);
					$item->images = $db->loadResult();
			if ($item->image) { $item->images = $item->images +1;}
					
					
					
			if (isset($item->auswahl_orga) && $item->auswahl_orga != '') {
				if(is_object($item->auswahl_orga)){
					$item->auswahl_orga = JArrayHelper::fromObject($item->auswahl_orga);
				}
				$values = (is_array($item->auswahl_orga)) ? $item->auswahl_orga : explode(',',$item->auswahl_orga);

				$textValue = array();
				foreach ($values as $value){
					$db = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('#__eiko_organisationen')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->auswahl_orga = !empty($textValue) ? implode(', ', $textValue) : $item->auswahl_orga;

			}

			if (isset($item->vehicles) && $item->vehicles != '') {
				if(is_object($item->vehicles)){
					$item->vehicles = JArrayHelper::fromObject($item->vehicles);
				}
				$values = (is_array($item->vehicles)) ? $item->vehicles : explode(',',$item->vehicles);

				$textValue = array();
				foreach ($values as $value){
					$db = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('#__eiko_fahrzeuge')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->vehicles = !empty($textValue) ? implode(', ', $textValue) : $item->vehicles;

			}

	//		if (isset($item->ausruestung) && $item->ausruestung != '') {
	//			if(is_object($item->ausruestung)){
	//				$item->ausruestung = JArrayHelper::fromObject($item->ausruestung);
	//			}
	//			$values = (is_array($item->ausruestung)) ? $item->ausruestung : explode(',',$item->ausruestung);

	//			$textValue = array();
	//			foreach ($values as $value){
	//				$db = JFactory::getDbo();
	//				$query = $db->getQuery(true);
	//				$query
	//						->select('name')
	//						->from('#__eiko_ausruestung')
	//						->where('id = ' . $db->quote($db->escape($value)));
	//				$db->setQuery($query);
	//				$results = $db->loadObject();
	//				if ($results) {
	//					$textValue[] = $results->name;
	//				}
	//			}

	//		$item->ausruestung = !empty($textValue) ? implode(', ', $textValue) : $item->ausruestung;

	//		}

	//		if (isset($item->boss_ftm) && $item->boss_ftm != '') {
	//			if(is_object($item->boss_ftm)){
	//				$item->boss_ftm = JArrayHelper::fromObject($item->boss_ftm);
	//			}
	//			$values = (is_array($item->boss_ftm)) ? $item->boss_ftm : explode(',',$item->boss_ftm);

	//			$textValue = array();
	//			foreach ($values as $value){
	//				$db = JFactory::getDbo();
	//				$query = $db->getQuery(true);
	//				$query
	//						->select('name')
	//						->from('#__eiko_fahrzeuge')
	//						->where('id = ' . $db->quote($db->escape($value)));
	//				$db->setQuery($query);
	//				$results = $db->loadObject();
	//				if ($results) {
	//					$textValue[] = $results->name;
	//				}
	//			}

	//		$item->boss_ftm = !empty($textValue) ? implode(', ', $textValue) : $item->boss_ftm;

	//		}

	//		if (isset($item->boss2_ftm) && $item->boss2_ftm != '') {
	//			if(is_object($item->boss2_ftm)){
	//				$item->boss2_ftm = JArrayHelper::fromObject($item->boss2_ftm);
	//			}
	//			$values = (is_array($item->boss2_ftm)) ? $item->boss2_ftm : explode(',',$item->boss2_ftm);

	//			$textValue = array();
	//			foreach ($values as $value){
	//				$db = JFactory::getDbo();
	//				$query = $db->getQuery(true);
	//				$query
	//						->select('name')
	//						->from('#__eiko_fahrzeuge')
	//						->where('id = ' . $db->quote($db->escape($value)));
	//				$db->setQuery($query);
	//				$results = $db->loadObject();
	//				if ($results) {
	//					$textValue[] = $results->name;
	//				}
	//			}

	//		$item->boss2_ftm = !empty($textValue) ? implode(', ', $textValue) : $item->boss2_ftm;

	//		}

	//		if (isset($item->people_ftm) && $item->people_ftm != '') {
	//			if(is_object($item->people_ftm)){
	//				$item->people_ftm = JArrayHelper::fromObject($item->people_ftm);
	//			}
	//			$values = (is_array($item->people_ftm)) ? $item->people_ftm : explode(',',$item->people_ftm);

	//			$textValue = array();
	//			foreach ($values as $value){
	//				$db = JFactory::getDbo();
	//				$query = $db->getQuery(true);
	//				$query
	//						->select('name')
	//						->from('#__eiko_fahrzeuge')
	//						->where('id = ' . $db->quote($db->escape($value)));
	//				$db->setQuery($query);
	//				$results = $db->loadObject();
	//				if ($results) {
	//					$textValue[] = $results->name;
	//				}
	//			}

	//		$item->people_ftm = !empty($textValue) ? implode(', ', $textValue) : $item->people_ftm;

	//		}
					$item->status_fb = Text::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_STATUS_FB_OPTION_' . strtoupper($item->status_fb));
					$item->status = Text::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_STATUS_OPTION_' . strtoupper($item->status));

			if (isset($item->article_id) && $item->article_id != '') {
				if(is_object($item->article_id)){
					$item->article_id = JArrayHelper::fromObject($item->article_id);
				}
				$values = (is_array($item->article_id)) ? $item->article_id : explode(',',$item->article_id);

				$textValue = array();
				foreach ($values as $value){
					$db = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('title')
							->from('#__content')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$item->article_id = !empty($textValue) ? implode(', ', $textValue) : $item->article_id;

			}
}
        return $items;
    }
	

	

    /**
     * Overrides the default function to check Date fields format, identified by
     * "_dateformat" suffix, and erases the field if it's not correct.
     */
    protected function loadFormData()
    {
        $app = Factory::getApplication();
        $filters = $app->getUserState($this->context . '.filter', array());
        $error_dateformat = false;
        foreach ($filters as $key => $value)
        {
            if (strpos($key, '_dateformat') && !empty($value) && !$this->isValidDate($value))
            {
                $filters[$key] = '';
                $error_dateformat = true;
            }
        }
        if ($error_dateformat)
        {
            $app->enqueueMessage(Text::_("COM_PRUEBA_SEARCH_FILTER_DATE_FORMAT"), "warning");
            $app->setUserState($this->context . '.filter', $filters);
        }

        return parent::loadFormData();
    }

    /**
     * Checks if a given date is valid and in an specified format (YYYY-MM-DD) 
     * 
     * @param string Contains the date to be checked
     * 
     */
    private function isValidDate($date)
    {
        return preg_match("/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/", $date) && date_create($date);
    }
	
	
	

}
