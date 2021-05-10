<?php
/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */

// no direct access
defined('_JEXEC') or die;  
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Plugin\PluginHelper;

//JHtml::_('bootstrap.tooltip');

//Load admin language file
$lang = Factory::getLanguage();
$lang->load('com_einsatzkomponente', JPATH_ADMINISTRATOR);

$vehicles_images = '';
//print_r ($this->item); 
?>

 
<?php if( $this->item ) : ?>  <!--Einsatzdaten vorhanden ? Sonst ENDE --> 
            <!--Navigation-->
			<div class="eiko_navbar_2 " style="float:<?php echo $this->params->get('navi_detail_pos','left');?>;"><?php echo $this->navbar;?></div>
            <!--Navigation ENDE-->
          
    
			<div class="eiko_distance5_2">&nbsp;</div>
    		<div class="eiko_clearfix"></div>

            <!--Headline-->
        	<h1 class="eiko_headline_2">
			
			<?php if ($this->params->get('display_detail_tickerkat_icon','1') == '1') :?> 
            <?php if (isset($this->tickerKat->image)) :?>
        	<img  class="eiko_img-rounded_2 eiko_list_icon_2 mobile_hide_320" src="<?php echo JURI::Root();?><?php echo $this->tickerKat->image;?>"  alt="" title="<?php echo Text::_($this->tickerKat->title); ?>"/>
            <?php endif;?>
            <?php endif;?>
			
			<?php if ($this->params->get('display_detail_einsatzart_icon','0') == '1') :?> 
            <?php if (isset($this->einsatzlogo->list_icon)) :?>
        	<img  class="eiko_img-rounded_2 eiko_list_icon_3 mobile_hide_320" src="<?php echo JURI::Root();?><?php echo $this->einsatzlogo->list_icon;?>"  alt="eiko_list_icon" title="<?php echo Text::_($this->einsatzlogo->title); ?>"/>
            <?php endif;?>
            <?php endif;?>
			
			<span class="eiko_kurzbericht_2"><?php echo $this->item->summary; ?></span>
			
			<?php if ($this->params->get('display_detail_einsatznummer','0') == '1') :?> 
			 <small style="font-size:smaller;" class="text-muted eiko_detail_einsatznummer"><?php echo Text::_('</br>(Einsatz-Nr.'); ?> <?php echo $this->einsatznummer.')'; ?></small> 
            <?php endif;?>
			
            </h1>
            <!--Headline ENDE-->
            
            <!--Einsatzkategorie-->
			<?php if ($this->params->get('display_detail_tickerkat','1') == '1') :?> 
            <?php if( $this->item->tickerkat ) : ?>
        	<span class="eiko_einsatzkategorie_2"><!--<?php echo Text::_('COM_EINSATZKOMPONENTE_KATEGORIE'); ?> --><?php echo Text::_($this->tickerKat->title); ?></span>
            <?php endif;?>
            <?php endif;?>
            <!--Einsatzkategorie ENDE-->
			
            <!--Einsatzart-->
			<?php if ($this->params->get('display_detail_einsatzart','0') == '1') :?> 
            <?php if( $this->item->data1 ) : ?>
        	<br /><span class="eiko_einsatzart_2"><!--<?php echo Text::_('COM_EINSATZKOMPONENTE_EINSATZART'); ?> --><?php echo Text::_($this->einsatzlogo->title); ?></span>
            <?php endif;?>
            <?php endif;?>
            <!--Einsatzart ENDE-->

			<?php if ($this->params->get('display_detail_hits','1')):?>
            <br/><span class="badge small eiko_counter_detail"><?php echo Text::_('COM_EINSATZKOMPONENTE_ZUGRIFFE'); ?> <?php echo $this->item->counter; ?></span> 
            <?php endif;?>
			
            <div class="eiko_clearfix"></div>
			
            <!--Einsatzkarte-->
			<?php $user	= Factory::getUser();?>
            <?php if( $this->item->gmap) : ?> 
            <?php if( $this->item->gmap_report_latitude != '0' ) : ?> 
            <?php if( $this->params->get('display_detail_map_for_only_user','0') == '1' || $user->id ) :?> 
			<?php if ($this->params->get('gmap_action','0') == '1') :?> 
  			<div id="map-canvas" class="eiko_einsatzkarte_2" style="height:<?php echo $this->params->get('detail_map_height','250px');?>;">
    		<noscript>Dieser Teil der Seite erfordert die JavaScript Unterstützung Ihres Browsers!</noscript>
			</div>
            <?php endif;?>
			<?php if ($this->params->get('gmap_action','0') == '2') :?>
   				<div id="map_canvas" class="eiko_einsatzkarte_2" style="height:<?php echo $this->params->get('detail_map_height','250px');?>;"></div> 
    		<noscript>Dieser Teil der Seite erfordert die JavaScript Unterstützung Ihres Browsers!</noscript>
			
			<?php OsmHelper::installOsmMap();?>
			<?php OsmHelper::callOsmMap($this->gmap_config->gmap_zoom_level,$this->gmap_config->start_lat,$this->gmap_config->start_lang); ?>
			
			<?php if ($this->params->get('display_detail_einsatz_marker','1')) :?>
			<?php OsmHelper::addEinsatzortMap($this->item->gmap_report_latitude,$this->item->gmap_report_longitude,$this->item->summary,$this->einsatzlogo->icon,$this->item->id);?>
			<?php endif;?> 
			
			<?php if ($this->params->get('display_detail_organisationen','1')) :?>
			<?php OsmHelper::addOrganisationenMap($this->organisationen);?>
			<?php endif;?>
			<?php if ($this->params->get('display_detail_einsatzgebiet','1')) :?>
			<?php OsmHelper::addPolygonMap($this->einsatzgebiet,'blue');?>
			<?php endif;?> 
			
            <?php endif;?>
			<?php else:?> 
			<?php echo '<span style="padding:5px;" class="label label-info">( Bitte melden Sie sich an, um den Einsatzort auf einer Karte zu sehen. )</span><br/><br/>';?>
			<?php endif;?>
            <?php endif;?>
            <?php endif;?>
            <!--Einsatzkarte ENDE-->


<div class="eiko_content_2 eiko_detailbox_2"> <!-- eiko_content -->
  
    <table class="eiko_table1_2">
      <tr>
        <td class="eiko_td_spalte1_2">
          <table class="eiko_table2_2">
            <tr>
              <td class="eiko_td1_2 mobile_hide_320"><span class="eiko_einsatzort_label_2">
			  <?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_ADDRESS'); ?> 
              </span></td>
              <td class="eiko_td1_2">
			  <?php echo '<span class="mobile_show_320"><b>Details</b><br/><br/></span>'; ?> 
			  <span class="eiko_einsatzort_value_2"><?php echo $this->item->address.''; ?>
			<?php if ($this->params->get('gmap_action','0')) : ?>
            <?php if( $this->item->gmap ) : ?>
              <div class="eiko_distance_road hasTooltip" title ="Die Angabe kann vom tats&auml;chlichen Streckenverlauf abweichen, da diese Angabe automatisch von Google Maps errechnet wurde !" id="distance_road"></div>
            <?php endif;?>
            <?php endif;?>
              </span></td>
            </tr>
            <tr>
              <td class="eiko_td2_2 mobile_hide_320"><span class="eiko_date1_label_2">
			  <?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_DATE'); ?> 
              </span></td>
              <td class="eiko_td2_2"><span class="eiko_date1_value_2"><?php echo date("d.m.Y", strtotime($this->item->date1)).''; ?></span></td>
            </tr>
				<?php if ($this->params->get('display_alertingtime','1')) : ?>
				<tr>
              <td class="eiko_td1_2 mobile_hide_320"><span class="eiko_date1_time_label_2">
			  <?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_DATE1'); ?> 
              </span></td>
              <td class="eiko_td1_2"><span class="eiko_date1_time_value_2"><?php echo date("H:i", strtotime($this->item->date1)).' Uhr'; ?></span></td>
            </tr>
				<?php endif;?>
            <?php if( $this->item->date2>1) : ?>
            <tr class="mobile_hide_320">
              <td class="eiko_td1_2 mobile_hide_320"><span class="eiko_date1_time_label_2">
			  <?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_TIMESTART'); ?>: 
              </span></td>
              <td class="eiko_td1_2"><span class="eiko_date1_time_value_2"><?php echo date("H:i", strtotime($this->item->date2)).' Uhr'; ?></span></td>
            </tr>
				<?php endif;?>
            <?php if( $this->item->date3>1) : ?>
            <tr class="mobile_hide_320">
              <td class="eiko_td2_2 mobile_hide_320"><span class="eiko_date3_label_2">
			  <?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_TIMEEND'); ?> 
              </span></td>
              <td class="eiko_td2_2"><span class="eiko_date3_value_2"><?php echo date("H:i", strtotime($this->item->date3)).' Uhr'; ?></span></td>
            </tr>
            <?php endif;?>
            
            <?php if ($this->params->get('display_einsatzdauer','1') && ($this->item->date3>1) ): ?>
				<tr class="mobile_hide_320">
	              <td class="eiko_td1_2 mobile_hide_320">
	              	<span class="eiko_einsatzdauer_label_2">
				  		<?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_EINSATZDAUER'); ?>
	              	</span>
	              </td>
	              <td class="eiko_td1_2">
	              	<span class="eiko_einsatzdauer_value_2">

	              	<?php
						echo $this->einsatzdauer;
					?>

	              	</span>
	              </td>
	            </tr>
		<?php endif;?>
            
            <?php if( $this->item->alerting) : ?>
            <tr class="mobile_hide_320">
              <td class="eiko_td1_2 mobile_hide_320"><span class="eiko_alarmart_label_2">
			  <?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_ALERTING'); ?>
              </span></td>
              <td class="eiko_td1_2"><span class="eiko_alarmart_value_2"><?php echo $this->alarmierungsart->title;?></span></td>
            </tr>
            <?php endif;?>
            <?php if( $this->item->boss2) : ?>
            <tr class="mobile_hide_320">
              <td class="eiko_td2_2 mobile_hide_320"><span class="eiko_boss2_label_2">
			  <?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_BOSS2'); ?> 
              </span></td>
              <td class="eiko_td2_2"><span class="eiko_boss2_value_2"><?php echo $this->item->boss2;?></span></td>
            </tr>
            <?php endif;?>
            <?php if( $this->item->boss) : ?>
            <tr class="mobile_hide_320">
              <td class="eiko_td1_2 mobile_hide_320"><span class="eiko_boss_label_2">
			  <?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_BOSS'); ?> 
              </span></td>
              <td class="eiko_td1_2"><span class="eiko_boss_value_2"><?php echo $this->item->boss;?></span></td>
            </tr>
            <?php endif;?>
            <?php if( $this->item->people) : ?>
            <tr class="mobile_hide_320">
              <td class="eiko_td2_2 mobile_hide_320"><span class="eiko_people_label_2">
			  <?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_PEOPLE'); ?> 
              </span></td>
              <td class="eiko_td2_2"><span class="eiko_people_value_2"><?php echo $this->item->people;?></span></td>
            </tr>
            <?php endif;?>
          </table>
        </td>
        
        <td class="eiko_td_spalte2_2"><?php echo '<b>'.Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_ORGAS').'</b>'; ?>
        <table class="eiko_table3_2"> 
        <tr><td class="eiko_td3_2"> <br/>
        
      
            <?php if( $this->item->auswahl_orga ) : ?>   
			<?php
				$array = array();
				foreach((array)$this->item->auswahl_orga as $value): 
					if(!is_array($value)):
						$array[] = $value;
					endif;
				endforeach;
				$data = array();
				foreach($array as $value):
					$db = Factory::getDbo();
					$query	= $db->getQuery(true);
					$query
						->select('*')
						->from('#__eiko_organisationen')
						->where('id = "' .$value.'" AND state="1" ');
					$db->setQuery($query);
					$results = $db->loadObjectList();
					if ($results[0]->name) :
					if ($this->params->get('display_detail_orga_links','1')) :
					if (!$results[0]->link) :
					?>
					<a target="_self" href="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=organisation&Itemid='.$this->params->get('orgalink','').'&id=' . $results[0]->id); ?>"><?php echo $results[0]->name; ?></a><br/> 
					<?php	
					else :
					?>
					<a target="_blank" href="<?php echo $results[0]->link; ?>"><?php echo $results[0]->name; ?></a><br/>
					<?php	
					endif;	
					else:
					if ($results[0]->link) : ?>
					<a target="_blank" href="<?php echo $results[0]->link; ?>"><?php echo $results[0]->name; ?></a><br/>
					<?php else:?>
					<?php echo $results[0]->name; ?><br/>
					<?php endif; ?>
					<?php endif; ?>
					<?php endif; ?>
					<?php
						if( $this->item->vehicles ) :
						$orga_fahrzeuge = EinsatzkomponenteHelper::getOrga_fahrzeuge($results[0]->id);
						$array = array();
						foreach((array)$orga_fahrzeuge as $value): 
						if(!is_array($value)):
						$array[] = $value;
						endif;
						endforeach;
						
						$array_vehicle = array();
						foreach((array)$this->item->vehicles as $value): 
						if(!is_array($value)):
						$array_vehicle[] = $value;
						endif;
						endforeach;
						echo '<div class="items"><ul class="items_list eiko_item_ul">';
						foreach($array as $value):
				// sonstige Fahrzeuge anzeigen lassen
						if (in_array($value->id, $array_vehicle)) : 
						if ($value->state == '2'): $value->name = $value->name.' (a.D.)';endif;
						echo '<li class="eiko_item_li">';
						//if ($array_vehicle == $value->id) : echo $value->name;break; endif;
						if ($this->params->get('display_detail_fhz_links','1')) :
						
						if (!$value->link) : ?>
                        
						<a title ="<?php echo $value->detail2;?>" target="_self" href="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeug&Itemid='.$this->params->get('vehiclelink','').'&id=' . $value->id); ?>"><?php echo $value->name; ?></a>
						<?php $vehicles_images .= '<a href="'.Route::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeug&Itemid='.$this->params->get('vehiclelink','').'&id=' . $value->id).'" target="_self">&nbsp;&nbsp;<img class="eiko_img-rounded eiko_image_fahrzeugaufgebot" src="'.JURI::Root().$value->image.'"  alt="'.$value->name.'" title="'.$value->name.'   '.$value->detail2.'"/></a>';?>
                        
                        <?php else: ?>
						<a title ="<?php echo $value->detail2;?>" target="_blank" href="<?php echo $value->link; ?>"><?php echo $value->name; ?></a>
						<?php $vehicles_images .= '<a href="'.$value->link.'" target="_blank">&nbsp;&nbsp;<img class="eiko_img-rounded eiko_image_fahrzeugaufgebot" src="'.JURI::Root().$value->image.'"  alt="'.$value->name.'" title="'.$value->name.'   '.$value->detail2.'"/></a>';?>
                        
						<?php endif; ?>
						<?php else:
						if ($value->link) : 
						?>
						<a title ="<?php echo $value->detail2;?>" target="_blank" href="<?php echo $value->link; ?>"><?php echo $value->name; ?></a>
						<?php $vehicles_images .= '<a href="'.$value->link.'" target="_blank">&nbsp;&nbsp;<img class="eiko_img-rounded eiko_image_fahrzeugaufgebot" src="'.JURI::Root().$value->image.'"  alt="'.$value->name.'" title="'.$value->name.'   '.$value->detail2.'"/></a>';
						else:
						echo $value->name;
						$vehicles_images .= '&nbsp;&nbsp;<img  style="padding-right:3px;margin-right:3px;" class="eiko_img-rounded eiko_image_fahrzeugaufgebot" src="'.JURI::Root().$value->image.'"  alt="'.$value->name.'" title="'.$value->name.'   '.$value->detail2.'"/>';
						endif;
						echo '</li>';
						endif;						endif;

						endforeach;
						echo '</ul></div>';
  						endif;
				endforeach;
				
				// sonstige Fahrzeuge anzeigen lassen
				if( $this->item->vehicles ) :
				if ($sonstige = EinsatzkomponenteHelper::getFahrzeuge_mission($array_vehicle,'','sonstige Kräfte')) : echo $sonstige; endif;
				if ($sonstige = EinsatzkomponenteHelper::getFahrzeuge_mission_image($array_vehicle,'')) : $vehicles_images .= $sonstige; endif;
				endif;
			?>
				
            <?php endif;?>

        
      

        </td></tr></table>
        </td>
        <td class="eiko_td4_2"></td>
      </tr>
				<?php if ($this->params->get('display_detail_fhz_images','1') and $this->item->vehicles) :?>
                <tr class="mobile_hide_320">
                <td class="eiko_fahrzeugaufgebot_2" style="margin-bottom:10px;padding-bottom:10px;" colspan="2">
				<?php echo '<span class="mobile_hide_320">'.Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_VEHICLE').' </span>'; ?> 
                <?php echo $vehicles_images ;?>
                </td>
                </tr>
                <?php endif;?>
    </table>
     

<!--Titelbild mit Highslide JS-->
<?php if( $this->item->image ) : ?>
<?php $this->item->image = preg_replace("%thumbs/%", "", $this->item->image,1); ?>
<a href="<?php echo JURI::Root().$this->item->image;?>" rel="highslide[<?php echo $this->item->id; ?>]" class="highslide" onClick="return hs.expand(this, { captionText: '<?php echo $this->einsatzlogo->title;?> am <?php echo date("d.m.Y - H:i", strtotime($this->item->date1)).' Uhr'; ?>' });" alt ="<?php echo $this->einsatzlogo->title;?>">
                  <img class="eiko_img-rounded_2 eiko_detail_image_2" src="<?php echo JURI::Root().$this->item->image;?>"  alt="<?php echo $this->einsatzlogo->title;?>" title="<?php echo $this->einsatzlogo->title;?>" alt ="<?php echo $this->einsatzlogo->title;?>"/>
                  </a>
<?php endif;?>
<?php if( !$this->item->image AND $this->params->get('display_home_image_nopic','0') ) : ?>
					<img  class="eiko_img-rounded_2 eiko_detail_image_2" src="<?php echo JURI::Root().'images/com_einsatzkomponente/einsatzbilder/nopic.png';?>"/>
<?php endif;?>

<!--Titelbild mit Highslide JS  ENDE--> 


<!--Einsatzbericht anzeigen mit Plugin-Support-->  
<?php if( $this->item->desc) : ?>
<?php if ($this->params->get('display_detail_desc','1')): ?>
<?php jimport('joomla.html.content'); ?>  
<?php $Desc = JHTML::_('content.prepare', $this->item->desc); ?>
<div class="eiko_einsatzbericht_2">
<h3 class="einsatzbericht-title"><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_DESC'); ?></h3>
<?php echo $Desc;?>
</div>
<?php endif;?>
<?php endif;?>
<!--Einsatzbericht anzeigen mit Plugin-Support  ENDE-->  

<!-- Plugin-Support "MyShariff" -->  
		<?php
			$plugin = PluginHelper::getPlugin('content', 'myshariff') ;
			if ($plugin) : 	echo JHTML::_('content.prepare', '{myshariff}');endif;
			?>
<!-- Plugin-Support "MyShariff"  ENDE -->  

<!--eingesetzte Ausrüstung anzeigen -->  
<?php 	if ($this->params->get('display_detail_ausruestung','1')) : 
		if(!$this->item->ausruestung == '') :
		if ($this->params->get('eiko','0')) : 
				$array = array();
				$ausruestung = '';
				foreach((array)$this->item->ausruestung as $value): 
					if(!is_array($value)):
						$array[] = $value;
					endif;
				endforeach;
				$data = array();
				foreach($array as $value):
					$db = Factory::getDbo();
					$query	= $db->getQuery(true);
					$query
						->select('*')
						->from('#__eiko_ausruestung')
						->where('id = "' .$value.'" AND state="1" ');
					$db->setQuery($query);
					$results = $db->loadObjectList();
					$ausruestung .= '<li>'.$results[0]->name.'</li>';
				endforeach; 
  
 ?>
 <div class="eiko_ausruestung"><b>u.a. eingesetzte Ausrüstung</b> <ul><?php echo $ausruestung;?></ul></div> 
 <?php endif;?>
 <?php endif;?>
 <?php endif;?>
<!--eingesetzte Ausrüstung anzeigen ENDE -->  


<div class="clear"></div>
<!--Einsatzbilder Galerie -->           
			<?php if ($this->images) : ?>
  			<div class="eiko_distance100_2">&nbsp;</div>
   			<h2 class="eiko_sonstige_info_2"><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_INFO'); ?></h2>
      		<h3 class="eiko_einsatzbilder_headline_2"><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_GALERY'); ?></h3> 
            <div class="row-fluid">
            <ul class="thumbnails eiko_thumbnails_2">
            <?php
			$n = false;
			for ($i = count($this->images)-count($this->images);$i < count($this->images);++$i) { 
			if (@$this->images[$i]->comment) : $n = true; 
			endif;
			}
			$i= '';
			for ($i = count($this->images)-count($this->images);$i < count($this->images);++$i) { 
			if (@$this->images[$i]) :
			$fileName_thumb = JURI::Root().$this->images[$i]->thumb;
			$fileName_image = JURI::Root().$this->images[$i]->image;
			$thumbwidth = $this->params->get('detail_thumbwidth','100px'); 
			?>   
              <li>
                <div class="thumbnail eiko_thumbnail_2" style="max-width:<?php echo $thumbwidth;?>;)">
    			<a href="<?php echo $fileName_image;?>" rel="highslide[<?php echo $this->item->id; ?>]" class="highslide" onClick="return hs.expand(this, { captionText: '<?php echo $this->einsatzlogo->title;?> am <?php echo date("d.m.Y - H:i", strtotime($this->item->date1)).' Uhr'; ?><?php if ($this->images[$i]->comment) : ?><?php echo '<br/>Bild-Info: '.$this->images[$i]->comment;?><?php endif; ?>' });" alt ="<?php echo $this->einsatzlogo->title;?>">
                <img  class="eiko_img-rounded eiko_thumbs_2" src="<?php echo $fileName_thumb;?>"  alt="<?php echo $this->einsatzlogo->title;?>" title="Bild-Nr. <?php echo $this->images[$i]->id;?>"  style="width:<?php echo $this->params->get('detail_thumbwidth','100px');?>;" alt ="<?php echo $this->einsatzlogo->title;?>"/>
				
<?php if ($this->images[$i]->comment) : ?>
<br/><i class="icon-info-sign" style=" margin-right:5px;"></i><small>Bild-Info</small>
 <?php else: ?>
<?php if ($n == true) : echo '<br/><i class="" style=" margin-right:5px;"></i><small></small>
';endif;?>
 <?php endif; ?>
              </a>
			  </div>
           </li>
			<?php endif; ?>
			<?php 	} ?>
         </ul>
        </div>
<?php endif; ?>
<!--Einsatzbilder Galerie ENDE -->           



</div><!-- eiko_content ENDE -->

<!-- Presselinks -->           
<?php if( $this->item->presse or $this->item->presse2 or $this->item->presse3) : ?>
 <div class="eiko_distance100_2">&nbsp;</div> 
 <h3 class="eiko_presselinks_headeline_2"><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_QUELLE'); ?></h3>
           <table class="eiko_table_presselinks_2">
           <tr>
           <td class="eiko_td_presselinks_2">
            <?php if( $this->item->presse) : ?>
			<?php echo '<a href="'.$this->item->presse.'" target="_blank"><i class="icon-share-alt" style=" margin-right:5px;"></i><small>'.$this->item->presse_label.'</small></a><br/>'; ?>
            <?php endif;?>
            <?php if( $this->item->presse2 ) : ?>
			<?php echo '<a href="'.$this->item->presse2.'" target="_blank"><i class="icon-share-alt" style=" margin-right:5px;"></i><small>'.$this->item->presse2_label.'</small></a><br/>'; ?>
            <?php endif;?>
            <?php if( $this->item->presse3 ) : ?>
			<?php echo '<a href="'.$this->item->presse3.'" target="_blank"><i class="icon-share-alt" style=" margin-right:5px;"></i><small>'.$this->item->presse3_label.'</small></a><br/>'; ?>
            <?php endif;?>
            </td>
            </tr>
            </table>
            <?php endif;?>
<!-- Presselinks ENDE -->           


<?php else:?>
<div class="eiko_distance20_2">&nbsp;</div>
<h3 class="eiko_keine_daten_2"><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_NO_DATA'); ?></h3>
<?php endif;?>


<!-- Detail-Footer -->           
<?php if ($this->params->get('display_detail_footer','1')) : ?>
<div class="eiko_distance100_2">&nbsp;</div>
<div class="eiko_detail_footer_2"><i class="icon-info-sign" style="margin-right:5px;"></i><?php echo $this->params->get('display_detail_footer_text','Kein Detail-Footer-Text vorhanden');?> </div>
<?php endif;?>
<!-- Detail-Footer ENDE -->           

<div class="clear"></div> 
