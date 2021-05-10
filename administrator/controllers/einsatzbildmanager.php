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
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;

jimport('joomla.application.component.controlleradmin');
/**
 * Einsatzbildmanager list controller class.
 */
class EinsatzkomponenteControllerEinsatzbildmanager extends AdminController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'einsatzbilderbearbeiten', $prefix = 'EinsatzkomponenteModel', $config = [])
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
			jimport('joomla.utilities.arrayhelper');
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

	
	
    function thumb()  
    {  
		$params = ComponentHelper::getParams('com_einsatzkomponente');
		$input = Factory::getApplication()->input;
		$cid = $input->post->get('cid', array(), 'array');
		// Sanitize the input
		ArrayHelper::toInteger($cid);
		ToolbarHelper::title(Text::_('Thumbs erstellen'), 'weblinks.png');
        ToolbarHelper::cancel();
		$option		= Factory::getApplication()->input->getCmd('option');
  
        // Check for request forgeries  
        Session::checkToken() or jexit( 'Invalid Token' );  
  
  
        $total      = count( $cid );  
		
		if ($total>'15') {       
			echo 'erforderliche PHP-Einstellungen wurden vorgenommen:<br/><br/>';
			echo 'PHP memory_limit '.ini_get("memory_limit").' geändert in ';;@ini_set('memory_limit', '512M');echo ini_get("memory_limit").'<br/>';
			echo 'PHP max_execution_time '.ini_get("max_execution_time").' geändert in ';@ini_set('max_execution_time', 600); echo ini_get("max_execution_time").'<br/>';
		}
      
	  
	  
	  $uploadPath_thumb  = $params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder').'/thumbs/';
	  $thumbwidth = $params->get('thumbwidth', '100');
	  $thumbhigh = $params->get('thumbhigh', '100');
	  $quadratisch = $params->get('quadratisch', 'true');

	  
        // make thumbs  
		$n='0';$i='0';
        for( $i=0; $i < $total; $i++ )  
        {  
            $einsatzbild = einsatzbild($cid[$i]);       // Funktion: zu bearbeitendes Einsatzbild laden
			$rImageFileName = $einsatzbild[0]->image;  
			 
			$source = JPATH_ROOT.'/'.$rImageFileName;
			
	    	$sourcename = basename($source);        
			$sourcepath = str_replace($sourcename, "", $source); 
			//$sourcepath = str_replace(JPATH_ROOT.'/', "", $sourcepath); 
			
		$reportid = $einsatzbild[0]->report_id;
			
		if($params->get('new_dir', '1')){
			if(!file_exists('../'.$uploadPath_thumb.$reportid)){
				mkdir('../'.$uploadPath_thumb.$reportid, 0755, true);
			}
			$rThumbFileName = $uploadPath_thumb.$reportid.'/'.$sourcename;
		}
		else{
			$rThumbFileName = $uploadPath_thumb.$sourcename;
		}
			
			$target = JPATH_ROOT.'/'.$rThumbFileName;
			
			if (file_exists($source)) {
			 $n++;
			 makeThumb( $source, $thumbwidth, $thumbhigh, $quadratisch,80,$target ); // Funktion makeThumb aufrufen
			 $db =& Factory::getDBO();  
             $query = 'UPDATE #__eiko_images SET thumb="' . $rThumbFileName . '" WHERE id = "' . $cid[$i] . '"';
			 $db->setQuery($query);
				try
				{
					$db->execute();
				}
				catch (\RuntimeException $e)
				{
					$this->setError($e->getMessage());

					return false;
				}			 
			$msg    =  $n.Text::_( 'Thumb(s) erstellt' );  
			} else {
			Factory::getApplication()->enqueueMessage( Text::_( 'Das Einsatzbild "'.$source.'" existiert nicht !' ), 'error' );
			} 
			
        }//for  
        $this->setRedirect('index.php?option=com_einsatzkomponente&view=einsatzbildmanager', $msg);  // ### 110421 -
      }//function  
	  

  	
    
}
 // Funktion : Einsatzbild laden
    function einsatzbild ($id) {
$database			=& Factory::getDBO();
$query = 'SELECT * FROM #__eiko_images WHERE id = "'.$id.'" ' ;
$database->setQuery( $query );
$einsatzbild = $database->loadObjectList();	
        return $einsatzbild;
    }
	
	
	
  // Funktion : Thumbnails erstellen
function makeThumb( $bild, $maxbreite, $maxhoehe, $quadratisch, $qualitaet = 80, $speichern = NULL )
{
    // Bilddaten auslesen
    list( $original_breite, $original_hoehe, $typ, $imgtag, $bits, $channels, $mimetype ) = @getimagesize( $bild );
 
    switch ($typ)
    {
        case '1': $originalbild = imagecreatefromgif( $bild ); break;
        case '2': $originalbild = imagecreatefromjpeg( $bild ); break;
        case '3': $originalbild = imagecreatefrompng( $bild ); break;
        default :
            header( 'Content-Type: text/html; charset=utf-8' );
            die( 'Die übergebene Datei ist keine Grafik!' );
        break;
    }
 
    if ($quadratisch === 'false')
    {
        // Höhe und Breite für proportionales Thumbnail berechnen
        if ($original_breite > $maxbreite || $original_hoehe > $maxhoehe)
        {
            $thumb_breite = $maxbreite;
            $thumb_hoehe  = $maxhoehe;
            if ($thumb_breite / $original_breite * $original_hoehe > $thumb_hoehe)
            {
                $thumb_breite = round( $thumb_hoehe * $original_breite / $original_hoehe );
            }
            else
            {
                $thumb_hoehe = round( $thumb_breite * $original_hoehe / $original_breite );
            }
        }
        else
        {
            $thumb_breite = $original_breite;
            $thumb_hoehe = $original_hoehe;
        }
        // Thumbnail erstellen
        $thumb = imagecreatetruecolor( $thumb_breite, $thumb_hoehe );
        imagecopyresampled( $thumb, $originalbild, 0, 0, 0, 0, $thumb_breite, $thumb_hoehe, $original_breite, $original_hoehe );
    }
    else if ($quadratisch === 'true')
    {
        // Kantenlänge für quadratisches Thumbnail ermitteln
        $originalkantenlaenge = $original_breite < $original_hoehe ? $original_breite : $original_hoehe;
        $tmpbild = imagecreatetruecolor( $originalkantenlaenge, $originalkantenlaenge );
        if ($original_breite > $original_hoehe)
        {
            imagecopy( $tmpbild, $originalbild, 0, 0, round( $original_breite-$originalkantenlaenge )/2, 0, $original_breite, $original_hoehe );
        }
        else if ($original_breite <= $original_hoehe )
        {
            imagecopy( $tmpbild, $originalbild, 0, 0, 0, round( $original_hoehe-$originalkantenlaenge )/2, $original_breite, $original_hoehe );
        }
        // Thumbnail erstellen
        $thumb = imagecreatetruecolor( $maxbreite, $maxbreite );
        imagecopyresampled( $thumb, $tmpbild, 0, 0, 0, 0, $maxbreite, $maxbreite, $originalkantenlaenge, $originalkantenlaenge );
    }
	
	
 
    // Korrekten Image Header senden, wenn nicht gespeichert wird
    if (!$speichern) { header( 'Content-Type: ' . $mimetype ); }
    switch ($typ)
    {
        case '1': imagegif( $thumb, $speichern ); break;
        case '2': imagejpeg( $thumb, $speichern, $qualitaet ); break;
        case '3': imagepng( $thumb, $speichern ); break;
        default : imagejpeg( $thumb, $speichern, $qualitaet ); break;
    }
    // Speicher freigeben
    imagedestroy( $thumb );
}
	
  

