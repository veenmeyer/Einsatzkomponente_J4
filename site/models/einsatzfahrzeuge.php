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

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Einsatzkomponente records.
 *
 * @since  1.6
 */
class EinsatzkomponenteModelEinsatzfahrzeuge extends ListModel
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see        JController
	 * @since      1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'ordering', 'a.ordering',
				'name', 'a.name',
				'detail1_label', 'a.detail1_label',
				'detail1', 'a.detail1',
				'detail2_label', 'a.detail2_label',
				'detail2', 'a.detail2',
				'detail3_label', 'a.detail3_label',
				'detail3', 'a.detail3',
				'detail4_label', 'a.detail4_label',
				'detail4', 'a.detail4',
				'detail5_label', 'a.detail5_label',
				'detail5', 'a.detail5',
				'detail6_label', 'a.detail6_label',
				'detail6', 'a.detail6',
				'detail7_label', 'a.detail7_label',
				'detail7', 'a.detail7',
				'department', 'a.department',
				'ausruestung', 'a.ausruestung',
				'link', 'a.link',
				'image', 'a.image',
				'desc', 'a.desc',
				'state', 'a.state',
				'created_by', 'a.created_by',
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
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 *
	 * @since    1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = Factory::getApplication();

		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->get('list_limit'));
		$this->setState('list.limit', $limit);

		$limitstart = $app->getUserStateFromRequest('limitstart', 'limitstart', 0);
		$this->setState('list.start', $limitstart);

		if ($list = $app->getUserStateFromRequest($this->context . '.list', 'list', array(), 'array'))
		{
			foreach ($list as $name => $value)
			{
				// Extra validations
				switch ($name)
				{
					case 'fullordering':
						$orderingParts = explode(' ', $value);

						if (count($orderingParts) >= 2)
						{
							// Latest part will be considered the direction
							$fullDirection = end($orderingParts);

							if (in_array(strtoupper($fullDirection), array('ASC', 'DESC', '')))
							{
								$this->setState('list.direction', $fullDirection);
							}

							unset($orderingParts[count($orderingParts) - 1]);

							// The rest will be the ordering
							$fullOrdering = implode(' ', $orderingParts);

							if (in_array($fullOrdering, $this->filter_fields))
							{
								$this->setState('list.ordering', $fullOrdering);
							}
						}
						else
						{
							$this->setState('list.ordering', $ordering);
							$this->setState('list.direction', $direction);
						}
						break;

					case 'ordering':
						if (!in_array($value, $this->filter_fields))
						{
							$value = $ordering;
						}
						break;

					case 'direction':
						if (!in_array(strtoupper($value), array('ASC', 'DESC', '')))
						{
							$value = $direction;
						}
						break;

					case 'limit':
						$limit = $value;
						break;

					// Just to keep the default case
					default:
						$value = $value;
						break;
				}

				$this->setState('list.' . $name, $value);
			}
		}

		// Receive & set filters
		if ($filters = $app->getUserStateFromRequest($this->context . '.filter', 'filter', array(), 'array'))
		{
			foreach ($filters as $name => $value)
			{
				$this->setState('filter.' . $name, $value);
			}
		}

		$ordering = $app->input->get('filter_order');

		if (!empty($ordering))
		{
			$list             = $app->getUserState($this->context . '.list');
			$list['ordering'] = $app->input->get('filter_order');
			$app->setUserState($this->context . '.list', $list);
		}

		$orderingDirection = $app->input->get('filter_order_Dir');

		if (!empty($orderingDirection))
		{
			$list              = $app->getUserState($this->context . '.list');
			$list['direction'] = $app->input->get('filter_order_Dir');
			$app->setUserState($this->context . '.list', $list);
		}

		$list = $app->getUserState($this->context . '.list');

		if (empty($list['ordering']))
{
	$list['ordering'] = 'ordering';
}

if (empty($list['direction']))
{
	$list['direction'] = 'asc';
}

		if (isset($list['ordering']))
		{
			$this->setState('list.ordering', $list['ordering']);
		}

		if (isset($list['direction']))
		{
			$this->setState('list.direction', $list['direction']);
		}
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query
			->select(
				$this->getState(
					'list.select', 'DISTINCT a.*'
				)
			);

		$query->from('#__eiko_fahrzeuge AS a');
		
		// Join over the foreign key 'department'
		$query->select('#__eiko_organisationen_2190080.name AS organisationen_name_2190080');
		$query->join('LEFT', '#__eiko_organisationen AS #__eiko_organisationen_2190080 ON #__eiko_organisationen_2190080.id = a.department');
		// Join over the foreign key 'ausruestung'
		$query->select('#__eiko_ausruestung_2190081.name AS ausruestungen_name_2190081');
		$query->join('LEFT', '#__eiko_ausruestung AS #__eiko_ausruestung_2190081 ON #__eiko_ausruestung_2190081.id = a.ausruestung');

		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		
		if (!Factory::getUser()->authorise('core.edit.state', 'com_einsatzkomponente'))
		{
			$query->where('(a.state = 1 or a.state = 2)');
		}

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
			}
		}
		

		// Filtering department
	    $app = Factory::getApplication();
		$params = $app->getParams('com_einsatzkomponente');
		$array = array();
		$filter_orga = $params->get('filter_orga');
		
					if ($filter_orga) :
					foreach((array)$params->get('filter_orga') as $value): 
							if(!is_array($value)):
							$array[] = $value;
							endif;
					endforeach;
					
					$string = '';
					foreach($array as $value):
					$string .= 'a.department = '.$db->quote($value).' OR ';
					endforeach;
				$string = substr ( $string, 0, -3 );
			$query->where($string);
			endif;

		// Filtering ausruestung
		$filter_ausruestung = $this->state->get("filter.ausruestung");
		if ($filter_ausruestung != '') {
			$query->where("FIND_IN_SET('" . $db->quote($filter_ausruestung) . "',a.ausruestung)");
		}
		
		// Filter Menüparameter 
			        $app = Factory::getApplication();
					$params = $app->getParams('com_einsatzkomponente');
					$array = array();
					$filter_fahrzeuge = $params->get('filter_fahrzeuge');
					if ($filter_fahrzeuge) :
					foreach((array)$params->get('filter_fahrzeuge') as $value): 
							if(!is_array($value)):
							$array[] = $value;
							endif;
					endforeach;
					
					$string = '';
					foreach($array as $value):
					$string .= 'a.id = '.$db->quote($value).' OR ';
					endforeach;
				$string = substr ( $string, 0, -3 );
			$query->where($string);
			endif;

			// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->quoteName($orderCol) . ' ' . $db->escape($orderDirn));
		}

		return $query;
	}

	/**
	 * Method to get an array of data items
	 *
	 * @return  mixed An array of data on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
		
		foreach ($items as $item)
		{
			
		 if ($item->state == '2'): $item->name = $item->name.' (a.D.)';endif; // Fahrzeug ausser Dienst ?
			
			if (isset($item->department) && $item->department != '')
			{
				if (is_object($item->department))
				{
					$item->department = ArrayHelper::fromObject($item->department);
				}

				$values = (is_array($item->department)) ? $item->department : explode(',', $item->department);
				$textValue = array();

				foreach ($values as $value)
				{
					$db = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('#__eiko_organisationen')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->name;
					}
				}

				$item->department = !empty($textValue) ? implode(', ', $textValue) : $item->department;
			}			if (isset($item->ausruestung) && $item->ausruestung != '')
			{
				if (is_object($item->ausruestung))
				{
					$item->ausruestung = ArrayHelper::fromObject($item->ausruestung);
				}

				$values = (is_array($item->ausruestung)) ? $item->ausruestung : explode(',', $item->ausruestung);
				$textValue = array();

				foreach ($values as $value)
				{
					$db = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('#__eiko_ausruestung')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->name;
					}
				}

				$item->ausruestung = !empty($textValue) ? implode(', ', $textValue) : $item->ausruestung;
			}
		}

		return $items;
	}

	/**
	 * Overrides the default function to check Date fields format, identified by
	 * "_dateformat" suffix, and erases the field if it's not correct.
	 *
	 * @return void
	 */
	protected function loadFormData()
	{
		$app              = Factory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;

		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value))
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}

		if ($error_dateformat)
		{
			$app->enqueueMessage(Text::_("COM_EINSATZKOMPONENTE_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}

		return parent::loadFormData();
	}

}
