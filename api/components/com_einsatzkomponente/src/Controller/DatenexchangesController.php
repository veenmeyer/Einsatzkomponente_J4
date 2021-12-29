<?php
/**
 * @version    CVS: 4.0.0
 * @package    Com_Einsatzkomponente
 * @author     Ralf Meyer <ralf.meyer@einsatzkomponente.de>
 * @copyright  Copyright (C) 2021. Alle Rechte vorbehalten.
 * @license    GNU General Public License Version 2 oder später; siehe LICENSE.txt
 */
namespace Eikonamespace\Component\Einsatzkomponente\Api\Controller;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\ApiController;

/**
 * The Datenexchanges controller
 *
 * @since  4.0.0
 */
class DatenexchangesController extends ApiController 
{
	/**
	 * The content type of the item.
	 *
	 * @var    string
	 * @since  4.0.0
	 */
	protected $contentType = 'datenexchanges';

	/**
	 * The default view for the display method.
	 *
	 * @var    string
	 * @since  3.0
	 */
	protected $default_view = 'datenexchanges';
}