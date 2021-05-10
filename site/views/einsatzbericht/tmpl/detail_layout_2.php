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
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;


//Load admin language file
$lang = Factory::getLanguage();
$lang->load('com_einsatzkomponente', JPATH_ADMINISTRATOR);

?>

          
<?php if( $this->item ) : ?> 

            <!--Navigation-->
			<div class="eiko_navbar_2" style="float:<?php echo $this->params->get('navi_detail_pos','left');?>;"><?php echo $this->navbar;?></div>
            <!--Navigation ENDE-->
    
    <div class="clearfix"></div>






        <h1 class="einsatzdetails_headline">
        <img  class="img-rounded" src="<?php echo JURI::Root();?><?php echo $this->tickerKat->image;?>"  alt="" title=""/>
		<?php echo $this->tickerKat->title; ?></h1>
        
            <?php if( $this->item->tickerkat ) : ?>
        	<span class="einsatzdetails_sub_headline">Einsatzart: <?php echo Text::_($this->einsatzlogo->title); ?></span>
            <?php endif;?>
        
        <hr/>

        <span style="font-weight: bold;"><u>Datum &amp; Uhrzeit:</u></span> <?php echo date("d.m.Y - H:i", strtotime($this->item->date1)).' Uhr'; ?>
			<?php if ($this->params->get('display_detail_hits','1')):?>
            <span class="badge pull-right small">Zugriffe: <?php echo $this->item->counter; ?></span>
            <?php endif;?>
            
        <br/>
        <span style="font-weight: bold;"><u>Einsatzort:</u></span> <?php echo $this->item->address; ?><br/>
        
        <table width="100%"><tr>
        
            <?php if( $this->item->image ) : ?>
			<?php $this->item->image = preg_replace("%thumbs/%", "", $this->item->image,1); ?>
            <td style="float:left;">            
                <div class="detail_image">
                  <img   class="img-rounded" style="height:220px;" src="<?php echo JURI::Root();?><?php echo $this->item->image;?>"  alt="" title=""/>
                </div>
   			</td>         
            <?php endif;?>
 
            <!--Einsatzkarte-->
			<?php $user	= Factory::getUser();?>
            <?php if( $this->item->gmap) : ?> 
            <?php if( $this->item->gmap_report_latitude != '0' ) : ?> 
            <?php if( $this->params->get('display_detail_map_for_only_user','0') == '1' || $user->id ) :?> 
			<?php if ($this->params->get('gmap_action','0')=='1') : ?>
            <td style="float:right;width:50%;" class="eiko_top_td_detail_2">
			<div  id="map-canvas" style="min-width:350px;width:100%;border:solid #000 1px;height:<?php echo $this->params->get('detail_map_height','250px');?>"></div>
            <div id="distance_direct" title ="Die Angabe kann vom tats&auml;chlichen Streckenverlauf abweichen, da diese Angabe automatisch von Google Maps errechnet wurde !"></div>
            </td>
            <?php endif;?>
			<?php if ($this->params->get('gmap_action','0')=='2') : ?>
            <td style="float:right;width:50%;" class="eiko_top_td_detail_2">
   				<div id="map_canvas" class="eiko_einsatzkarte_2" style="width:300px;height:<?php echo $this->params->get('detail_map_height','250px');?>;"></div> 
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

            </td>
            <?php endif;?>
			<?php else:?> 
			<?php echo '<span style="padding:5px;" class="label label-info">( Bitte melden Sie sich an, um den Einsatzort auf einer Karte zu sehen. )</span><br/><br/>';?>
			<?php endif;?>
            <?php endif;?>
            <?php endif;?>
            <!--Einsatzkarte ENDE-->
      		</tr>
      
			</table>
            <br/>

        	<h4 class="headline"><?php echo $this->item->summary; ?>
			<?php if ($this->params->get('display_detail_einsatznummer','0') == '1') :?> 
			 <small style="font-size:smaller;" class="text-muted eiko_detail_einsatznummer"><?php echo Text::_('</br>(Einsatz-Nr.'); ?> <?php echo $this->einsatznummer.')'; ?></small> 
            <?php endif;?>
			</h4>
            
            <!--Einsatzbericht anzeigen mit Plugin-Support-->   
			<?php if( $this->item->desc) : ?>
			<?php if ($this->params->get('display_detail_desc','1')): ?>
            <?php jimport('joomla.html.content'); ?>  
            <?php $Desc = JHTML::_('content.prepare', $this->item->desc); ?>
        	<p style="text-align: justify;"><?php echo $Desc; ?></p>
           <?php endif;?>
           <?php endif;?>
           <?php endif;?>
			<?php
			$plugin = PluginHelper::getPlugin('content', 'myshariff') ;
			if ($plugin) : 	echo JHTML::_('content.prepare', '{myshariff}');endif;
			?>

            <?php if( $this->item->presse or $this->item->presse2 or $this->item->presse3) : ?>
           <div class="well well-small">
			<?php echo '<small>'.Text::_('weiterführende Informationen :').'</small>'; ?>
           
            <?php if( $this->item->presse) : ?>
			<?php echo '<a href="'.$this->item->presse.'" target="_blank"><i class="icon-share-alt" style="margin-right:5px;"></i><small>'.$this->item->presse_label.'</small></a>'; ?>
            <?php endif;?>
            <?php if( $this->item->presse2 ) : ?>
			<?php echo '<a href="'.$this->item->presse2.'" target="_blank"><i class="icon-share-alt" style="margin-right:5px;"></i><small>'.$this->item->presse2_label.'</small></a>'; ?>
            <?php endif;?>
            <?php if( $this->item->presse3 ) : ?>
			<?php echo '<a href="'.$this->item->presse3.'" target="_blank"><i class="icon-share-alt" style="margin-right:5px;"></i><small>'.$this->item->presse3_label.'</small></a>'; ?>
            <?php endif;?>
            </div>
            <?php endif;?>


           
            <table width="100%"><tr><td>
            
            <?php if( $this->item->auswahl_orga ) : ?>           
            <div class="well well-small">
			<?php echo '<span style="font-weight: bold;"><u>'.Text::_('alarmierte Organisationen').'</u></span>'; ?>:
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
						->where('id = "' .$value.'"');
					$db->setQuery($query);
					$results = $db->loadObjectList();
					if (!$results[0]->link) :
					$data[] = '<a href="'.Route::_('index.php?option=com_einsatzkomponente&view=organisation&Itemid='.$this->params->get('orgalink','').'&id=' . $results[0]->id).'" target="_self" alt="'.$results[0]->link.'">'.$results[0]->name.'</a>';
					else:					
					$data[] = '<a href="'.$results[0]->link.'" target="_blank" alt="'.$results[0]->link.'">'.$results[0]->name.'</a>';
					endif;
					
				endforeach;
				$this->item->auswahl_orga = implode(', ',$data); ?>
			<?php echo $this->item->auswahl_orga; ?>
            <?php endif;?>
            <br/><br/>
            
            <?php if( $this->item->vehicles ) : ?>
			<?php
				$array = array();
				foreach((array)$this->item->vehicles as $value): 
					if(!is_array($value)):
						$array[] = $value;
					endif;
				endforeach;
				$data = array();
				$vehicles_images = array();
				$vehicles_list = array();
				foreach($array as $value):
					$db = Factory::getDbo();
					$query	= $db->getQuery(true);
					$query
						->select('*')
						->from('#__eiko_fahrzeuge')
						->where('id = "' .$value.'"');
					$db->setQuery($query);
					$results = $db->loadObjectList();
					$data[] = $results[0]->name;
					if ($results[0]->state == '2'): $results[0]->name = $results[0]->name.' (a.D.)';endif;
					if (!$results[0]->link) :
					$vehicles_images[] = '<a href="'.Route::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeug&Itemid='.$this->params->get('vehiclelink','').'&id=' . $results[0]->id).'" target="_self"><img class="img-rounded eiko_image_fahrzeugaufgebot" src="'.JURI::Root().$results[0]->image.'"  alt="'.$results[0]->name.'" title="'.$results[0]->name.'  '.$results[0]->detail2.'"/></a>';
					$vehicles_list[] = '<li><a href="'.Route::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeug&Itemid='.$this->params->get('vehiclelink','').'&id=' . $results[0]->id).'" target="_self">'.$results[0]->name.'</a>  '.$results[0]->detail2.'</li>';
					else:
					$vehicles_images[] = '<a href="'.$results[0]->link.'" target="_blank"><img class="img-rounded eiko_image_fahrzeugaufgebot" src="'.JURI::Root().$results[0]->image.'"  alt="'.$results[0]->name.'" title="'.$results[0]->name.'  '.$results[0]->detail2.'"/></a>';
					$vehicles_list[] = '<li><a href="'.$results[0]->link.'" target="_blank">'.$results[0]->name.'</a>  '.$results[0]->detail2.'</li>';
					endif;
				endforeach;
				$this->item->vehicles = implode(', ',$data); 
				$vehicles_images = implode(' ',$vehicles_images); 
				$vehicles_list = implode('',$vehicles_list); ?>
            <?php endif;?>
            
            <?php if( $this->item->vehicles ) : ?>
			<?php echo '<span style="font-weight: bold;"><u>'.Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_VEHICLES').'</u></span>'; ?>:
			<!--<?php echo '<span>'.$this->item->vehicles.'</span>';?>-->
            <?php echo '<span>'.$vehicles_images.'</span>';?>
			<?php echo '<br/><br/><span><ul>'.$vehicles_list.'</span></ul>';?>
            <?php endif;?>
	</div>
</td><td></td></tr>
<tr><td colspan="2">
  <div class="distance100">&nbsp;</div>
<?php if ($this->images) : ?>
   <h2>Sonstige Informationen</h2>
      <h3>Einsatzbilder</h3> 
              <div class="row-fluid">
            <ul class="thumbnails">
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

</td>
</tr>
<?php if ($this->params->get('display_detail_footer','1')) : ?>
<tr><td>
<div class="distance100">&nbsp;</div>
<div class="detail_footer"><i class="icon-info-sign" style="margin-right:5px;"></i><?php echo $this->params->get('display_detail_footer_text','Kein Detail-Footer-Text vorhanden');?> </div>
</td></tr>
<?php endif;?>


</table>

















