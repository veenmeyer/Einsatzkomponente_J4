<?php

/**
 * @version    CVS: 3.0.0
 * @package    Com_Einsatzkomponente
 * @author     Ralf Meyer <webmaster@feuerwehr-veenhusen.de>
 * @copyright  Copyright (C) 2013 by Ralf Meyer. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Factory;
use Joomla\CMS\Categories\Categories;

/**
 * Class EinsatzkomponenteRouter
 *
 */
class EinsatzkomponenteRouter extends RouterView
{
	private $noIDs;
	public function __construct($app = null, $menu = null)
	{
		$params = JComponentHelper::getComponent('com_einsatzkomponente')->params;
		$this->noIDs = (bool) $params->get('sef_ids');
		
		$einsatzarchiv = new RouterViewConfiguration('einsatzarchiv');
		$this->registerView($einsatzarchiv);
			$einsatzbericht = new RouterViewConfiguration('einsatzbericht');
			$einsatzbericht->setKey('id')->setParent($einsatzarchiv);
			$this->registerView($einsatzbericht);
			$einsatzberichtform = new RouterViewConfiguration('einsatzberichtform');
			$einsatzberichtform->setKey('id');
			$this->registerView($einsatzberichtform);

		parent::__construct($app, $menu);

		$this->attachRule(new MenuRules($this));

		if ($params->get('sef_advanced', 0))
		{
			$this->attachRule(new StandardRules($this));
			$this->attachRule(new NomenuRules($this));
		}
		else
		{
			JLoader::register('EinsatzkomponenteRulesLegacy', __DIR__ . '/helpers/legacyrouter.php');
			JLoader::register('EinsatzkomponenteHelpersEinsatzkomponente', __DIR__ . '/helpers/einsatzkomponente.php');
			$this->attachRule(new EinsatzkomponenteRulesLegacy($this));
		}
	}


	
		/**
		 * Method to get the segment(s) for an einsatzbericht
		 *
		 * @param   string  $id     ID of the einsatzbericht to retrieve the segments for
		 * @param   array   $query  The request that is built right now
		 *
		 * @return  array|string  The segments of this item
		 */
		public function getEinsatzberichtSegment($id, $query)
		{
			return array((int) $id => $id);
		}
			/**
			 * Method to get the segment(s) for an einsatzberichtform
			 *
			 * @param   string  $id     ID of the einsatzberichtform to retrieve the segments for
			 * @param   array   $query  The request that is built right now
			 *
			 * @return  array|string  The segments of this item
			 */
			public function getEinsatzberichtformSegment($id, $query)
			{
				return $this->getEinsatzberichtSegment($id, $query);
			}

	
		/**
		 * Method to get the segment(s) for an einsatzbericht
		 *
		 * @param   string  $segment  Segment of the einsatzbericht to retrieve the ID for
		 * @param   array   $query    The request that is parsed right now
		 *
		 * @return  mixed   The id of this item or false
		 */
		public function getEinsatzberichtId($segment, $query)
		{
			return (int) $segment;
		}
			/**
			 * Method to get the segment(s) for an einsatzberichtform
			 *
			 * @param   string  $segment  Segment of the einsatzberichtform to retrieve the ID for
			 * @param   array   $query    The request that is parsed right now
			 *
			 * @return  mixed   The id of this item or false
			 */
			public function getEinsatzberichtformId($segment, $query)
			{
				return $this->getEinsatzberichtId($segment, $query);
			}
}
