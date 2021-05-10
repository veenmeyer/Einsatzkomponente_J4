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
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Component\ComponentHelper;
require_once JPATH_COMPONENT.'/controller.php';
/**
 * Einsatzbericht controller class.
 */
class EinsatzkomponenteControllerEinsatzbericht extends EinsatzkomponenteController
{
	/**
	 * Method to check out an item for editing and redirect to the edit form.
	 *
	 * @since	1.6
	 */
	 
	 
	public function edit()
	{
		$app			= Factory::getApplication();
		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_einsatzkomponente.edit.einsatzbericht.id');
		$editId	= Factory::getApplication()->input->getInt('id', null, 'array');
		// Set the user id for the user to edit in the session.
		$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.id', $editId);
		// Get the model.
		$model = $this->getModel('Einsatzbericht', 'EinsatzkomponenteModel');
		// Check out the item
		if ($editId) {
            $model->checkout($editId);
		}
		// Check in the previous user.
		if ($previousId) {
            $model->checkin($previousId);
		}
		// Redirect to the edit screen.
		$this->setRedirect(Route::_('index.php?option=com_einsatzkomponente&view=einsatzberichtform&layout=edit&id='.$editId.'', false));
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
		echo 'upload_max_filesize: '.ini_get('upload_max_filesize'), "<br/>post_max_size: " , ini_get('post_max_size');
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		// Initialise variables.
		$app	= Factory::getApplication();
		$model = $this->getModel('Einsatzbericht', 'EinsatzkomponenteModel');
		// Get the user data.
		$data = Factory::getApplication()->input->get('jform', array(), 'array');
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
			$this->setRedirect(Route::_('index.php?option=com_einsatzkomponente&view=einsatzberichtform&layout=edit&id='.$id, false));
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
			$this->setMessage(Text::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(Route::_('index.php?option=com_einsatzkomponente&view=einsatzberichtform&layout=edit&id='.$id, false));
			return false;
		}
            
        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }
		
		$cid_article = '';
        if (!$return) {
		$db = Factory::getDBO();
		$query = "SELECT id FROM #__eiko_einsatzberichte ORDER BY id DESC LIMIT 1";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$cid_article      = $rows[0]->id;
        }
 		// Joomla-Artikel erstellen
		if ($return OR $cid_article) {
		$params = ComponentHelper::getParams('com_einsatzkomponente');
		if ( $params->get('article_frontend', '0') ): 
		$data = Factory::getApplication()->input->get('jform', array(), 'array');
		$cid = array();
		$cid[] = $data['id'];
		if (!$cid) : $cid = $cid_article;endif;
		$article = $data['einsatzticker'];
		if ($article): 
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		require_once JPATH_SITE.'/administrator/components/com_einsatzkomponente/helpers/article.php'; // Helper-class laden
		endif;
		endif;
		}
		
		
		
		
	// Mail (Auto) Funktion
	if ($return) :
		$send = 'false';
		$data = Factory::getApplication()->input->get('jform', array(), 'array');
		$cid = $data['id'];
		$params = ComponentHelper::getParams('com_einsatzkomponente');
		
		if ( $params->get('send_mail_auto', '0') ): 
		//if (!$cid) :
		//$db = JFactory::getDBO();
		//$query = "SELECT id FROM #__eiko_einsatzberichte ORDER BY id DESC LIMIT 1";
		//$db->setQuery($query);
		//$rows = $db->loadObjectList();
		//$cid      = $rows[0]->id;
		//$send = sendMail_auto($cid,'neuer Bericht: ');
		//else:
		$send = sendMail_auto($cid,'Update: ');
		//endif;
		endif;
	endif;
	if (!$return) :
		$send = 'false';
		$params = ComponentHelper::getParams('com_einsatzkomponente');
		
		if ( $params->get('send_mail_auto', '0') ): 
		//if (!$cid) :
		$db = Factory::getDBO();
		$query = "SELECT id FROM #__eiko_einsatzberichte ORDER BY id DESC LIMIT 1";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$cid      = $rows[0]->id;
		$send = sendMail_auto($cid,'neuer Bericht: ');
		//else:
		//$send = sendMail_auto($cid,'Update: ');
		//endif;
		endif;
	endif;
	// ---------------------------

		
        // Clear the profile id from the session.
        $app->setUserState('com_einsatzkomponente.edit.einsatzbericht.id', null);
        // Redirect to the list screen.
        $this->setMessage(Text::_('Einsatzdaten erfolgreich gepeichert'));
        $menu = Factory::getApplication()->getMenu();
        $item = $menu->getActive()->id; //print_r ($item);break;
//echo 'View :'.JFactory::getApplication()->input->get('view').'<br/>';
//echo 'Layout :'.JFactory::getApplication()->input->get('layout').'<br/>';
//echo 'Task :'.JFactory::getApplication()->input->get('task').'<br/>';break;

        //$this->setRedirect(JRoute::_($item->link, false));
		$this->setRedirect(Route::_('index.php?option=com_einsatzkomponente&Itemid='.$item.'', false));
		// Flush the data from the session.
		$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.data', null);
	}
    
    
    public function cancel() {
		
		$app = Factory::getApplication();
		$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.id', null);

		$menu = Factory::getApplication()->getMenu();
        $item = $menu->getActive()->id;
		$params = ComponentHelper::getParams('com_einsatzkomponente');
        $this->setMessage(Text::_('Einsatzeingabe abgebrochen'));
		$this->setRedirect(Route::_('index.php?option=com_einsatzkomponente&Itemid='.$item.'', false)); 
    }
    
	public function remove()
	{
		// Check for request forgeries.
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		// Initialise variables.
		$app	= Factory::getApplication();
		$model = $this->getModel('Einsatzbericht', 'EinsatzkomponenteModel');
		// Get the user data.
		$data = Factory::getApplication()->input->get('jform', array(), 'array');
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
			$this->setRedirect(Route::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&layout=edit&id='.$id, false));
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
			$this->setMessage(Text::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(Route::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&layout=edit&id='.$id, false));
			return false;
		}
            
        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }
        
        // Clear the profile id from the session.
        $app->setUserState('com_einsatzkomponente.edit.einsatzbericht.id', null);
        // Redirect to the list screen.
        $this->setMessage(Text::_('Item deleted successfully'));
        $menu = & Factory::getApplication()->getMenu();
        $item = $menu->getActive();
        $this->setRedirect(Route::_($item->link, false));
		// Flush the data from the session.
		$app->setUserState('com_einsatzkomponente.edit.einsatzbericht.data', null);
	}
	
    
}


	    function sendMail_auto($cid,$status) {

		

		//$model = $this->getModel();
		$params = ComponentHelper::getParams('com_einsatzkomponente');
		$user = Factory::getUser();
		$query = 'SELECT * FROM #__eiko_einsatzberichte WHERE id = "'.$cid.'" LIMIT 1';
		$db = Factory::getDBO();
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$mailer = Factory::getMailer();
		$config = Factory::getConfig();
		
		//$sender = array( 
    	//$config->get( 'config.mailfrom' ),
    	//$config->get( 'config.fromname' ) );
		$sender = array( 
    	$user->email,
    	$user->name );
		
		$mailer->setSender($sender);
		
		$user = Factory::getUser();
		//$recipient = $user->email;
		$recipient = $params->get('mail_empfaenger_auto',$user->email);
		
		$recipient 	 = explode( ',', $recipient);
		$orga		 = explode( ',', $result[0]->auswahl_orga);
		$orgas 		 = str_replace(",", " +++ ", $result[0]->auswahl_orga);
 
		$mailer->addRecipient($recipient);
		
		$mailer->setSubject($status.''.$orga[0].'  +++ '.$result[0]->summary.' +++');
		
		$db = Factory::getDBO();
		$query = $db->getQuery(true);
					$query
						->select('*')
						->from('#__eiko_tickerkat')
						->where('id = "' .$result[0]->tickerkat.'"  AND state = "1" ');
					$db->setQuery($query);
					$kat = $db->loadObject();
		
		$link = Route::_( JURI::root() . 'index.php?option=com_einsatzkomponente&view=einsatzbericht&id='.$result[0]->id.'&Itemid='.$params->get('homelink','')); 
		
		$body   = ''
				. '<h2>+++ '.$result[0]->summary.' +++</h2>';
		if ($params->get('send_mail_kat','0')) :	
		$body   .= '<h4>'.Text::_($kat->title).'</h4>';
		endif;
		if ($params->get('send_mail_orga','0')) :	
		$body   .= '<span><b>Eingesetzte Kräfte:</b> '.$orgas.'</span>';
		endif;
		$body   .= '<div>';
		if ($params->get('send_mail_desc','0')) :	
		if ($result[0]->desc) :	
    	$body   .= '<p>'.$result[0]->desc.'</p>';
		else:
    	$body   .= '<p>Ein ausführlicher Bericht ist zur Zeit noch nicht vorhanden.</p>';
		endif;
		endif;
		if ($params->get('send_mail_link','0')) :	
    	$body   .= '<p><a href="'.$link.'" target="_blank">Link zur Homepage</a></p>';
		endif;
		if ($result[0]->image) :	
		if ($params->get('send_mail_image','0')) :	
		$body   .= '<img src="'.JURI::root().$result[0]->image.'" style="margin-left:10px;float:right;height:50%;" alt="Einsatzbild"/>';
		endif;
		endif;
		$body   .= '</div>';
		

		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setBody($body);
		// Optionally add embedded image
		//$mailer->AddEmbeddedImage( JPATH_COMPONENT.'/assets/logo128.jpg', 'logo_id', 'logo.jpg', 'base64', 'image/jpeg' );
		
		$send = $mailer->Send();	

        return $send; 
    }
	
	

				

