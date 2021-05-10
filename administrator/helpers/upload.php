
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



		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');

		$user	= JFactory::getUser();
 
		//this is the name of the field in the html form, filedata is the default name for swfupload
		//so we will leave it as that
		
		ini_set('memory_limit', -1);
		
		$files        = JFactory::getApplication()->input->files->get('data', '', 'array');

		$params = JComponentHelper::getParams('com_einsatzkomponente');
		$count_data=count($files) ;  ######### count the data #####
$count = 0;
while($count < $count_data)
{
		$fileName = $files[$count]['name'];//echo $count.'= Name:'.$fileName.'<br/>';
		$fileName = JFile::makeSafe($fileName);
		$uploadedFileNameParts = explode('.',$fileName);
		$uploadedFileExtension = array_pop($uploadedFileNameParts);
 
		$fileTemp = $files[$count]['tmp_name'];
		$count++;
		// remove invalid chars
//		$file_extension = strtolower(substr(strrchr($fileName,"."),1));
//		$name_cleared = preg_replace("#[^A-Za-z0-9 _.-]#", "", $fileName);
//		if ($name_cleared != $file_extension){
//			$fileName = $name_cleared;
//		}
					
					
					
					
					
		$rep_id = $cid;   // Einsatz_ID holen für Zuordnung der Bilder in der Datenbank
		if ($watermark_image == '') :
		$watermark_image = JFactory::getApplication()->input->getVar('watermark_image', $params->get('watermark_image'));
		endif;
		
		// Check ob Bilder in einen Unterordner (OrdnerName = ID-Nr.) abgespeichert werden sollen :
		if ($params->get('new_dir', '1')) :
		$rep_id_ordner = '/'.$rep_id;
		else:
		$rep_id_ordner = '';
		endif;
		
		$fileName = $rep_id.'-'.$fileName;
		
		
		 // Check if dir already exists
        if (!JFolder::exists(JPATH_SITE.'/'.$params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder').$rep_id_ordner)) 
		{ JFolder::create(JPATH_SITE.'/'.$params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder').$rep_id_ordner);     }
		else  {}
        if (!JFolder::exists(JPATH_SITE.'/'.$params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder').'/thumbs'.$rep_id_ordner)) 
		{ JFolder::create(JPATH_SITE.'/'.$params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder').'/thumbs'.$rep_id_ordner);  }
		else  {}
	    
		$uploadPath  = JPATH_SITE.'/'.$params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder').$rep_id_ordner.'/'.$fileName ;
		$uploadPath_thumb  = JPATH_SITE.'/'.$params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder').'/thumbs'.$rep_id_ordner.'/'.$fileName ;
 //echo $fileTemp.' xxxx '.$uploadPath;exit; 
		if(!JFile::upload($fileTemp, $uploadPath)) 
		{
			echo JText::_( 'Bild konnte nicht verschoben werden' );
			return;
		}
		else
		{
			

		 // Check if dir already exists
        if (!JFolder::exists(JPATH_SITE.'/'.$params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder').'/thumbs')) 
		{ JFolder::create(JPATH_SITE.'/'.$params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder').'/thumbs');        }
		else  {}
		
		
		// Exif-Information --- Bild richtig drehen
	    $bild = $uploadPath;
		$image = imagecreatefromstring(file_get_contents($bild));
		$exif = exif_read_data($bild);
		if(!empty($exif['Orientation'])) {
			switch($exif['Orientation']) {
				case 8:
					$image = imagerotate($image,90,0);
					break;
				case 3:
					$image = imagerotate($image,180,0);
					break;
				case 6:
					$image = imagerotate($image,-90,0);
					break;
			}
		}
		 
		// scale image
		list( $original_breite, $original_hoehe, $typ, $imgtag, $bits, $channels, $mimetype ) = @getimagesize( $bild );
		$ratio = imagesx($image)/imagesy($image); // width/height
		if($ratio > 1) {
			$width = $original_breite;
			$height = round($original_breite/$ratio);
		} else {
			$width = round($original_hoehe*$ratio);
			$height = $original_hoehe;
		}
		$scaled = imagecreatetruecolor($width, $height);
		imagecopyresampled($scaled, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
		 
		imagejpeg($scaled, $bild);
		//imagedestroy($image);
		imagedestroy($scaled);

		
		// thumbs erstellen und unter /thumbs abspeichern
	    $bild = $uploadPath;
		@list( $original_breite, $original_hoehe, $typ, $imgtag, $bits, $channels, $mimetype ) = @getimagesize( $bild );
		$speichern = $uploadPath_thumb;
     	$originalbild = imagecreatefromjpeg( $bild ); 
	    $maxbreite = $params->get('thumbwidth', '100');
	    $maxhoehe = $params->get('thumbhigh', '100');
	  	$quadratisch = $params->get('quadratisch', 'true');
		$qualitaet = '80';
 
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
        // Thumbnail für Einsatzliste usw. erstellen
        $thumb = imagecreatetruecolor( $maxbreite, $maxbreite );
        imagecopyresampled( $thumb, $tmpbild, 0, 0, 0, 0, $maxbreite, $maxbreite, $originalkantenlaenge, $originalkantenlaenge );
    }

 
        imagejpeg( $thumb, $speichern, $qualitaet ); 
   		imagedestroy( $thumb );
			
			
			
			$custompath = $params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder');
			chmod($uploadPath, 0644);
			chmod($uploadPath_thumb, 0644);
			$db = JFactory::getDBO();
			$query = 'INSERT INTO #__eiko_images SET report_id="'.$rep_id.'", image="'.$custompath.$rep_id_ordner.'/'.$fileName.'", thumb="'.$custompath.'/thumbs'.$rep_id_ordner.'/'.$fileName.'", state="1", created_by="'.$user->id.'"';
			$db->setQuery($query);
			$db->query();
			
		$db = JFactory::getDBO();
		$query = 'SELECT image FROM #__eiko_einsatzberichte WHERE id ="'.$rep_id.'" ';
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$check_image      = $rows[0]->image;

		if ($params->get('titelbild_auto', '1')):
		if ($check_image == ''):
		$db		= JFactory::getDBO();
		$query	= $db->getQuery(true);
		$query->update('#__eiko_einsatzberichte');
		//$query->set('image = "'.$custompath.$rep_id_ordner.'/'.$fileName.'" ');
		$query->set('image = "'.$custompath.'/thumbs'.$rep_id_ordner.'/'.$fileName.'" ');
		$query->where('id ="'.$rep_id.'"');
		$db->setQuery((string) $query);

		try
		{
			$db->execute();
		}
		catch (RuntimeException $e)
		{
			throw new Exception($e->getMessage(), 500);
		}
		endif;
		endif;
			
			echo JText::_( 'Bild wurde hochgeladen' ).'<br/>';
			
			
$source = JPATH_SITE.'/'.$params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder').$rep_id_ordner.'/'.$fileName ; //the source file
$destination =  JPATH_SITE.'/'.$params->get('uploadpath', 'images/com_einsatzkomponente/einsatzbilder').$rep_id_ordner.'/'.$fileName ; //were to place the thumb
$watermark =  JPATH_SITE.'/'.$watermark_image.''; //the watermark files

    // Einsatzbilder resizen
	$image_resize = $params->get('image_resize', 'true');
    if ($image_resize === 'true'):
	$newwidth = $params->get('image_resize_max_width', '800');
	$newheight = $params->get('image_resize_max_height', '600');
    list($width, $height) = getimagesize($source);
    if($width > $height && $newheight < $height){
        $newheight = $height / ($width / $newwidth);
    } else if ($width < $height && $newwidth < $width) {
        $newwidth = $width / ($height / $newheight);   
    } else {
        $newwidth = $width;
        $newheight = $height;
    }
    $thumb = imagecreatetruecolor($newwidth, $newheight);
    $source_name = imagecreatefromjpeg($source);
    imagecopyresized($thumb, $source_name, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	imagejpeg($thumb, $destination, 100);  
	endif;

    // Wasserzeichen einbauen
	$watermark_show = $params->get('watermark_show', 'true');
    if ($watermark_show === 'true'):
	$watermark_pos_x = $params->get('watermark_pos_x', '0');
	$watermark_pos_y = $params->get('watermark_pos_y', '5');
	list($sourcewidth,$sourceheight)=getimagesize($source);
	list($watermarkwidth,$watermarkheight)=getimagesize($watermark);

	$w_pos_x = $watermark_pos_x;
	$w_pos_y = $sourceheight-$watermarkheight-$watermark_pos_y;

	$source_img = imagecreatefromjpeg($source);
	$watermark_img = imagecreatefrompng($watermark);
	imagecopy($source_img, $watermark_img, $w_pos_x, $w_pos_y, 0, 0, $watermarkwidth,$watermarkheight);
	imagejpeg($source_img, $destination, 100);  
	imagedestroy ($source_img);
	imagedestroy ($watermark_img);
	endif;
		}} 
	
?>