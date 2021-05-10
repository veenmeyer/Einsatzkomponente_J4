<?php
/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
// No direct access.
defined('_JEXEC') or die;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Version;
use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;

jimport('joomla.application.component.controlleradmin');
/**
 * Organisationen list controller class.
 */
class EinsatzkomponenteControllerOrganisationen extends AdminController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'organisation', $prefix = 'EinsatzkomponenteModel', $config = [])
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    
    
	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		// Get the input
		$input = Factory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');
		// Sanitize the input
		ArrayHelper::toInteger($pks);
		ArrayHelper::toInteger($order);
		// Get the model
		$model = $this->getModel();
		// Save the ordering
		$return = $model->saveorder($pks, $order);
		if ($return)
		{
			echo "1";
		}
		// Close the application
		Factory::getApplication()->close();
	}
    
	public function delete()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));

		// Get items to remove from the request.
		$cid = Factory::getApplication()->input->get('cid', array(), 'array');
		

		if (!is_array($cid) || count($cid) < 1)
		{
			Factory::getApplication()->enqueueMessage(Text::_($this->text_prefix . '_NO_ITEM_SELECTED'), 'error');
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			ArrayHelper::toInteger($cid);

			// Remove the items.
			if ($model->delete($cid))
			{
				$this->setMessage(Text::plural($this->text_prefix . '_N_ITEMS_DELETED', count($cid)));
			}
			else
			{
				$this->setMessage($model->getError());
			}
		}
		$version = new Version;
        	if ($version->isCompatible('3.0')) :
				// Invoke the postDelete method to allow for the child class to access the model.
				$this->postDeleteHook($model, $cid);
			endif;

		$this->setRedirect(Route::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));
	}
    
}