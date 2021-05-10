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
jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );


// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_einsatzkomponente/assets/css/einsatzkomponente.css');

$bug = '0';
?>
<meta charset="utf-8">
<br/><br/>
<div class="well">
<form action="#" method="post" name="repairForm" id="repairForm">
<input type="text" name="repair" />
<input class="btn btn-primary" type="submit" name="repair-submit" value="Support-Code" />
</div>
<?php
// Versions-Nummer 
$db = JFactory::getDbo();
$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = "com_einsatzkomponente"');
$params = json_decode( $db->loadResult(), true );
	
$repair      	= JFactory::getApplication()->input->get('repair', false);
$restore      	= JFactory::getApplication()->input->get('restore', false);

// DB-Service

$repair_array ['111'] = "CREATE TABLE IF NOT EXISTS `#__eiko_tickerkat` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `asset_id` int(10) unsigned NOT NULL DEFAULT '0',  `title` varchar(255) NOT NULL,  `image` varchar(255) NOT NULL,  `beschreibung` TEXT NOT NULL,  `ordering` int(11) NOT NULL,  `state` tinyint(1) NOT NULL,  `created_by` int(11) NOT NULL,  `checked_out` int(11) NOT NULL,  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  PRIMARY KEY (`id`)) DEFAULT COLLATE=utf8_general_ci;";

$repair_array ['112'] = "CREATE TABLE IF NOT EXISTS `#__eiko_ausruestung` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',`name` VARCHAR(255)  NOT NULL ,`image` VARCHAR(255)  NOT NULL ,`beschreibung` TEXT NOT NULL ,`created_by` INT(11)  NOT NULL ,`checked_out` INT(11)  NOT NULL ,`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',`ordering` INT(11)  NOT NULL ,`state` TINYINT(1)  NOT NULL ,PRIMARY KEY (`id`)) DEFAULT COLLATE=utf8_general_ci;";

$repair_array ['113'] = "ALTER TABLE `#__eiko_einsatzberichte` ADD `ausruestung` TEXT NOT NULL AFTER `vehicles`;";
$repair_array ['114'] = "ALTER TABLE `#__eiko_einsatzberichte` ADD `auswahl_orga` TEXT NOT NULL AFTER `tickerkat`;";
$repair_array ['115'] = "ALTER TABLE `#__eiko_einsatzberichte` ADD `createdate` DATETIME NOT NULL AFTER `updatedate`;";
$repair_array ['116'] = "ALTER TABLE `#__eiko_einsatzberichte` ADD `modified_by` INT(11)  NOT NULL AFTER `created_by`;";
$repair_array ['117'] = "UPDATE `#__eiko_einsatzberichte` SET `createdate` = `updatedate`;";
$repair_array ['118'] = "UPDATE `#__eiko_einsatzberichte` SET `modified_by` = `created_by`;";

if ($repair) : 
	$db = JFactory::getDbo();
	$query = $repair_array[$repair];
	$db->setQuery($query);
	try {
	$result = $db->execute();
	} catch (Exception $e) {
	echo '<h2>Fehler in Query: '.$query.' : </h2>';  
	print_r ($e).'<br/><br/>';exit;
	}
	echo '<h2>Query erfolgreich ausgeführt</h2>'.$query;
	echo '<br/><h2>Bitte 1 Minute warten ...</h2><br/><br/>';
	?><meta http-equiv="refresh" content="65"; url="<?php echo $_SERVER['PHP_SELF']; ?>" /><?php
	exit;
endif;







	

?>
<div align="left">
<?php
		echo '<h2>'.JTEXT::_('Installations- und Updatemanager für die Einsatzkomponente Version ').$params['version'].'</h2>'; 
		
		?>
		<a target="_blank" href="http://www.einsatzkomponente.de/index.php"><img border=0  src="<?php echo JURI::base(); ?>components/com_einsatzkomponente/assets/images/komponentenbanner.jpg"/></a><br/><br/>
        <?php

//if ($bug) : echo 'Backup-Fehler: Installation abgebrochen !! Wenden Sie sich an: support@einsatzkomponente.de';exit; endif;


echo '<div class="well">';
// try to set time limit
@set_time_limit(0);
echo '<h2>PHP-Einstellungen:</h2>';
// try to increase memory limit
echo 'memory_limit: '.ini_get('memory_limit').'<br/>';
echo 'upload_max_filesize: '.ini_get('upload_max_filesize').'<br/>';
echo 'post_max_size: '.ini_get('post_max_size').'<br/>';
if ((int) ini_get('memory_limit') < 256) {
          @ini_set('memory_limit', '256M');
		  echo 'memory_limit geändert auf: '.ini_get('memory_limit').'<br/>';
		}
if ((int) ini_get('upload_max_filesize') < 32) {
          @ini_set('upload_max_filesize', '32M');
		  echo 'upload_max_filesize geändert auf: '.ini_get('upload_max_filesize').'<br/>';
		}
if ((int) ini_get('post_max_size') < 8) {
          @ini_set('post_max_size', '8M');
		  echo 'post_max_size geändert auf: '.ini_get('post_max_size').'<br/>';
		}
echo '</div>';

echo '<div class="well">';
echo '<h2>Installation/Update :</h2>';



	// ------------------ Fahrzeugbilder -------------------------------------------------------------------------
	$discr = "Image-Ordner für die Einsatzkomponente";
	$dir = JPATH_ROOT.'/images/com_einsatzkomponente'; 
	if (!JFolder::exists($dir))   
	{
		echo 'Der '.$discr.' <span class="label label-important">existiert nicht</span>.<br/>';
		$source = JPATH_ROOT.'/'.'media/com_einsatzkomponente/'; 
		$target = JPATH_ROOT.'/images/com_einsatzkomponente/';
		echo 'Kopiere:&nbsp;&nbsp;&nbsp;'.$source.'&nbsp;&nbsp;&nbsp;&nbsp;<b>nach:</b>&nbsp;&nbsp;&nbsp;&nbsp;'.$target.'<br/>';
		JFolder::copy($source,$target);
			if (!JFolder::exists($dir))   
			{
			echo 'Der '.$discr.' <span class="label label-important">wurde nicht erstellt !!!!</span>.<br/><br/>';$bug='1'; 
			}
			else {
					echo 'Der '.$discr.' <span class="label label-success">wurde erstellt.</span>.<br/><br/>'; 
				}
		
	}
	else {
		echo 'Der '.$discr.' <span class="label label-success">existiert</span>.<br/><br/>'; 
		}
// ------------------ Check GMap-Config Datenbanktabelle ------------------------------------------------------

$db = JFactory::getDbo();
$db->setQuery('SELECT id FROM #__eiko_gmap_config WHERE id = "1"');
$check_gmap = $db->loadResult();

if ($check_gmap) {
	echo 'Die GMap-Konfigurationstabelle <span class="label label-success">existiert.</span>.<br/><br/>'; 
}
else
{
	$db = JFactory::getDbo();
	$query = "INSERT INTO `#__eiko_gmap_config`(`id`) VALUES (1)";
	$db->setQuery($query);
	try {
	// Execute the query in Joomla 3.0.
	$result = $db->execute();
	} catch (Exception $e) {
	//print the errors
	echo 'Die GMap-Konfigurationstabelle wurde <span class="label label-important">nicht erstellt.</span>.<br/><br/>';  
	print_r ($e).'<br/><br/>';$bug = '1';
	}
	$db = JFactory::getDbo();
	$db->setQuery('SELECT id FROM #__eiko_gmap_config WHERE id = "1"');
	$check_gmap = $db->loadResult();
	if ($check_gmap) {
	echo 'Die GMap-Konfigurationstabelle wurde <span class="label label-info">erstellt.</span>.<br/><br/>'; 
	
	$db = JFactory::getDbo();
    $query = 'UPDATE `#__eiko_gmap_config` SET `gmap_alarmarea` = "53.28071418254047,7.416630163574155|53.294772929932165,7.4492458251952485|53.29815865222114,7.4767116455077485|53.31313468829642,7.459888830566342|53.29949234792138,7.478256597900327|53.29815865222114,7.506409063720639|53.286461382800795,7.521686926269467|53.26726681991669,7.499027624511655|" WHERE `id` = 1;';	
	$db->setQuery($query); 
	//execute db object
	try {
	// Execute the query in Joomla 3.0.
	$result = $db->execute();
	} catch (Exception $e) {
	//print the errors
	print_r($e);
	}	
	}
	else{}
	}
// ------------------ Update von Version 3.0 beta 3 auf 3.0 beta 4 --------------------------------------------------
	$db = JFactory::getDbo();
	$db->setQuery('show columns from `#__eiko_einsatzberichte` where Field="presse_label"');
	try {
	$check_presse = $db->execute();
	} catch (Exception $e) {
	print_r($e);$bug='1';
	}	
$check_presse = $check_presse->num_rows;
if (!$check_presse) {
	
	$db = JFactory::getDbo();
    $query = 'ALTER TABLE `#__eiko_einsatzberichte` ADD `presse_label` VARCHAR( 255 ) NOT NULL DEFAULT "Presselink" AFTER `gmap`';	
	$db->setQuery($query); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
	}	
	$db = JFactory::getDbo();
    $query = 'ALTER TABLE `#__eiko_einsatzberichte` ADD `presse2_label` VARCHAR( 255 ) NOT NULL DEFAULT "Presselink" AFTER `presse`';	
	$db->setQuery($query); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
	}	
	
	$db = JFactory::getDbo();
    $query = 'ALTER TABLE `#__eiko_einsatzberichte` ADD `presse3_label` VARCHAR( 255 ) NOT NULL DEFAULT "Presselink" AFTER `presse2`';	
	$db->setQuery($query); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
	}	
	
	echo 'DB-Updates  < 3.0 beta 4 erfolgreich <span class="label label-success">aktualisiert.</span>.<br/><br/>'; 
}
else {
	//echo 'Alle Daten sind bereits <span class="label label-success">aktuell</span><br/><br/>'; 
	}
	
// ------------------ Update von Version 3.04 auf 3.05 beta --------------------------------------------------
	$db = JFactory::getDbo();
	$db->setQuery('show columns from `#__eiko_einsatzberichte` where Field="status_fb"');
	try {
	$check_status_fb = $db->execute();
	} catch (Exception $e) {
	print_r($e);$bug='1';
	}	
$check_status_fb = $check_status_fb->num_rows;
if (!$check_status_fb) {
	
	$db = JFactory::getDbo();
    $query = 'ALTER TABLE `#__eiko_einsatzberichte` ADD `status_fb` VARCHAR( 255 ) NOT NULL DEFAULT "1" AFTER `gmap`';	
	$db->setQuery($query); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
	}	
}
else {
	} 
	
	$db = JFactory::getDbo();
	$db->setQuery('show columns from `#__eiko_einsatzberichte` where Field="article_id"');
	try {
	$check_status_fb = $db->execute();
	} catch (Exception $e) {
	print_r($e);$bug='1';
	}	
$check_status_fb = $check_status_fb->num_rows;
if (!$check_status_fb) {
	
	$db = JFactory::getDbo();
    $query = 'ALTER TABLE `#__eiko_einsatzberichte` ADD `article_id` VARCHAR( 255 ) NOT NULL DEFAULT "0" AFTER `asset_id`';	
	$db->setQuery($query);  
	try {
	$result = $db->execute();
	} catch (Exception $e) {
	}	

	echo 'DB-Updates  < 3.05 beta erfolgreich <span class="label label-success">aktualisiert.</span>.<br/><br/>'; 
}
else {
	echo 'Alle Daten sind bereits <span class="label label-success">aktuell</span><br/><br/>'; 
	}
	
// ------------------ Update von Version 3.05 auf 3.06 beta ---------------------------------------------------
$check_tickerkat = '0';
	$db = JFactory::getDbo();
	$db->setQuery('select * from `#__eiko_tickerkat`');
	try {
	$check_tickerkat = $db->execute();
	} catch (Exception $e) {$check_tickerkat='1';}
	
	
if ($check_tickerkat == '1') {
	
$eiko_tickerkat = array(
  array('id' => '1','asset_id' => '0','title' => 'Brandeinsatz > Brandmeldeanlage (Fehlalarm)','image' => 'images/com_einsatzkomponente/images/list/brand_bma_fehl.png','beschreibung' => '','ordering' => '1','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '2','asset_id' => '0','title' => 'Brandeinsatz > Wohngebäude','image' => 'images/com_einsatzkomponente/images/list/brand_wohnhaus.png','beschreibung' => '','ordering' => '2','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '3','asset_id' => '0','title' => 'Brandeinsatz > Fahrzeugbrand','image' => 'images/com_einsatzkomponente/images/list/brand_pkw.png','beschreibung' => '','ordering' => '3','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '4','asset_id' => '0','title' => 'Brandeinsatz > Wald / Flächen','image' => 'images/com_einsatzkomponente/images/list/brand_wald_flaechen.png','beschreibung' => '','ordering' => '4','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '5','asset_id' => '0','title' => 'Techn. Hilfe > Hochwasser','image' => 'images/com_einsatzkomponente/images/list/TH_WASSER.png','beschreibung' => '','ordering' => '5','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '6','asset_id' => '0','title' => 'Techn. Hilfe > Öl / Benzin auf Straße','image' => 'images/com_einsatzkomponente/images/list/hilfe_oelspur.png','beschreibung' => '','ordering' => '6','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '7','asset_id' => '0','title' => 'Techn. Hilfe > Öl / Benzin auf Gewässer','image' => 'images/com_einsatzkomponente/images/list/hilfe_amtshilfe.png','beschreibung' => '','ordering' => '7','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '8','asset_id' => '0','title' => 'Techn. Rettung > Verkehrsunfall','image' => 'images/com_einsatzkomponente/images/list/hilfe_pkw_unfall.png','beschreibung' => '','ordering' => '8','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '9','asset_id' => '0','title' => 'Techn. Rettung > Wasserrettung','image' => 'images/com_einsatzkomponente/images/list/brand_sonstiges.png','beschreibung' => '','ordering' => '9','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '10','asset_id' => '0','title' => 'Techn. Rettung > Person in Notlage','image' => 'images/com_einsatzkomponente/images/list/hilfe_amtshilfe.png','beschreibung' => '','ordering' => '10','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '11','asset_id' => '0','title' => 'Techn. Hilfe > Sturm','image' => 'images/com_einsatzkomponente/images/list/hilfe_sturm.png','beschreibung' => '','ordering' => '11','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '12','asset_id' => '0','title' => 'Med. Einsatz > First Responder','image' => 'images/com_einsatzkomponente/images/list/med_sonstiges.png','beschreibung' => '','ordering' => '12','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '13','asset_id' => '0','title' => 'Techn. Hilfe > Amtshilfe','image' => 'images/com_einsatzkomponente/images/list/brand_sonstiges.png','beschreibung' => '','ordering' => '13','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '14','asset_id' => '0','title' => 'Gefahrgut > Leckage','image' => 'images/com_einsatzkomponente/images/list/gefahr_sonstige.png','beschreibung' => '','ordering' => '14','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '15','asset_id' => '0','title' => 'Techn. Hilfe > sonstige techn. Hilfeleistung','image' => 'images/com_einsatzkomponente/images/list/hilfe_amtshilfe.png','beschreibung' => '','ordering' => '15','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '16','asset_id' => '0','title' => 'Techn. Rettung > sonstige techn. Rettung','image' => 'images/com_einsatzkomponente/images/list/hilfe_amtshilfe.png','beschreibung' => '','ordering' => '16','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '17','asset_id' => '0','title' => 'Brandeinsatz > Sonstiges','image' => 'images/com_einsatzkomponente/images/list/Alarmuebung.png','beschreibung' => '','ordering' => '17','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '18','asset_id' => '0','title' => 'Med. Einsatz > sonstige medizinische Einsatz','image' => 'images/com_einsatzkomponente/images/list/med_sonstiges.png','beschreibung' => '','ordering' => '18','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '19','asset_id' => '0','title' => 'Brandeinsatz > Kleinbrand','image' => 'images/com_einsatzkomponente/images/list/Sicherheitswache.png','beschreibung' => '','ordering' => '19','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '20','asset_id' => '0','title' => 'Brandeinsatz > Gewerbebetrieb','image' => 'images/com_einsatzkomponente/images/list/brand_wohnhaus.png','beschreibung' => '','ordering' => '20','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '21','asset_id' => '0','title' => 'Brandeinsatz > Industriebetrieb','image' => 'images/com_einsatzkomponente/images/list/brand_wohnhaus.png','beschreibung' => '','ordering' => '21','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '22','asset_id' => '0','title' => 'Brandeinsatz > Brandmeldeanlage','image' => 'images/com_einsatzkomponente/images/list/brand_bma.png','beschreibung' => '','ordering' => '22','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00'),
  array('id' => '23','asset_id' => '0','title' => 'Gefahrgut > sonstiger Gefahrgut-Einsatz','image' => 'images/com_einsatzkomponente/images/list/brand_sonstiges.png','beschreibung' => '','ordering' => '23','state' => '1','created_by' => '0','checked_out' => '0','checked_out_time' => '0000-00-00 00:00:00')
);

$e ='';
$sql="CREATE TABLE IF NOT EXISTS `#__eiko_tickerkat` (
`id` int(11)  UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `beschreibung` TEXT NOT NULL,
  `ordering` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;";
	$db = JFactory::getDbo();
	$db->setQuery($sql); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
		print_r ($e);$bug='1';
	}	

//$sql = "ALTER TABLE `#__eiko_tickerkat` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;";
//	$db = JFactory::getDbo();
//	$db->setQuery($sql); 
//	try {
//	$result = $db->execute();
//	} catch (Exception $e) {
//		print_r ($e);$bug='1';
//	}	


foreach($eiko_tickerkat as $data){

    $sql = 'INSERT INTO `#__eiko_tickerkat` (id, asset_id, title, image, beschreibung, ordering, state,created_by,checked_out,checked_out_time)
    VALUES ("'.$data["id"].'", "'.$data["asset_id"].'", "'.$data["title"].'", "'.$data["image"].'", "'.$data["beschreibung"].'", "'.$data["ordering"].'", "'.$data["state"].'", "'.$data["created_by"].'","'.$data["checked_out"].'","'.$data["checked_out_time"].'")';
	//echo $sql.'<br/>';
	$db = JFactory::getDbo();
	$db->setQuery($sql); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
		//print_r ($e);$bug='1';
	}	
	
}  
	//echo 'DB-Updates Version 3.6 erfolgreich <span class="label label-success">aktualisiert.</span>.<br/><br/>'; 


}

	$db = JFactory::getDbo();
	$query = "ALTER TABLE `#__eiko_einsatzberichte` CHANGE `tickerkat` `tickerkat` INT(10) NOT NULL;";
	$db->setQuery($query); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
	}	

// ------------------------------------------------------------------------------------------------------------
	$check_update = '0';
	$db = JFactory::getDbo();
	$db->setQuery('select `auswahl_orga` from `#__eiko_einsatzberichte`'); 
	try {
	$result = $db->loadObjectList();$check_update = '1';
	} catch (Exception $e) {$check_update = '0'; }
	
	if (!$check_update) :
	$db = JFactory::getDbo();
	$query = "ALTER TABLE `#__eiko_einsatzberichte` ADD `auswahl_orga` TEXT NOT NULL AFTER `auswahlorga`;";
	$db->setQuery($query); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
	}	
       	$results = array();
		$query = 'SELECT * FROM #__eiko_einsatzberichte' ;
		$db	= JFactory::getDBO();
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		
       	$data = array();
		foreach($results as $result):
		$data_id = '';
		foreach(explode(',',$result->auswahlorga) as $data):
						$db = JFactory::getDbo();
						$query	= $db->getQuery(true);
						$query
							->select('id')
							->from('`#__eiko_organisationen`')
							->where('name = "' .$data.'"');
						$db->setQuery($query);
						$orga_id = $db->loadResult();
						
		//echo '('.$data.' - '.$orga_id.') ';
		$data_id .= $orga_id.',';
		endforeach;
	  	//$data_id=substr($data_id,0,strlen($data_id)-1);
		//echo '</br>';
		//echo $result->id.' = '.$data_id.'</br>';
		
$db = JFactory::getDbo();
$query = $db->getQuery(true);
// Fields to update.
$fields = array(
    $db->quoteName('auswahl_orga') . ' = ' . $db->quote(''.$data_id.'') );
// Conditions for which records should be updated.
$conditions = array(
    $db->quoteName('id') . ' = '.$result->id.'' );
$query->update($db->quoteName('#__eiko_einsatzberichte'))->set($fields)->where($conditions);
 
$db->setQuery($query);
	try {
	$result = $db->execute();
	} catch (Exception $e) {
		print_r ($e);$bug='1';
	}	
	
		endforeach;
	

       	$results = array();
		$query = 'SELECT * FROM #__eiko_fahrzeuge' ;
		$db	= JFactory::getDBO();
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		
       	$data = '';
		foreach($results as $result):
						$db = JFactory::getDbo();
						$query	= $db->getQuery(true);
						$query
							->select('id')
							->from('`#__eiko_organisationen`')
							->where('name = "' .$result->department.'"');
						$db->setQuery($query);
						$orga_id = $db->loadResult();
						
		//echo '('.$result->department.' - '.$orga_id.')</br> ';
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Fields to update.
		$fields = array(
		$db->quoteName('department') . ' = ' . $db->quote(''.$orga_id.'') );
		// Conditions for which records should be updated.
		$conditions = array(
		$db->quoteName('id') . ' = '.$result->id.'' );
		$query->update($db->quoteName('#__eiko_fahrzeuge'))->set($fields)->where($conditions);
 
		$db->setQuery($query);
			try {
				$result = $db->execute();
				} catch (Exception $e) {
					print_r ($e);$bug='1';
					}	

		endforeach;
		


       	$results = array();
		$query = 'SELECT * FROM #__eiko_einsatzberichte' ;
		$db	= JFactory::getDBO();
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		
       	$data = array();
		$bug_data='';

		foreach($results as $result):
		$data_id = '';
						$db = JFactory::getDbo();
						$query	= $db->getQuery(true);
						$query
							->select('id')
							->from('`#__eiko_einsatzarten`')
							->where('title = "' .$result->data1.'"');
						$db->setQuery($query);
						$data_id = $db->loadResult();
						
		//echo '('.$result->data1.' - '.$data_id.') ';
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Fields to update.
		$fields = array(
		$db->quoteName('data1') . ' = ' . $db->quote(''.$data_id.'') );
		// Conditions for which records should be updated.
		$conditions = array(
		$db->quoteName('id') . ' = '.$result->id.'' );
		$query->update($db->quoteName('#__eiko_einsatzberichte'))->set($fields)->where($conditions);
		$db->setQuery($query);
			try {
				$result = $db->execute();
				} catch (Exception $e) {
					print_r ($e);$bug='1';$bug_data='1';
					}	
		endforeach;
	
	if (!$bug_data) :
	$db = JFactory::getDbo();
	$query = "ALTER TABLE `#__eiko_einsatzberichte` CHANGE `data1` `data1` INT(10) NOT NULL;";
	$db->setQuery($query); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
		print_r ($e);$bug='1';
	}	
	endif;
		

		
endif;	

// ------------------ ADD gmap_icon zu Organisationen --------------------------------------------------
	$check_gmap_icon = '0';
	$db = JFactory::getDbo();
	$db->setQuery('select gmap_icon_orga from `#__eiko_organisationen`');
	try {
	$check_gmap_icon = $db->execute();$check_gmap_icon='1';
	} catch (Exception $e) {
	$check_gmap_icon='0';
	}	

if (!$check_gmap_icon) {
	
	$db = JFactory::getDbo();
    $query = 'ALTER TABLE `#__eiko_organisationen` ADD `gmap_icon_orga` VARCHAR( 255 ) NOT NULL AFTER `name`';	
	$db->setQuery($query); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
	print_r($e);$bug='1';
	}	
}
else {
	}

// ------------------ ADD ausruestung zu Einsatzberichte --------------------------------------------------
	$check_update = '0';
	$db = JFactory::getDbo();
	$db->setQuery('select ausruestung from `#__eiko_einsatzberichte`');
	try {
	$check_update = $db->execute();$check_update='1';
	} catch (Exception $e) {$check_update='0';}
	
	if (!$check_update) :
	
	$db = JFactory::getDbo();
	$query = "ALTER TABLE `#__eiko_einsatzberichte` ADD `ausruestung` TEXT NOT NULL AFTER `vehicles`;";
	$db->setQuery($query); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {print_r($e);$bug='1';}	
	
	endif;

// ------------------------------------------------------------------------------------------------------------
// ------------------ ADD ausruestung zu Fahrzeuge --------------------------------------------------
	$check_update = '0';
	$db = JFactory::getDbo();
	$db->setQuery('select ausruestung from `#__eiko_fahrzeuge`');
	try {
	$check_update = $db->execute();$check_update='1';
	} catch (Exception $e) {$check_update='0';}
	
	if (!$check_update) :
	
	$db = JFactory::getDbo();
	$query = "ALTER TABLE `#__eiko_fahrzeuge` ADD `ausruestung` TEXT NOT NULL AFTER `department`;";
	$db->setQuery($query); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {print_r($e);$bug='1';}	 
	
	endif;

// ------------------------------------------------------------------------------------------------------------
// ------------------ Update von Version 3.06 auf 3.07  ---------------------------------------------------
	$check_ausruestung = '';
	$db = JFactory::getDbo();
	$db->setQuery('select * from `#__eiko_ausruestung` where id="0"');
	try {
	$check_ausruestung = $db->execute();
	} catch (Exception $e) {$check_ausruestung=true;}
	
	
if ($check_ausruestung) :

$e ='';
$sql="CREATE TABLE IF NOT EXISTS `#__eiko_ausruestung` (
`id` int(11)  UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `beschreibung` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$db = JFactory::getDbo();
	$db->setQuery($sql); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
		print_r ($e);$bug='1';
	}	

endif;
	


// ---------------------- Fehler in auswahl_orga beheben, das letzte "," löschen -----------------------------------------------

       	$results = array();
		$query = 'SELECT * FROM #__eiko_einsatzberichte' ;
		$db	= JFactory::getDBO();
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		
       	$data = array();
		foreach($results as $result):
		
		if (substr($result->auswahl_orga, -1) == ','   ) :
	  	$result->auswahl_orga=substr($result->auswahl_orga,0,strlen($result->auswahl_orga)-1);
		endif;
		//echo $result->id.' = '.$result->auswahl_orga.'<br/>';
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Fields to update.
		$fields = array(
		$db->quoteName('auswahl_orga') . ' = ' . $db->quote(''.$result->auswahl_orga.'') );
		// Conditions for which records should be updated.
		$conditions = array(
		$db->quoteName('id') . ' = '.$result->id.'' );
		$query->update($db->quoteName('#__eiko_einsatzberichte'))->set($fields)->where($conditions);
 
		$db->setQuery($query);
		try {
		$result = $db->execute();
		} catch (Exception $e) {
			print_r ($e);$bug='1';
		}	
	
		endforeach;
// ------------------------------------------------------------------------------------------------------------

		if (!file_exists('../images/com_einsatzkomponente/pdf')) {
		mkdir('../images/com_einsatzkomponente/pdf', 0755, true); }

	// Behebt Fehler in der Sortierung nach Counter-Anzahl
	$db = JFactory::getDbo();
    $query = 'ALTER TABLE `#__eiko_einsatzberichte` CHANGE `counter` `counter` INT( 20 ) NOT NULL';	
	$db->setQuery($query); 
	try {
	$result = $db->execute();
	} catch (Exception $e) {
	}	


?>
<?php echo '<br/><br/>';?>

<?php if ($bug == '0') : ?>
<?php echo '<span class="label label-success"><h1>Installation erfolgreich ...</h1></span><br/><br/>';?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div align="left">
<input
   type="button"
   class="btn btn-primary"
   value=" weiter zum Kontrollzentrum "
   title=""
   onclick="window.location='index.php?option=com_einsatzkomponente&view=kontrollcenter'"
   /></div>
</form>
<?php endif; ?>

<?php if ($bug == '1') : ?>
<?php echo '<span class="label label-important"><h1>Installation nicht erfolgreich ...</h1></span><br/><br/>Versuchen Sie es nochmal, oder wenden Sie sich an das Supportforum : <a href="http://www.einsatzkomponente.de" target="_blank">http://www.einsatzkomponente.de</a>';?>
<?php endif; ?>

<?php if ($bug == '2') : ?>
<?php echo '<span class="label label-success">Installation erfolgreich ...</span><br/><br/>';?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div align="center">
<input
   type="button"
   class="btn btn-primary"
   value=" weiter zum Kontrollzentrum "
   title=""
   onclick="window.location='index.php?option=com_einsatzkomponente&view=kontrollcenter'"
   />
  </div>
</form>
<?php endif; ?>


</div>
</div>
<hr>
<?php
// ------------------------------------ Alte Datenbanken vorhanden ? ---------------------------------------

	$check_db = '';
	$db = JFactory::getDbo();
	$db->setQuery('SELECT id from #__reports');
	try {
	// Execute the query in Joomla 3.0.
	$check_db = $db->execute();
	} catch (Exception $e) {
	echo '<div class="well"><span class="label label-success">Hinweis:</span> Ein Import von Einsatzdaten aus früheren Versionen der Einsatzkomponente ist möglich.<br/>Dazu bitte die Datenbanktabellen _reports_* einfach in diese Datenbank kopieren und die Installation erneut vornehmen.<br/>Für weitere Informationen bitte ans Forum wenden, wir unterstützen hierbei natürlich sehr gerne.</div>';
	}	
	
	if ($check_db) : 
	echo '<div class="well"><span class="label label-success">Hinweis:</span> Frühere Datenbanktabellen #__reports_* importieren ? <input
   type="button"
   class="btn btn-danger"
   value="Importieren"
   title=""
   onclick="window.location=\'index.php?option=com_einsatzkomponente&view=datenimport\'"
   /><br/>(Achtung alle vorhandenen Daten werden überschrieben)<br/></div>';
    endif;
	?>

