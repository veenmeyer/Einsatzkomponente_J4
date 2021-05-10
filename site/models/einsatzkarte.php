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
jimport('joomla.application.component.modellist');
/**
 * Methods supporting a list of Einsatzkomponente records.
 */
class EinsatzkomponenteModelEinsatzkarte extends ListModel {
    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }
    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {
        
        // Initialise variables.
        $app = Factory::getApplication();
        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $this->setState('list.limit', $limit);
        $limitstart = Factory::getApplication()->input->getInt('limitstart', 0);
        $this->setState('list.start', $limitstart);
        
        
		if(empty($ordering)) {
			$ordering = 'a.ordering';
		}
        
        // List state information.
        parent::populateState($ordering, $direction);
    }
    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'a.*'
                )
        );
        
        $query->from('#__eiko_einsatzberichte AS a');
        
		// Join over the foreign key 'auswahl_orga'
		$query->select('dep.name AS mission_orga');
		$query->select('dep.ordering AS department_ordering');
		$query->join('LEFT', '#__eiko_organisationen AS dep ON dep.name = a.auswahl_orga');
		// Join over the foreign key 'vehicles'
		$query->select('veh.name AS mission_car');
		$query->select('veh.ordering AS vehicle_ordering');
		$query->join('LEFT', '#__eiko_fahrzeuge AS veh ON veh.id = a.vehicles');
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('( a.address LIKE '.$search.'  OR  a.summary LIKE '.$search.'  OR  a.boss LIKE '.$search.'  OR  a.boss2 LIKE '.$search.'  OR  a.desc LIKE '.$search.' )');
			}
		}
        
		//Filtering data1
		//Filtering alerting
		//Filtering updatedate
		$filter_updatedate_from = $this->state->get("filter.updatedate.from");
		if ($filter_updatedate_from) {
			$query->where("a.updatedate >= '".$filter_updatedate_from."'");
		}
		$filter_updatedate_to = $this->state->get("filter.updatedate.to");
		if ($filter_updatedate_to) {
			$query->where("a.updatedate <= '".$filter_updatedate_to."'");
		}
		//Filtering auswahl_orga
		$filter_auswahl_orga = $this->state->get("filter.auswahl_orga");
		if ($filter_auswahl_orga) {
			$query->where("a.auswahl_orga = '".$filter_auswahl_orga."'");
		}
		//Filtering created_by
		$filter_created_by = $this->state->get("filter.created_by");
		if ($filter_created_by) {
			$query->where("a.created_by = '".$filter_created_by."'");
		}        
        
        return $query;
    }
}
