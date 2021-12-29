<?php
/**
 * @version    CVS: 4.0.0
 * @package    Com_Einsatzkomponente
 * @author     Ralf Meyer <ralf.meyer@einsatzkomponente.de>
 * @copyright  Copyright (C) 2021. Alle Rechte vorbehalten.
 * @license    GNU General Public License Version 2 oder später; siehe LICENSE.txt
 */

namespace Eikonamespace\Component\Einsatzkomponente\Api\View\Datenexchanges;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;

/**
 * The Datenexchanges view
 *
 * @since  4.0.0
 */
class JsonApiView extends BaseApiView
{
	/**
	 * The fields to render item in the documents
	 *
	 * @var  array
	 * @since  4.0.0
	 */
	protected $fieldsToRenderItem = [
		'id', 
		'ordering', 
		'state', 
		'file', 
		'dateityp', 
		'info', 
		'createdate', 
		'updatedate', 
	];

	/**
	 * The fields to render items in the documents
	 *
	 * @var  array
	 * @since  4.0.0
	 */
	protected $fieldsToRenderList = [
		'id', 
		'ordering', 
		'state', 
		'file', 
		'dateityp', 
		'info', 
		'createdate', 
		'updatedate', 
	];
}