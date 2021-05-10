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

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Einsatzbericht controller class.
 */
class EinsatzkomponenteControllerEinsatzberichtForm extends EinsatzkomponenteController
{

	/**
	 * Method to check out an item for editing and redirect to the edit form.
	 *
	 * @since	1.6
	 */
	public function edit()
	{
		$app			= JFactory::getApplication();

		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_einsatzkomponente.edit.einsatzbericht.id');
		$editId	= JFactory::getApplication()->input->getInt('id', null, 'array');
		// Set the user id for the user to edit in the session.
		$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.id', $editId);

		// Get the model.
		$model = $this->getModel('EinsatzberichtForm', 'EinsatzkomponenteModel');

		// Check out the item
		if ($editId) {
            $model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId) {
            $model->checkin($previousId);
		}

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzberichtform&layout=edit', false));
	}

	/**
	 * Method to save a user's profile data.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function save()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model = $this->getModel('EinsatzberichtForm', 'EinsatzkomponenteModel');

		// Get the user data.
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');

		// Validate the posted data.
		$form = $model->getForm();
		if (!$form) {
			throw new Exception($model->getError(), 500);
			return false;
		}

		// Validate the posted data.
		$data = $model->validate($form, $data);

		// Check for errors.
		if ($data === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_einsatzkomponente.edit.einsatzbericht.id');
			$this->setRedirect(JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&layout=edit&id='.$id, false));
			return false;
		}

		// Attempt to save the data.
		$return	= $model->save($data);

		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.data', $data);

			// Redirect back to the edit screen.
			$id = (int)$app->getUserState('com_einsatzkomponente.edit.einsatzbericht.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&layout=edit&id='.$id, false));
			return false;
		}

            
        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }
        
        // Clear the profile id from the session.
        $app->setUserState('com_einsatzkomponente.edit.einsatzbericht.id', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('Item saved successfully'));
        $menu = JFactory::getApplication()->getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));

		// Flush the data from the session.
		$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.data', null);
	}
    
    
    function cancel() {
		$menu = & JFactory::getApplication()->getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));
    }
	
    function publish() {
		// Initialise variables.
		$app	= JFactory::getApplication();
		$model = $this->getModel('EinsatzberichtForm', 'EinsatzkomponenteModel');

        // Get the user data.
        $data = array();
        $data['id'] = $app->input->getInt('id');
        $data['state'] = $app->input->getInt('state');
		
        // Check for errors.
        if (empty($data['id'])) {
            // Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                } else {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

			
			// Save the data in the session.
			$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_einsatzkomponente.edit.einsatzbericht.id');
			$this->setRedirect(JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&layout=edit&id='.$id, false));
			return false;
		}

		
		
		if ($data['id']):
		$db		= JFactory::getDBO();
		$query	= $db->getQuery(true);
		$query->update('#__eiko_einsatzberichte');
		$query->set('state = "'.$data['state'].'" ');
		$query->where('id ="'.$data['id'].'"');
		$db->setQuery((string) $query);
		try
		{
			$db->execute();
			$return = true;
		}
		catch (RuntimeException $e)
		{
			throw new Exception($e->getMessage(), 500);
		}
		endif;


		// Attempt to save the data.
		//$return	= $model->save($data);

		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.data', $data);

			// Redirect back to the edit screen.
			$id = (int)$app->getUserState('com_einsatzkomponente.edit.einsatzbericht.id');
			$this->setMessage(JText::sprintf('Status konnte nicht geändert werden', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&layout=edit&id='.$id, false));
			return false;
		}

            
        
        // Clear the profile id from the session.
        //$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.id', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('Status erfolgreich geändert'));
        $menu = & JFactory::getApplication()->getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));

		// Flush the data from the session.
		$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.data', null);
    }
	
	public function remove()
	{
		// Initialise variables.
		$app	= JFactory::getApplication();
		$model = $this->getModel('EinsatzberichtForm', 'EinsatzkomponenteModel');

        // Get the user data.
        $data = array();
        $data['id'] = $app->input->getInt('id');

        // Check for errors.
        if (empty($data['id'])) {
            // Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                } else {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

			
			// Save the data in the session.
			$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_einsatzkomponente.edit.einsatzbericht.id');
			$this->setRedirect(JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&layout=edit&id='.$id, false));
			return false;
		}

		// Attempt to save the data.
		$return	= $model->delete($data);

		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.data', $data);

			// Redirect back to the edit screen.
			$id = (int)$app->getUserState('com_einsatzkomponente.edit.einsatzbericht.id');
			$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&layout=edit&id='.$id, false));
			return false;
		}

            
        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }
        
        // Clear the profile id from the session.
        $app->setUserState('com_einsatzkomponente.edit.einsatzbericht.id', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('Item deleted successfully'));
        $menu = & JFactory::getApplication()->getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));

		// Flush the data from the session.
		$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.data', null);
	}
    
    
}