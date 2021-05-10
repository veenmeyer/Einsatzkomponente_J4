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
jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');
/**
 * Einsatzkomponente model.
 */
class EinsatzkomponenteModelEinsatzbericht extends JModelForm
{
    
    var $_item = null;
    
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState() 
	{
		
		$app = JFactory::getApplication('com_einsatzkomponente');
		// Load state from the request userState on edit or from the passed variable on default
        if (JFactory::getApplication()->input->get('layout') == 'edit') {
            $id = JFactory::getApplication()->getUserState('com_einsatzkomponente.edit.einsatzbericht.id');

        } else {
            $id = JFactory::getApplication()->input->get('id');
            JFactory::getApplication()->setUserState('com_einsatzkomponente.edit.einsatzbericht.id', $id);
        }
		$this->setState('einsatzbericht.id', $id);
		// Load the parameters.
		$params = $app->getParams();
        $params_array = $params->toArray();
        if(isset($params_array['item_id'])){
            $this->setState('einsatzbericht.id', (int)$params_array['item_id']);
        }
		$this->setState('params', $params);
	}
        
	/**
	 * Method to get an ojbect.
	 *
	 * @param	integer	The id of the object to get.
	 *
	 * @return	mixed	Object on success, false on failure.
	 */
	public function &getData($id = null)
	{
		if ($this->_item === null)
		{
			$this->_item = false;
			if (empty($id)) {
				$id = $this->getState('einsatzbericht.id');
			}
			// Get a level row instance.
			$table = $this->getTable();
			// Attempt to load the row.
			if ($table->load($id))
			{
				// Check published state.
				if ($published = $this->getState('filter.published'))
				{
					if ($table->state != $published) {
						return $this->_item;
					}
				}
				// Convert the JTable to a clean JObject.
				$properties = $table->getProperties(1);
				//$properties[test]= 'testvalue';print_r ($properties);
				$this->_item = JArrayHelper::toObject($properties, 'JObject');
			} elseif ($error = $table->getError()) {
				$this->setError($error);
			}
		}
		return $this->_item;
	}
    
	public function getTable($type = 'Einsatzbericht', $prefix = 'EinsatzkomponenteTable', $config = array())
	{   
        $this->addTablePath(JPATH_COMPONENT_ADMINISTRATOR.'/tables');
        return JTable::getInstance($type, $prefix, $config);
	}     
    
	/**
	 * Method to check in an item.
	 *
	 * @param	integer		The id of the row to check out.
	 * @return	boolean		True on success, false on failure.
	 * @since	1.6
	 */
	public function checkin($id = null)
	{
		// Get the id.
		$id = (!empty($id)) ? $id : (int)$this->getState('einsatzbericht.id');
		if ($id) {
            
			// Initialise the table
			$table = $this->getTable();
			// Attempt to check the row in.
            if (method_exists($table, 'checkin')) {
                if (!$table->checkin($id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
		}
		return true;
	}
	/**
	 * Method to check out an item for editing.
	 *
	 * @param	integer		The id of the row to check out.
	 * @return	boolean		True on success, false on failure.
	 * @since	1.6
	 */
	public function checkout($id = null)
	{
		// Get the user id.
		$id = (!empty($id)) ? $id : (int)$this->getState('einsatzbericht.id');
		if ($id) {
            
			// Initialise the table
			$table = $this->getTable();
			// Get the current user object.
			$user = JFactory::getUser();
			// Attempt to check the row out.
            if (method_exists($table, 'checkout')) {
                if (!$table->checkout($user->get('id'), $id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
		}
		return true;
	}    
    
	/**
	 * Method to get the profile form.
	 *
	 * The base form is loaded from XML 
     * 
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_einsatzkomponente.einsatzbericht', 'einsatzbericht', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;
	}
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		$data = $this->getData(); 
        
        return $data;
	}
	/**
	 * Method to save the form data.
	 *
	 * @param	array		The form data.
	 * @return	mixed		The user id on success, false on failure.
	 * @since	1.6
	 */
	public function save($data)
	{
			// Hausnummern aus Adresse entfernen !
			//if (isset($data[address]) && $data[address] != '') {
			//	$data[address]= preg_replace("/[0-9]/", "", $data[address]); 
			//}
		$id = (!empty($data['id'])) ? $data['id'] : (int)$this->getState('einsatzbericht.id');
        $state = (!empty($data['state'])) ? 1 : 0;
        $user = JFactory::getUser();
        if($id) {
			
			
            //Check the user can edit this item
            $authorised = $user->authorise('core.edit', 'com_einsatzkomponente') || $authorised = $user->authorise('core.edit.own', 'com_einsatzkomponente.einsatzbericht');
            if($user->authorise('core.edit.state', 'com_einsatzkomponente') !== true){ //The user cannot edit the state of the item.
                $data['state'] = 0;
            }
        } else {
            //Check the user can create new items in this section
            $authorised = $user->authorise('core.create', 'com_einsatzkomponente');
            if($user->authorise('core.edit.state', 'com_einsatzkomponente') !== true){ //The user cannot edit the state of the item.
                $data['state'] = 0;
            }
        }
        if ($authorised !== true) {
            throw new Exception( JText::_('ALERTNOAUTHOR'), 403);
            return false;
        }
			
			
			// Einsatz kopieren
			if($user->authorise('core.create', 'com_einsatzkomponente') == true){
		    $copy = JFactory::getApplication()->getUserState('com_einsatzkomponente.edit.einsatzbericht.copy');
        	if (!$copy == 0) :
            JFactory::getApplication()->setUserState('com_einsatzkomponente.edit.einsatzbericht.id', 0);
            JFactory::getApplication()->setUserState('com_einsatzkomponente.edit.einsatzbericht.copy', 0);
            $data['id'] = 0;
			endif; 
			}
// Bilder-Upload
		$app	= JFactory::getApplication();
		$params = $app->getParams('com_einsatzkomponente');
        $table = $this->getTable();
        if ($table->save($data) === true) {
		if ($params->get('eiko')) :
		$files = JFactory::getApplication()->input->files->get('data');
		if(!$files['0']['name'] =='') :
		$cid = $table->id;
		
		// Wasserzeichen speichern
		$input = JFactory::getApplication()->input;
		// Get the form data
		$formData = new JInput($input->get('jform', '', 'array'));
		// Get any data being able to use default values
		$watermark_image = $formData->getString('watermark_image');

		$params = JComponentHelper::getParams('com_einsatzkomponente');
		// Set new value of param(s)
		$params->set('watermark_image', $watermark_image);

		// Save the parameters
		$componentid = JComponentHelper::getComponent('com_einsatzkomponente')->id;
		$table = JTable::getInstance('extension');
		$table->load($componentid);
		$table->bind(array('params' => $params->toString()));

		// check for error
		if (!$table->check()) {
			echo $table->getError();
			return false;
		}
		// Save to database
		if (!$table->store()) {
			echo $table->getError();
			return false;
		}
		// Wasserzeichen speichern  ENDE

		require_once JPATH_SITE.'/administrator/components/com_einsatzkomponente/helpers/upload.php'; // Helper-class laden
		endif;	
		endif;	

            return $id;
        } else {
            return false;
        }
        
	}
    
     public function delete($data)
    {
        $id = (!empty($data['id'])) ? $data['id'] : (int)$this->getState('einsatzbericht.id');
        if(JFactory::getUser()->authorise('core.delete', 'com_einsatzkomponente') !== true){
            throw new Exception( JText::_('ALERTNOAUTHOR'), 403);
            return false;
        }
        $table = $this->getTable();
        if ($table->delete($data['id']) === true) {
            return $id;
        } else {
            return false;
        }
        
        return true;
    }
	
	public function hit()
	{
		$id = $this->getState('einsatzbericht.id');
		// update hits count
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$query->update('#__eiko_einsatzberichte');
		$query->set('counter = (counter + 1)');
		$query->where('id = ' . (int) $id);
		$db->setQuery((string) $query);

		try
		{
			$db->execute();
		}
		catch (RuntimeException $e)
		{
			throw new Exception($e->getMessage(), 500);
		}
	}
    
	
	

}