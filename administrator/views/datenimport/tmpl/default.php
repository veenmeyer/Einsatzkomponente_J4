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
// try to set time limit
@set_time_limit(0);
// try to increase memory limit
if ((int) ini_get('memory_limit') < 32) {
          @ini_set('memory_limit', '64M');
		}
// Versions-Nummer 
$db = JFactory::getDbo();
$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = "com_einsatzkomponente"');
$params = json_decode( $db->loadResult(), true );
	
$bug='0';	
		
?>
<div align="left">
<?php
		echo '<h2>Datenimport früherer Versionen</h2>'; 
		
		?>
		<a target="_blank" href="https://www.einsatzkomponente.de/index.php"><img border=0  src="<?php echo JURI::base(); ?>components/com_einsatzkomponente/assets/images/komponentenbanner.jpg"/></a><br/><br/>
        <?php
// -------------------------------------------------------------------------------------------------------
//$db = JFactory::getDbo();
//$sql = "show columns FROM J30_reports_vehicles_link ";
//$db->setQuery($sql);
//$reports = $db->loadObjectList();
//
//if ($reports) :
//	echo 'Importiere <span class="label label-info">#_reports_vehicles_link</span> : ';
//	
//$count = count($reports)-1;
//
//$i = 0;
//while ($i <= $count) {
//
//echo "\$reports_vehicles_link_".$reports[$i]->Field."[\$i] = \$results[\$i]->".$reports[$i]->Field.";<br/>" ;
//
//$i++; 
//}
//endif;
// ---------------------------------------------------------------------------------------------------------------
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__reports_data');
$db->setQuery($query);
$results = $db->loadObjectList();
if ($results) :
	echo 'Importiere <span class="label label-info">#_reports_data</span>     ..........      ';
	echo count($results).' Einsatzarten <span class="label label-success">erfolgreich importiert</span><br/>';
$count = count($results)-1;	
$i = 0;
while ($i <= $count) {
$reports_data_id[$i] = $results[$i]->id;
$reports_data_title[$i] = $results[$i]->title ?: '';
$reports_data_marker[$i] = '#'.$results[$i]->marker;
$reports_data_beschr[$i] = 'images/com_einsatzkomponente/images/mission/'.$results[$i]->beschr ?: 'images/com_einsatzkomponente/images/mission/Einsatz.png';
$reports_data_published[$i] = $results[$i]->published ?: '1';
$reports_data_icon[$i] = 'images/com_einsatzkomponente/images/map/icons/'.$results[$i]->icon ?: 'images/com_einsatzkomponente/images/map/icons/icon.png';
$reports_data_list_icon[$i] = 'images/com_einsatzkomponente/images/list/'.$results[$i]->list_icon ?: 'images/com_einsatzkomponente/images/list/blank.png';
$i++; 
}
$i = 0;
while ($i <= $count) {
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$columns = array('id', 'asset_id', 'title', 'marker', 'beschr', 'icon', 'list_icon', 'ordering', 'state', 'created_by');
$values = array($db->quote($reports_data_id[$i]), '0', $db->quote($reports_data_title[$i]), $db->quote($reports_data_marker[$i]), $db->quote($reports_data_beschr[$i]), $db->quote($reports_data_icon[$i]), $db->quote($reports_data_list_icon[$i]), $db->quote('0'), $db->quote($reports_data_published[$i]), $db->quote('')  );
 
$query
    ->insert($db->quoteName('#__eiko_einsatzarten'))
    ->columns($db->quoteName($columns))
    ->values(implode(',', $values));
 
$db->setQuery($query);
try {
    $result = $db->execute();
} catch (Exception $e) {
    print_r ($e);
}
$i++; 
}
endif;

// -------------------------------------- #__reports to #__eiko_einsatzberichte------------------------------------------
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__reports_images');
$db->setQuery($query);
$results = $db->loadObjectList();
if ($results) :
	echo 'Importiere <span class="label label-info">#_reports_images</span>     ..........      ';
	echo count($results).' Image-Daten <span class="label label-success">erfolgreich importiert</span><br/>';
$count = count($results)-1;	
$i = 0;
while ($i <= $count) {
$reports_images_id[$i] = $results[$i]->id;
$reports_images_image[$i] = 'images/com_einsatzkomponente/einsatzbilder/'.$results[$i]->image ?: '';
$reports_images_image_thumb[$i] = 'images/com_einsatzkomponente/einsatzbilder/thumbs/'.$results[$i]->image ?: '';
$reports_images_report_id[$i] = $results[$i]->report_id ?: '';
$i++; 
}
$i = 0;
while ($i <= $count) {
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$columns = array('id', 'asset_id', 'ordering', 'image', 'report_id', 'comment', 'thumb', 'state', 'created_by');
$values = array($db->quote($reports_images_id[$i]), $db->quote('0'), $db->quote('0'), $db->quote($reports_images_image[$i]), $db->quote($reports_images_report_id[$i]), $db->quote(''), $db->quote($reports_images_image_thumb[$i]), $db->quote('1'), $db->quote('')  );
 
$query
    ->insert($db->quoteName('#__eiko_images'))
    ->columns($db->quoteName($columns))
    ->values(implode(',', $values));
 
$db->setQuery($query);
try {
    $result = $db->execute();
} catch (Exception $e) {
    print_r ($e);
}
$i++; 
}
endif;
// ---------------------------------------------------------------------------------------------------------------
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__reports');
$db->setQuery($query);
$results = $db->loadObjectList();
if ($results) :
	echo 'Importiere <span class="label label-info">#_reports</span>     ..........      ';
	echo count($results).' Einsatzberichte <span class="label label-success">erfolgreich importiert</span><br/>';
$count = count($results)-1;
$i = 0;
while ($i <= $count) {
$reports_id[$i] = $results[$i]->id;

		$data_id = '';
						$db = JFactory::getDbo();
						$query	= $db->getQuery(true);
						$query
							->select('id')
							->from('#__eiko_einsatzarten')
							->where('title = "' .$results[$i]->data1.'"');
						$db->setQuery($query);
						$data_id = $db->loadResult();

$reports_data1[$i] = $data_id  ?: '';
$reports_image[$i] = $results[$i]->image ?: 'nopic.jpg';
$reports_address[$i] = $results[$i]->address ?: '';
$reports_date1[$i] = $results[$i]->date1 ?: '';
$reports_date2[$i] = $results[$i]->date2 ?: '';
$reports_date3[$i] = $results[$i]->date3 ?: '';
$reports_summary[$i] = $results[$i]->summary ?: '';
$reports_boss[$i] = $results[$i]->boss ?: '';
$reports_people[$i] = $results[$i]->people ?: '';
$reports_department[$i] = $results[$i]->department ?: '';
$reports_desc[$i] = $results[$i]->desc ?: '';
$reports_published[$i] = $results[$i]->published ?: '0';
$reports_alerting[$i] = $results[$i]->alerting ?: '';
$reports_gmap_report_latitude[$i] = $results[$i]->gmap_report_latitude ?: '1';
$reports_gmap_report_longitude[$i] = $results[$i]->gmap_report_longitude ?: '1';
$reports_counter[$i] = $results[$i]->counter ?: '0';
$reports_gmap[$i] = $results[$i]->gmap ?: '0';
$reports_presse[$i] = $results[$i]->presse ?: '';
$reports_updatename[$i] = $results[$i]->updatename ?: '';
$reports_updatedate[$i] = $results[$i]->updatedate ?: '';
$reports_boss2[$i] = $results[$i]->boss2 ?: '';
$reports_einsatzticker[$i] = $results[$i]->einsatzticker ?: '0';
$reports_tickerKAT[$i] = $results[$i]->tickerKAT ?: '0';
$reports_notrufticker[$i] = $results[$i]->notrufticker ?: '0';
$reports_presse2[$i] = $results[$i]->presse2 ?: '';
$reports_presse3[$i] = $results[$i]->presse3 ?: '';
$reports_status[$i] = $results[$i]->status ?: '0';
$i++; 
}
$i = 0; // eingesetzte Organisationen 
while ($i <= $count) {
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query
    ->select(array('a.id', 'a.name', 'b.report_id'))
    ->from('#__reports_departments AS a')
    ->join('INNER', '#__reports_departments_link AS b ON (a.id = b.department_id)')
    ->where('b.report_id LIKE '.$reports_id[$i].'');
    //->order('a.created DESC');
$db->setQuery($query);
$results = $db->loadColumn();
$auswahl_orga[$i] = implode(",", $results);
$i++; 
}
$i = 0; // eingesetzte Fahrzeuge
while ($i <= $count) {
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query
    ->select(array('a.id', 'a.name', 'b.report_id'))
    ->from('#__reports_vehicles AS a')
    ->join('INNER', '#__reports_vehicles_link AS b ON (a.id = b.vehicle_id)')
    ->where('b.report_id LIKE '.$reports_id[$i].'');
    //->order('a.created DESC');
$db->setQuery($query);
$results = $db->loadColumn();
$vehicles[$i] = implode(",", $results);
$i++; 
}
$i = 0;
while ($i <= $count) {
	
$db =& JFactory::getDBO();
$query = 'SELECT thumb FROM #__eiko_images WHERE report_id='.$reports_id[$i];
$db->setQuery($query);
$bild = $db->loadObjectList();
$foto = $bild[0]->thumb;
if (!$foto) :
$foto = 'images/com_einsatzkomponente/einsatzbilder/thumbs/nopic.png';
endif;
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$columns = array('id','asset_id','ordering','data1','image','address','date1','date2','date3','summary','boss','boss2','people','department','desc','alerting','gmap_report_latitude','gmap_report_longitude','counter','gmap','presse','presse2','presse3','updatedate','einsatzticker','notrufticker','tickerkat','auswahl_orga','vehicles','status','state','created_by');
$values = array($reports_id[$i], '0', '0', $db->quote($reports_data1[$i]), $db->quote($foto), $db->quote($reports_address[$i]), $db->quote($reports_date1[$i]), $db->quote($reports_date2[$i]), $db->quote($reports_date3[$i]), $db->quote($reports_summary[$i]), $db->quote($reports_boss[$i]), $db->quote($reports_boss2[$i]), $db->quote($reports_people[$i]), $db->quote($reports_department[$i]), $db->quote($reports_desc[$i]), $db->quote($reports_alerting[$i]), $db->quote($reports_gmap_report_latitude[$i]), $db->quote($reports_gmap_report_longitude[$i]), $db->quote($reports_counter[$i]), $db->quote($reports_gmap[$i]), $db->quote($reports_presse[$i]), $db->quote($reports_presse2[$i]), $db->quote($reports_presse3[$i]), $db->quote($reports_updatedate[$i]),$db->quote($reports_einsatzticker[$i]), $db->quote($reports_notrufticker[$i]),$db->quote($reports_tickerKAT[$i]), $db->quote($auswahl_orga[$i]), $db->quote($vehicles[$i]), $db->quote($reports_status[$i]), $db->quote($reports_published[$i]), $db->quote($reports_updatename[$i]));
$query
    ->insert($db->quoteName('#__eiko_einsatzberichte'))
    ->columns($db->quoteName($columns))
    ->values(implode(',', $values));
 
$db->setQuery($query);
try {
    $result = $db->execute();
} catch (Exception $e) {
    print_r ($e);
}
$i++; 
}
	
endif;
// ---------------------------------------------------------------------------------------------------------------
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__reports_alerting');
$db->setQuery($query);
$results = $db->loadObjectList();
if ($results) :
	echo 'Importiere <span class="label label-info">#_reports_alerting</span>     ..........      ';
	echo count($results).' Alarmierungsarten <span class="label label-success">erfolgreich importiert</span><br/>';
$count = count($results)-1;	
$i = 0;
while ($i <= $count) {
$reports_alerting_id[$i] = $results[$i]->id;
$reports_alerting_title[$i] = $results[$i]->title ?: '';
$reports_alerting_image[$i] = 'images/com_einsatzkomponente/images/alert/'.$results[$i]->image ?: '';
$reports_alerting_published[$i] = $results[$i]->published ?: '';
$i++; 
}
$i = 0;
while ($i <= $count) {
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$columns = array('id', 'asset_id', 'ordering', 'title', 'image', 'state', 'created_by');
$values = array($db->quote($reports_alerting_id[$i]),'0','0', $db->quote($reports_alerting_title[$i]), $db->quote($reports_alerting_image[$i]), $db->quote($reports_alerting_published[$i]),$db->quote('') );
 
$query
    ->insert($db->quoteName('#__eiko_alarmierungsarten'))
    ->columns($db->quoteName($columns))
    ->values(implode(',', $values));
 
$db->setQuery($query);
try {
    $result = $db->execute();
} catch (Exception $e) {
    print_r ($e);
}
$i++; 
}
endif;
// ---------------------------------------------------------------------------------------------------------------
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__reports_config');
$db->setQuery($query);
$results = $db->loadObjectList();
if ($results) :
	echo 'Importiere <span class="label label-info">#_reports_config</span>     ..........      ';
	echo count($results).' Konfigurationsdatei <span class="label label-success">erfolgreich importiert</span><br/>';
$count = count($results)-1;	
$i = 0;
while ($i <= $count) {
$reports_config_id[$i] = $results[$i]->id;
$reports_config_defimg[$i] = $results[$i]->defimg;
$reports_config_imagepath[$i] = $results[$i]->imagepath;
$reports_config_imgtw[$i] = $results[$i]->imgtw;
$reports_config_imgw[$i] = $results[$i]->imgw;
$reports_config_imggtw[$i] = $results[$i]->imggtw;
$reports_config_imggw[$i] = $results[$i]->imggw;
$reports_config_imgr[$i] = $results[$i]->imgr;
$reports_config_maxchar[$i] = $results[$i]->maxchar;
$reports_config_pdf[$i] = $results[$i]->pdf;
$reports_config_rss_feed[$i] = $results[$i]->rss_feed;
$reports_config_rss_char[$i] = $results[$i]->rss_char;
$reports_config_feuerwehr[$i] = $results[$i]->feuerwehr;
$reports_config_farbe1[$i] = $results[$i]->farbe1;
$reports_config_farbe2[$i] = $results[$i]->farbe2;
$reports_config_farbe3[$i] = $results[$i]->farbe3;
$reports_config_farbe4[$i] = $results[$i]->farbe4;
$reports_config_farbe5[$i] = $results[$i]->farbe5;
$reports_config_logow[$i] = $results[$i]->logow;
$reports_config_logoh[$i] = $results[$i]->logoh;
$reports_config_hometab[$i] = $results[$i]->hometab;
$reports_config_picow[$i] = $results[$i]->picow;
$reports_config_alarm[$i] = $results[$i]->alarm;
$reports_config_vview[$i] = $results[$i]->vview;
$reports_config_hmap[$i] = $results[$i]->hmap;
$reports_config_vpresse[$i] = $results[$i]->vpresse;
$reports_config_showtab[$i] = $results[$i]->showtab;
$reports_config_hmarker[$i] = '#'.$results[$i]->hmarker;
$reports_config_sletzte[$i] = $results[$i]->sletzte;
$reports_config_ffwFilter[$i] = $results[$i]->ffwFilter;
$reports_config_einsatzFilter[$i] = $results[$i]->einsatzFilter;
$reports_config_farbe6[$i] = $results[$i]->farbe6;
$reports_config_farbe7[$i] = $results[$i]->farbe7;
$reports_config_farbe8[$i] = $results[$i]->farbe8;
$reports_config_farbe9[$i] = $results[$i]->farbe9;
$reports_config_home_time[$i] = $results[$i]->home_time;
$reports_config_counter[$i] = $results[$i]->counter;
$reports_config_debughome[$i] = $results[$i]->debughome;
$reports_config_debugshow[$i] = $results[$i]->debugshow;
$reports_config_homehtml[$i] = $results[$i]->homehtml;
$reports_config_home1[$i] = $results[$i]->home1;
$reports_config_home2[$i] = $results[$i]->home2;
$reports_config_countershow[$i] = $results[$i]->countershow;
$reports_config_show1[$i] = $results[$i]->show1;
$reports_config_show2[$i] = $results[$i]->show2;
$reports_config_show3[$i] = $results[$i]->show3;
$reports_config_show4[$i] = $results[$i]->show4;
$reports_config_show5[$i] = $results[$i]->show5;
$reports_config_show6[$i] = $results[$i]->show6;
$reports_config_show7[$i] = $results[$i]->show7;
$reports_config_show8[$i] = $results[$i]->show8;
$reports_config_show9[$i] = $results[$i]->show9;
$reports_config_show10[$i] = $results[$i]->show10;
$reports_config_show11[$i] = $results[$i]->show11;
$reports_config_show12[$i] = $results[$i]->show12;
$reports_config_show13[$i] = $results[$i]->show13;
$reports_config_show14[$i] = $results[$i]->show14;
$reports_config_show15[$i] = $results[$i]->show15;
$reports_config_show16[$i] = $results[$i]->show16;
$reports_config_show17[$i] = $results[$i]->show17;
$reports_config_show18[$i] = $results[$i]->show18;
$reports_config_show19[$i] = $results[$i]->show19;
$reports_config_hall[$i] = $results[$i]->hall;
$reports_config_shybrid[$i] = $results[$i]->shybrid;
$reports_config_mailfront[$i] = $results[$i]->mailfront;
$reports_config_mailback[$i] = $results[$i]->mailback;
$reports_config_mailaddy[$i] = $results[$i]->mailaddy;
$reports_config_show20[$i] = $results[$i]->show20;
$reports_config_show21[$i] = $results[$i]->show21;
$reports_config_homeeinsatzartfarbe[$i] = $results[$i]->homeeinsatzartfarbe;
$reports_config_showeinsatzartfarbe[$i] = $results[$i]->showeinsatzartfarbe;
$reports_config_hhybrid[$i] = $results[$i]->hhybrid;
$reports_config_gmap_zoom_level_home[$i] = $results[$i]->gmap_zoom_level_home;
$reports_config_gmap_zoom_level_show[$i] = $results[$i]->gmap_zoom_level_show;
$reports_config_ticker[$i] = $results[$i]->ticker;
$reports_config_tickerAPI[$i] = $results[$i]->tickerAPI;
$reports_config_tickerUSER[$i] = $results[$i]->tickerUSER;
$reports_config_tickerDEBUG[$i] = $results[$i]->tickerDEBUG;
$reports_config_sdistance1[$i] = $results[$i]->sdistance1;
$reports_config_sdistance2[$i] = $results[$i]->sdistance2;
$reports_config_sdistanceZ[$i] = $results[$i]->sdistanceZ;
$reports_config_sarea[$i] = $results[$i]->sarea;
$reports_config_hgmap_height[$i] = $results[$i]->hgmap_height;
$reports_config_farbe10[$i] = $results[$i]->farbe10;
$reports_config_farbe11[$i] = $results[$i]->farbe11;
$reports_config_farbe12[$i] = $results[$i]->farbe12;
$reports_config_farbe13[$i] = $results[$i]->farbe13;
$reports_config_TwitterShow[$i] = $results[$i]->TwitterShow;
$reports_config_FacebookShow[$i] = $results[$i]->FacebookShow;
$reports_config_TwitterID[$i] = $results[$i]->TwitterID;
$reports_config_sgmap_height[$i] = $results[$i]->sgmap_height;
$reports_config_image_resize[$i] = $results[$i]->image_resize;
$reports_config_image_x[$i] = $results[$i]->image_x;
$reports_config_image_y[$i] = $results[$i]->image_y;
$reports_config_image_ratio_y[$i] = $results[$i]->image_ratio_y;
$reports_config_watermark[$i] = $results[$i]->watermark;
$reports_config_image_watermark_x[$i] = $results[$i]->image_watermark_x;
$reports_config_image_watermark_y[$i] = $results[$i]->image_watermark_y;
$reports_config_copyright[$i] = $results[$i]->copyright;
$reports_config_iptime[$i] = $results[$i]->iptime;
$reports_config_ticker2[$i] = $results[$i]->ticker2;
$reports_config_tickerAPI2[$i] = $results[$i]->tickerAPI2;
$reports_config_tickerUSER2[$i] = $results[$i]->tickerUSER2;
$reports_config_tickerDEBUG2[$i] = $results[$i]->tickerDEBUG2;
$reports_config_vehicleupload[$i] = $results[$i]->vehicleupload;
$reports_config_missionupload[$i] = $results[$i]->missionupload;
$reports_config_missioniconupload[$i] = $results[$i]->missioniconupload;
$reports_config_alertingupload[$i] = $results[$i]->alertingupload;
$reports_config_gmap_zoom_show[$i] = $results[$i]->gmap_zoom_show;
$reports_config_gmap_max_level_show[$i] = $results[$i]->gmap_max_level_show;
$reports_config_allowmap[$i] = $results[$i]->allowmap;
$reports_config_listiconupload[$i] = $results[$i]->listiconupload;
$reports_config_article_char[$i] = $results[$i]->article_char;
$reports_config_frontpage[$i] = $results[$i]->frontpage;
$reports_config_joomla_cat[$i] = $results[$i]->joomla_cat;
$reports_config_thumbs[$i] = $results[$i]->thumbs;
$i++; 
}
endif;
// ---------------------------------------------------------------------------------------------------------------
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__reports_counter');
$db->setQuery($query);
$results = $db->loadObjectList();
if ($results) :
	echo 'Importiere <span class="label label-info">#_reports_counter</span>     ..........      ';
	echo count($results).' Counterdaten <span class="label label-success">erfolgreich importiert</span><br/>';
$count = count($results)-1;	
$i = 0;
while ($i <= $count) {
$reports_counter_counter_id[$i] = $results[$i]->counter_id;
$reports_counter_counter_time[$i] = $results[$i]->counter_time;
$reports_counter_counter_ip[$i] = $results[$i]->counter_ip;
$reports_counter_counter_rp_id[$i] = $results[$i]->counter_rp_id;
$i++; 
}
endif;
// ---------------------------------------------------------------------------------------------------------------
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__reports_departments');
$db->setQuery($query);
$results = $db->loadObjectList();
if ($results) :
	echo 'Importiere <span class="label label-info">#_reports_departments</span>     ..........      ';
	echo count($results).' Einsatzarten <span class="label label-success">erfolgreich importiert</span><br/>';
$count = count($results)-1;	
$i = 0;
while ($i <= $count) {
$reports_departments_id[$i] = $results[$i]->id;
$reports_departments_name[$i] = $results[$i]->name ?: '';
$reports_departments_detail1[$i] = $results[$i]->detail1 ?: '';
$reports_departments_link[$i] = $results[$i]->link ?: '';
$reports_departments_gmap_latitude[$i] = $results[$i]->gmap_latitude ?: '1';
$reports_departments_gmap_longitude[$i] = $results[$i]->gmap_longitude ?: '1';
$reports_departments_published[$i] = $results[$i]->published ?: '1';
$reports_departments_ffw[$i] = $results[$i]->ffw ?: '0';
$reports_departments_ordering[$i] = $results[$i]->ordering ?: '0';
$i++; 
}
$i = 0;
while ($i <= $count) {
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$columns = array('id', 'asset_id', 'ordering', 'name', 'detail1', 'link', 'gmap_latitude', 'gmap_longitude', 'ffw', 'state', 'created_by');
$values = array($db->quote($reports_departments_id[$i]), $db->quote('0'), $db->quote($reports_departments_ordering[$i]), $db->quote($reports_departments_name[$i]), $db->quote($reports_departments_detail1[$i]), $db->quote($reports_departments_link[$i]), $db->quote($reports_departments_gmap_latitude[$i]), $db->quote($reports_departments_gmap_longitude[$i]), $db->quote($reports_departments_ffw[$i]), $db->quote($reports_departments_published[$i]), $db->quote('') );
 
$query
    ->insert($db->quoteName('#__eiko_organisationen'))
    ->columns($db->quoteName($columns))
    ->values(implode(',', $values));
 
$db->setQuery($query);
try {
    $result = $db->execute();
} catch (Exception $e) {
    print_r ($e);
}
$i++; 
}
endif;
// ---------------------------------------------------------------------------------------------------------------
//$db = JFactory::getDbo();
//$query = $db->getQuery(true);
//$query->select('*');
//$query->from('#__reports_departments_link');
//$db->setQuery($query);
//$results = $db->loadObjectList();
//
//if ($results) :
//	echo 'Importiere <span class="label label-info">#_reports_departments_link</span>     ..........      ';
//	echo count($results).' Departments_links <span class="label label-success">erfolgreich importiert</span><br/>';
//$count = count($results)-1;	
//$i = 0;
//while ($i <= $count) {
//
//$reports_departments_link_report_id[$i] = $results[$i]->report_id;
//$reports_departments_link_department_id[$i] = $results[$i]->department_id;
//
//$i++; 
//}
//endif;
// ---------------------------------------------------------------------------------------------------------------
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__reports_display');
$db->setQuery($query);
$results = $db->loadObjectList();
if ($results) :
	echo 'Importiere <span class="label label-info">#_reports_display</span>     ..........      ';
	echo count($results).' Display-Daten <span class="label label-success">erfolgreich importiert</span><br/>';
$count = count($results)-1;	
$i = 0;
while ($i <= $count) {
$reports_display_report_id[$i] = $results[$i]->report_id;
$reports_display_data1[$i] = $results[$i]->data1;
$reports_display_image[$i] = $results[$i]->image;
$reports_display_address[$i] = $results[$i]->address;
$reports_display_date1[$i] = $results[$i]->date1;
$reports_display_date2[$i] = $results[$i]->date2;
$reports_display_date3[$i] = $results[$i]->date3;
$reports_display_summary[$i] = $results[$i]->summary;
$reports_display_boss[$i] = $results[$i]->boss;
$reports_display_people[$i] = $results[$i]->people;
$reports_display_department[$i] = $results[$i]->department;
$reports_display_desc[$i] = $results[$i]->desc;
$reports_display_alerting[$i] = $results[$i]->alerting;
$reports_display_vehicle[$i] = $results[$i]->vehicle;
$reports_display_dauer[$i] = $results[$i]->dauer;
$reports_display_logo[$i] = $results[$i]->logo;
$reports_display_mapshow[$i] = $results[$i]->mapshow;
$reports_display_boss2[$i] = $results[$i]->boss2;
$i++; 
}
endif;
// ---------------------------------------------------------------------------------------------------------------
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__reports_gmap');
$db->setQuery($query);
$results = $db->loadObjectList();
if ($results) :
	echo 'Importiere <span class="label label-info">#_reports_gmap</span>     ..........      ';
	echo count($results).' Gmap-Config-Daten <span class="label label-success">erfolgreich importiert</span><br/>';
$count = count($results)-1;	
$i = 0;
while ($i <= $count) {
$reports_gmap_gmap_id[$i] = $results[$i]->gmap_id;
$reports_gmap_gmap_zoom_level[$i] = $results[$i]->gmap_zoom_level ?: '12';
$reports_gmap_gmap_zoom_control[$i] = $results[$i]->gmap_zoom_control ?: '';
$reports_gmap_gmap_zoom[$i] = $results[$i]->gmap_zoom ?: '12';
$reports_gmap_gmap_onload[$i] = $results[$i]->gmap_onload ?: '';
$reports_gmap_gmap_width[$i] = $results[$i]->gmap_width ?: '600';
$reports_gmap_gmap_height[$i] = $results[$i]->gmap_height ?: '300';
$reports_gmap_gmap_alarmarea[$i] = $results[$i]->gmap_alarmarea ?: '53.28071418254047,7.416630163574155|53.294772929932165,7.4492458251952485|53.29815865222114,7.4767116455077485|53.31313468829642,7.459888830566342|53.29949234792138,7.478256597900327|53.29815865222114,7.506409063720639|53.286461382800795,7.521686926269467|53.26726681991669,7.499027624511655|';
$reports_gmap_start_lat[$i] = $results[$i]->start_lat ?: '53.286871867528056';
$reports_gmap_start_lang[$i] = $results[$i]->start_lang ?: '7.475510015869147';
$reports_gmap_showall[$i] = $results[$i]->showall ?: '1';
$reports_gmap_gmap_zoom_level_home[$i] = $results[$i]->gmap_zoom_level_home ?: '12';
$reports_gmap_gmap_max_zoom[$i] = $results[$i]->gmap_max_zoom ?: '14';
$i++; 
}
 
$i = 0;
while ($i <= $count) {
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->update("#__eiko_gmap_config");
$query->set('asset_id = '.$db->quote('1'),'gmap_zoom_level = '.$db->quote($reports_gmap_gmap_zoom_level[$i]),'gmap_onload = '.$db->quote($reports_gmap_gmap_onload[$i]),'gmap_width = '.$db->quote($reports_gmap_gmap_width[$i]),'gmap_height = '.$db->quote($reports_gmap_gmap_height[$i]),'gmap_alarmarea = '.$db->quote($reports_gmap_gmap_alarmarea[$i]),'start_lat = '.$db->quote($reports_gmap_start_lat[$i]),'start_lang = '.$db->quote($reports_gmap_start_lang[$i]),'state = '.$db->quote('1'),'created_by = '.$db->quote('') );
$query->where('id = '. $db->quote('1'));
$db->setQuery($query);
try {
    $result = $db->execute();
} catch (Exception $e) {
    print_r ($e);
}
$i++; 
}
endif;
// ---------------------------------------------------------------------------------------------------------------
//$db = JFactory::getDbo();
//$query = $db->getQuery(true);
//$query->select('*');
//$query->from('#__reports_usergroup');
//$db->setQuery($query);
//$results = $db->loadObjectList();
//
//if ($results) :
//	echo 'Importiere <span class="label label-info">#_reports_usergroup</span>     ..........      ';
//	echo count($results).' User-Daten <span class="label label-success">erfolgreich importiert</span><br/>';
//$count = count($results)-1;	
//$i = 0;
//while ($i <= $count) {
//
//$reports_usergroup_id[$i] = $results[$i]->id;
//$reports_usergroup_title[$i] = $results[$i]->title;
//$reports_usergroup_published[$i] = $results[$i]->published;
//$reports_usergroup_departments[$i] = $results[$i]->departments;
//
//$i++; 
//}
//endif;
// ---------------------------------------------------------------------------------------------------------------
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__reports_vehicles');
$db->setQuery($query);
$results = $db->loadObjectList();
if ($results) :
	echo 'Importiere <span class="label label-info">#_reports_vehicles</span>     ..........      ';
	echo count($results).' Fahrzeug-Daten <span class="label label-success">erfolgreich importiert</span><br/>';
$count = count($results)-1;	
$i = 0;
while ($i <= $count) {
$reports_vehicles_id[$i] = $results[$i]->id;
$reports_vehicles_name[$i] = $results[$i]->name ?: '';
$reports_vehicles_detail1[$i] = $results[$i]->detail1 ?: '';
$reports_vehicles_detail2[$i] = $results[$i]->detail2 ?: '';
$reports_vehicles_link[$i] = $results[$i]->link ?: '';
$reports_vehicles_published[$i] = $results[$i]->published ?: '';
$reports_vehicles_image[$i] = 'images/com_einsatzkomponente/images/vehicles/'.$results[$i]->image ?: '';
$reports_vehicles_detail3[$i] = $results[$i]->detail3 ?: '';
$reports_vehicles_ordering[$i] = $results[$i]->ordering ?: '0';
$reports_vehicles_department[$i] = $results[$i]->department ?: '';
$i++; 
}
$i = 0;
while ($i <= $count) {
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$columns = array('id', 'asset_id', 'ordering', 'name', 'detail1_label', 'detail1', 'detail2_label', 'detail2', 'detail3_label', 'detail3', 'detail4_label', 'detail4', 'detail5_label', 'detail5', 'detail6_label', 'detail6', 'detail7_label', 'detail7', 'department', 'link', 'image', 'desc', 'state', 'created_by');
$values = array($db->quote($reports_vehicles_id[$i]), $db->quote('0'), $db->quote($reports_vehicles_ordering[$i]), $db->quote($reports_vehicles_name[$i]), $db->quote('Detail1'), $db->quote($reports_vehicles_detail1[$i]), $db->quote('Detail2'), $db->quote($reports_vehicles_detail2[$i]), $db->quote('Detail3'), $db->quote($reports_vehicles_detail3[$i]), $db->quote('Detail4'), $db->quote(''), $db->quote('Detail5'), $db->quote(''), $db->quote('Detail6'), $db->quote(''), $db->quote('Detail7'), $db->quote(''), $db->quote($reports_vehicles_department[$i]), $db->quote($reports_vehicles_link[$i]), $db->quote($reports_vehicles_image[$i]), $db->quote(''), $db->quote($reports_vehicles_published[$i]), $db->quote('') );
 
$query
    ->insert($db->quoteName('#__eiko_fahrzeuge'))
    ->columns($db->quoteName($columns))
    ->values(implode(',', $values));
 
$db->setQuery($query);
try {
    $result = $db->execute();
} catch (Exception $e) {
    print_r ($e);
}
$i++; 
}
endif;
// ---------------------------------------------------------------------------------------------------------------
//$db = JFactory::getDbo();
//$query = $db->getQuery(true);
//$query->select('*');
//$query->from('#__reports_vehicles_link');
//$db->setQuery($query);
//$results = $db->loadObjectList();
//if ($results) :
//	echo 'Importiere <span class="label label-info">#_reports_vehicles_link</span>     ..........      ';
//	echo count($results).' Fahrzeug-Links <span class="label label-success">erfolgreich importiert</span><br/>';
//$count = count($results)-1;	
//$i = 0;
//while ($i <= $count) {
//$reports_vehicles_link_report_id[$i] = $results[$i]->report_id;
//$reports_vehicles_link_vehicle_id[$i] = $results[$i]->vehicle_id;
//$reports_vehicles_link_order_id[$i] = $results[$i]->order_id;
//$i++; 
//}
//endif;
// ------------------------------------------------------------------------------------------------------------
?>
<?php echo '<br/><br/>';?>
<?php if ($bug == '0') : ?>
<?php echo '<span class="label label-success">Installation erfolgreich ...</span><br/><br/>';?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div align="center">
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
<?php echo '<span class="label label-important">Installation nicht erfolgreich ...</span><br/><br/>Versuchen Sie es nochmal, oder wenden Sie sich an das Supportforum : <a href="http://www.einsatzkomponente.de" target="_blank">http://www.einsatzkomponente.de</a>';?>
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
<input
   type="button"
   class="btn btn-danger"
   value=" alte Datenbanktabellen importieren ? "
   title=""
   onclick="window.location='index.php?option=com_einsatzkomponente&view=datenimport'"
   />   </div>
</form>
<?php endif; ?>
</div>
<?php
// ---- Daten -----
?>
