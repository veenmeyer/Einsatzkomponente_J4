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


//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_einsatzkomponente', JPATH_ADMINISTRATOR);

$user = JFactory::getUser($this->item->created_by);
$this->item->created_by=$user->get('username');
?>

  
          
<?php if( $this->item ) : ?> 

    
    <div class="post-inner group">
	
    <h1 class=""><?php echo $this->item->summary; ?> - <?php echo date("d.m.Y", strtotime($this->item->date1)).''; ?></h1>
	<p class="" style="font-size:smaller;">Bericht veröffentlicht von   
		<span class="vcard author">
			<span class="">
				<i class="icon-user" style="margin-right:5px;"></i>
					<a href="" title="Beiträge von <?php echo $this->item->created_by;?>" rel="author"><?php echo $this->item->created_by;?></a>
			</span>
		</span> am
        <span class="published"><?php echo date("d.m.Y", strtotime($this->item->createdate)).''; ?>
		</span>
					<?php if ($this->params->get('display_detail_einsatznummer','0') == '1') :?> 
			 <span style="font-size:smaller;" class="text-muted eiko_detail_einsatznummer"><?php echo JText::_('</br>(Einsatz-Nr.'); ?> <?php echo $this->einsatznummer.')'; ?></span> 
            <?php endif;?>

    </p>
      
      <div class="clear"></div>

      <div class="">
        <div class="">
          <p>
		  
		  <strong>Datum:</strong> <?php echo date("d.m.Y", strtotime($this->item->date1)).''; ?>&nbsp;<br>
		  
		  <strong>Alarmzeit:</strong> <?php echo date("H:i", strtotime($this->item->date1)).' Uhr'; ?><br>
		  
		  <strong>Alarmierungsart:</strong> <?php echo $this->alarmierungsart->title;?><br>
		  
          <?php if ($this->params->get('display_einsatzdauer','1') && ($this->item->date3>1) ): ?>
		  <strong>Dauer:</strong> <?php	echo $this->einsatzdauer;?><br>
		  <?php endif;?>
		  
            <!--Einsatzkategorie-->
			<?php if ($this->params->get('display_detail_tickerkat','1') == '1') :?> 
            <?php if( $this->item->tickerkat ) : ?>
			<strong>Kategorie:</strong> <?php echo JText::_($this->tickerKat->title);?><br>
            <?php endif;?>
            <?php endif;?>
            <!--Einsatzkategorie ENDE-->
			
            <!--Einsatzart-->
			<?php if ($this->params->get('display_detail_einsatzart','0') == '1') :?> 
            <?php if( $this->item->data1 ) : ?>
			<strong>Art:</strong> <?php echo JText::_($this->einsatzlogo->title);?><br>
            <?php endif;?>
            <?php endif;?>
            <!--Einsatzart ENDE-->
			
			<strong>Einsatzort:</strong> <?php echo $this->item->address.''; ?><br>

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
					$db = JFactory::getDbo();
					$query	= $db->getQuery(true);
					$query
						->select('*')
						->from('#__eiko_fahrzeuge')
						->where('id = "' .$value.'"');
					$db->setQuery($query);
					$results = $db->loadObjectList();
					$data[] = $results[0]->name;
					if ($results[0]->state == '2'): $results[0]->name = $results[0]->name.' (a.D.)';endif;
					
					if ($this->params->get('display_detail_fhz_links','1')) :
					if (!$results[0]->link) :
					$vehicles_list[] = '<a href="'.JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeug&Itemid='.$this->params->get('vehiclelink','').'&id=' . $results[0]->id).'" target="_self">'.$results[0]->name.'</a>';
					$vehicles_images[] = '<span style="margin-right:10px;background-color:#D8D8D8;white-space:nowrap;"><a href="'.JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeug&Itemid='.$this->params->get('vehiclelink','').'&id=' . $results[0]->id).'" target="_self"><img width="40px" style="margin-top:15px;"  src="'.JURI::Root().$results[0]->image.'"  alt="'.$results[0]->name.'" title="'.$results[0]->name.'  '.$results[0]->detail2.'"/></a>&nbsp;&nbsp;<a href="'.JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeug&Itemid='.$this->params->get('vehiclelink','').'&id=' . $results[0]->id).'" target="_self">'.$results[0]->name.'</a>  '.$results[0]->detail2.'</span>';					
					else:
					$vehicles_list[] = '<a href="'.$results[0]->link.'" target="_blank">'.$results[0]->name.'</a>';
					$vehicles_images[] = '<span style="margin-right:10px;background-color:#D8D8D8;white-space:nowrap;"><a href="'.$results[0]->link.'" target="_blank"><img width="40px" style="margin-top:15px;" src="'.JURI::Root().$results[0]->image.'"  alt="'.$results[0]->name.'" title="'.$results[0]->name.'  ('.$results[0]->detail2.')" /></a>&nbsp;&nbsp;<a href="'.$results[0]->link.'" target="_blank">&nbsp;&nbsp;'.$results[0]->name.'</a></span>';
					endif;
					else:
					
					if ($results[0]->link) :
					$vehicles_list[] = '<a href="'.$results[0]->link.'" target="_blank">'.$results[0]->name.'</a>';
					$vehicles_images[] = '<span style="margin-right:10px;background-color:#D8D8D8;white-space:nowrap;"><a href="'.$results[0]->link.'" target="_blank"><img width="40px" style="margin-top:15px;" src="'.JURI::Root().$results[0]->image.'"  alt="'.$results[0]->name.'" title="'.$results[0]->name.'  ('.$results[0]->detail2.')" /></a>&nbsp;&nbsp;<a href="'.$results[0]->link.'" target="_blank">&nbsp;&nbsp;'.$results[0]->name.'</a></span>';
					else:
					$vehicles_list[] = ''.$results[0]->name.'';
					$vehicles_images[] = '<span style="margin-right:10px;background-color:#D8D8D8;white-space:nowrap;"><img width="40px" style="margin-top:15px;" src="'.JURI::Root().$results[0]->image.'"  alt="'.$results[0]->name.'" title="'.$results[0]->name.'  ('.$results[0]->detail2.')" />&nbsp;&nbsp;'.$results[0]->name.'</span>';
					endif;
					endif;

					endforeach;
				$this->item->vehicles = implode(', ',$data); 
				$vehicles_images = implode(' ',$vehicles_images); 
				$vehicles_list = implode(', ',$vehicles_list); ?>
            <?php endif;?>
            
            <?php if( $this->item->vehicles ) : ?>
			<?php if ($this->params->get('display_detail_fhz_images','1') and $this->item->vehicles) :?>
			<?php echo '<strong>Fahrzeuge:</strong> '.$vehicles_images.'</br>';?> 
            <?php else:?>
			<strong>Fahrzeuge:</strong> <?php echo $vehicles_list;?><br>
            <?php endif;?>
            <?php endif;?>
			
			
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
					$db = JFactory::getDbo();
					$query	= $db->getQuery(true);
					$query
						->select('*')
						->from('#__eiko_organisationen')
						->where('id = "' .$value.'"');
					$db->setQuery($query);
					$results = $db->loadObjectList();
					
					if ($this->params->get('display_detail_orga_links','1')) :
					if (!$results[0]->link) :
					$data[] = '<a href="'.JRoute::_('index.php?option=com_einsatzkomponente&view=organisation&Itemid='.$this->params->get('orgalink','').'&id=' . $results[0]->id).'" target="_self" alt="'.$results[0]->link.'">'.$results[0]->name.'</a>';
					else:					
					$data[] = '<a href="'.$results[0]->link.'" target="_blank" alt="'.$results[0]->link.'">'.$results[0]->name.'</a>';
					endif;
					else:
					if ($results[0]->link) :
					$data[] = '<a href="'.$results[0]->link.'" target="_blank" alt="'.$results[0]->link.'">'.$results[0]->name.'</a>';
					else:
					$data[] = ''.$results[0]->name.'';
					endif;
					endif;

										
				endforeach;
				$this->item->auswahl_orga = implode(', ',$data); ?>
			<strong>Eingesetzte Kräfte:</strong> <?php echo $this->item->auswahl_orga;?><br>
            <?php endif;?>

			
			</p>
			<hr>
			<?php if( $this->item->desc) : ?>
			<h3  class="einsatzbericht-title">Einsatzbericht:</h3>
		    <?php endif;?>
		  <p>
		  
<?php if( $this->item->image ) : ?>
<?php $this->item->image = preg_replace("%thumbs/%", "", $this->item->image,1); ?>

				<a href="<?php echo JURI::Root().$this->item->image;?>" rel="highslide[<?php echo $this->item->id; ?>]" class="highslide" onClick="return hs.expand(this, { captionText: '<?php echo $this->einsatzlogo->title;?> am <?php echo date("d.m.Y - H:i", strtotime($this->item->date1)).' Uhr'; ?>' });" alt ="<?php echo $this->einsatzlogo->title;?>">
                  <img class="eiko_img-rounded_2 eiko_detail_image_3 alignleft_detail_3" src="<?php echo JURI::Root().$this->item->image;?>"  alt="<?php echo $this->einsatzlogo->title;?>" title="<?php echo $this->einsatzlogo->title;?>" alt ="<?php echo $this->einsatzlogo->title;?>"/>
                  </a>
			
		  <br />
		  <?php endif;?>
		  
			<?php if( $this->item->desc) : ?>
			<?php if ($this->params->get('display_detail_desc','1')): ?>
            <?php jimport('joomla.html.content'); ?>  
            <?php $Desc = JHTML::_('content.prepare', $this->item->desc); ?>
        	<p style="text-align: justify;" class="detail_layout_3_p"><?php echo $Desc; ?></p>
			<?php endif;?>
			<?php endif;?>

		<?php
			$plugin = JPluginHelper::getPlugin('content', 'myshariff') ;
			if ($plugin) : 	echo JHTML::_('content.prepare', '{myshariff}');endif;
			?>

			
          <nav style="float:<?php echo $this->params->get('navi_detail_pos','left');?>;" class="">
			<?php echo $this->navbar;?>
                      </nav>
        </div>

        
        <div class="clear"></div>
      </div>

    </div>



  
    
    

   <div class="clearfix"></div>
  <div class="distance100">&nbsp;</div>
   <h2>Sonstige Informationen</h2>
			<?php if ($this->images) : ?>
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

            <!--Einsatzkarte-->
			<?php $user	= JFactory::getUser();?>
            <?php if( $this->item->gmap) : ?> 
            <?php if( $this->item->gmap_report_latitude != '0' ) : ?> 
            <?php if( $this->params->get('display_detail_map_for_only_user','0') == '1' || $user->id ) :?> 
			<?php if ($this->params->get('gmap_action','0')=='1') : ?>
  			<div class="distance100">&nbsp;</div>
   			<h3>Einsatzort</h3> 
  			<div id="map-canvas"  style="width:100%; height:<?php echo $this->params->get('detail_map_height','250px');?>;">
    		<noscript>Dieser Teil der Seite erfordert die JavaScript Unterstützung Ihres Browsers!</noscript>
			</div>
            <?php endif;?>
			<?php if ($this->params->get('gmap_action','0')=='2') : ?>
  			<div class="distance100">&nbsp;</div>
  			<h3>Einsatzort</h3> 
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
            
<div class="distance100">&nbsp;</div> 

<?php if( $this->item->presse or $this->item->presse2 or $this->item->presse3) : ?>
 <h3>Quelle oder weitere Infos</h3>
           <table>
           <tr>
           <td style="vertical-align: top;">
           </td>
           <td style="vertical-align: top;">
            <?php if( $this->item->presse) : ?>
			<?php echo '<a href="'.$this->item->presse.'" target="_blank"><i class="icon-share-alt" style="margin-right:5px;"></i><small>'.$this->item->presse_label.'</small></a><br/>'; ?>
            <?php endif;?>
            <?php if( $this->item->presse2 ) : ?>
			<?php echo '<a href="'.$this->item->presse2.'" target="_blank"><i class="icon-share-alt" style="margin-right:5px;"></i><small>'.$this->item->presse2_label.'</small></a><br/>'; ?>
            <?php endif;?>
            <?php if( $this->item->presse3 ) : ?>
			<?php echo '<a href="'.$this->item->presse3.'" target="_blank"><i class="icon-share-alt" style="margin-right:5px;"></i><small>'.$this->item->presse3_label.'</small></a><br/>'; ?>
            <?php endif;?>
            </td>
            </tr>
            </table>
            <?php endif;?>
    
<?php if ($this->params->get('display_detail_footer','1')) : ?>
<div class="distance100">&nbsp;</div>
<div class="detail_footer"><i class="icon-info-sign" style="margin-right:5px;"></i><?php echo $this->params->get('display_detail_footer_text','Kein Detail-Footer-Text vorhanden');?> </div>
<?php endif;?>

    
    
    
    
    

<?php else: ?>
    Could not load the item
<?php endif; ?>
