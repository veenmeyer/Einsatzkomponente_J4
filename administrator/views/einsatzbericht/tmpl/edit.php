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
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

$params = ComponentHelper::getParams('com_einsatzkomponente');

HTMLHelper::addIncludePath(JPATH_COMPONENT.'/helpers/html');

HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('formbehavior.chosen', 'select');

HTMLHelper::_('stylesheet','administrator/components/com_einsatzkomponente/assets/css/einsatzkomponente.css');

// Daten aus der Bilder-Galerie holen 
if (!$this->item->id == 0)
	{
	$db = Factory::getDBO();
	$query = 'SELECT id, thumb, comment FROM #__eiko_images WHERE report_id="'.$this->item->id.'" AND state="1" ORDER BY ordering ASC';
	$db->setQuery($query);
	$rImages = $db->loadObjectList();
	}
 
?>
<?php $gmap_latitude = $this->item->gmap_report_latitude; ?>
<?php $gmap_longitude = $this->item->gmap_report_longitude; ?>
<?php if ($gmap_latitude < '1') $gmap_latitude = $this->gmap_config->start_lat; ?>
<?php if ($gmap_longitude < '1') $gmap_longitude = $this->gmap_config->start_lang; ?>



<form action="<?php echo Route::_('index.php?option=com_einsatzkomponente&layout=edit&id='.(int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="einsatzbericht-form" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
            <fieldset class="adminform">
		<div class="fltlft well" style="width:80%;">
    		<br/><h1>Bitte geben Sie die Einsatzdaten an :</h1>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
            <?php if (Factory::getUser()->authorise('core.admin','einsatzkomponente')): ?>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('counter'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('counter'); ?></div>
			</div>
            <?php endif;?>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('alerting'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('alerting'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('data1'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('data1'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('tickerkat'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('tickerkat'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('address'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('address'); ?></div>
            </div> 
			
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('date1'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('date1'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('date2'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('date2'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('date3'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('date3'); ?></div>
			</div>
     </div>
    		<div class="fltlft well" style="width:80%;">
    		<br/><h1>Einsatzkräfte :</h1>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('boss'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('boss'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('boss2'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('boss2'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('people'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('people'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('auswahl_orga'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('auswahl_orga'); ?></div>
			</div>
			<?php
				foreach((array)$this->item->auswahl_orga as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="auswahl_orga" name="jform[auswahl_orgahidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>
			<script type="text/javascript">
				jQuery.noConflict();
				jQuery('input:hidden.auswahl_orga').each(function(){
					var name = jQuery(this).attr('name');
					if(name.indexOf('auswahl_orgahidden')){
						jQuery('#jform_auswahl_orga option[value="'+jQuery(this).val()+'"]').attr('selected',true);
					}
				});
			</script>			
            	
            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('vehicles'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('vehicles'); ?></div>
			</div>
			<?php
				foreach((array)$this->item->vehicles as $value): 
					if(!is_array($value)):
				echo '<input type="hidden" class="vehicles" name="jform[vehicleshidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
	?>
<script>
function displayVals() {
var multipleValues = jQuery( "#jform_vehicles" ).val() || [];
jQuery( "#fahrzeug" ).val(multipleValues.join( ", " ) );
}
jQuery( "select" ).change( displayVals ); 
displayVals();
</script>

<?php
//echo '<input type="text" id="fahrzeug">  />';			
				
			?>
			<script type="text/javascript">
				jQuery.noConflict();
				jQuery('input:hidden.vehicles').each(function(){
					var name = jQuery(this).attr('name');
					if(name.indexOf('vehicleshidden')){
						jQuery('#jform_vehicles option[value="'+jQuery(this).val()+'"]').attr('selected',true);
					}
				});
				</script>	
   
			<div class="control-group hide_ausruestung">
				<div class="control-label line"><?php echo $this->form->getLabel('ausruestung'); ?></div>
				<div class="controls hideme"><?php echo $this->form->getInput('ausruestung'); ?></div>
				<?php if (!$params->get('eiko','0')) : ?>
				<style>
				.hideme {display:none;}
				.line {text-decoration: line-through;}
				</style>
				<?php endif;?>
			</div>
				<?php if (!$params->get('display_detail_ausruestung','1')) : ?>
				<style>
				.hide_ausruestung {display:none;}
				</style>
				<?php endif;?>
			
			<?php
				foreach((array)$this->item->ausruestung as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="ausruestung" name="jform[ausruestunghidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>
			<script type="text/javascript">
				jQuery.noConflict();
				jQuery('input:hidden.ausruestung').each(function(){
					var name = jQuery(this).attr('name');
					if(name.indexOf('ausruestunghidden')){
						jQuery('#jform_ausruestung option[value="'+jQuery(this).val()+'"]').attr('selected',true);
					}
				});
			</script>			
   
                
           </div>		
           
<?php 

//			$array = array();
//			foreach((array)$this->item->vehicles as $value): 
//				if(!is_array($value)):
//					$array[] = $value;
//				endif;
//			endforeach;
//			$vehicles = implode(',',$array);

//echo '<input id="fahrzeug"/>';


?>
	
<!--			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('department'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('department'); ?></div>
			</div>
-->			
    		<div class="fltlft well" style="width:80%;">
    		<br/><h1>Einsatzbericht :</h1>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('summary'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('summary'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('desc'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('desc'); ?></div>
			</div>
          	</div>  
			
<script>
		jQuery.noConflict();
        jQuery(function(){
            jQuery('#add-file-field').click(function(){

            jQuery("#text").append('<div class="added-field"><input name="data[]" type="file"/><input type="button" class="remove-btn" value="entfernen"></div>');
            });
            jQuery('.remove-btn').on('click',function(){
            jQuery(this).parent().remove(); 
            });
			
});
</script>

    		<div class="fltlft well" style="width:80%;">
    		<br/><h1>Einsatzbilder :</h1>
			
			
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('image'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('image'); ?></div>
			</div>
			<hr>
			<div class="control-group" style="">
			Bilderupload für Bildergalerie:
			<div id="text">
            <div ><input multiple class="" name="data[]" id="file" type="file"/></div>
            <!-- This is where the new file field will appear -->
			</div>

		    <br/><input class="btn btn-default btn-xs dropdown-toggle" type="button" id="add-file-field" name="add" value="weiteres Bild einzelnd hinzufügen" />
        <!-- Here u can add image for add button(Like Below) just call the id="add-file-field" into ur image tag thats it..-->
        <!--<img src="images/add_icon.png"  id="add-file-field" name="add" style="margin-top:21px;"/>-->
		<!--http://www.fyneworks.com/jquery/multifile/-->
     
			</div>
			
			<hr>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('watermark_image'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('watermark_image'); ?></div>
			</div>
			
	</div>
			
            <!--Slider für Bildergalerie-->
            
<?php if (!$this->item->id == 0 && count($rImages)>'0' )	{ ?>
	<div class="fltlft well" style="width:80%;">
    <br/><h1>Einsatzbilder :</h1>
        <table>
        
			<?php 
			$n = false;
			for ($i = 0;$i < count($rImages);++$i) {
			if (@$rImages[$i]->comment) : $n = true; endif;
			}
			for ($i = 0;$i < count($rImages);++$i) {
			$fileName = '../'.$rImages[$i]->thumb;
			?>   
  			<ul class="thumbnails inline">
            <li class="span2">  
            <div class="thumbnail">
            <a href="index.php?option=com_einsatzkomponente&task=einsatzbilderbearbeiten.edit&id=<?php echo $rImages[$i]->id;?>" target="_self" class="thumbnail" title ="<?php echo $rImages[$i]->comment;?>">
			<img data-src="holder.js/300x200" src="<?php echo $fileName;?>"  alt="" title="<?php echo $fileName;?>"/>
            </a>
            <h5 class="label label-info">Bild ID.Nr. <?php echo $rImages[$i]->id;?></h5>
			<?php if ($rImages[$i]->comment) : ?>
			<br/><span title = "<?php echo $rImages[$i]->comment;?>" style="color:#ff0000;"><small>Bild-Info</small></span>
			 <?php else: ?>
			<?php if ($n == true) : echo '<br/><small>keine Bild-Info</small>';endif;?>
			 <?php endif; ?>
            </div>
            </li>
			<?php 	} ?>
            </ul>
       </table>
	</div>
<?php }?>
			
    		<div class="fltlft well" style="width:80%;">
    		<br/><h1>Quelle oder weiterführende Informationen :</h1>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getInput('presse_label'); ?>
									  <?php echo $this->form->getInput('presse'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getInput('presse2_label'); ?>
				                      <?php echo $this->form->getInput('presse2'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getInput('presse3_label'); ?>
				                      <?php echo $this->form->getInput('presse3'); ?></div>
			</div>
    		</div>
    
				<input type="hidden" name="jform[updatedate]" value="<?php echo $this->item->updatedate; ?>" />
				<input type="hidden" name="jform[createdate]" value="<?php echo $this->item->createdate; ?>" />
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('einsatzticker'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('einsatzticker'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('notrufticker'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('notrufticker'); ?></div>
			</div>
				
        
        		

            <!--Slider für GMap-Ortsangabe-->
            <?php if ($params->get('gmap_action','0') == '1' or $params->get('gmap_action','0') == '2') : ?>
			<div class="fltlft well" style="width:80%;">
            <h1>Bitte markieren Sie den Einsatzort auf der Karte :</h1>
            <div class="control-group" id="map_canvas" style="width:100%;max-width:600px;height:400px;border:1px solid;">Karte</div>
			<?php if ($params->get('gmap_action','0') == '2') : ?>
			<?php OsmHelper::installOsmMap();?>
			<?php OsmHelper::callOsmMap($this->gmap_config->gmap_zoom_level,$gmap_latitude,$gmap_longitude); ?>
			<?php OsmHelper::addMarkerOsmMap($gmap_latitude,$gmap_longitude); ?> 
			<?php endif;?>

			<div class="control-group">
            <div class="control-label">Koordinaten (Lat./Lon.):</div><div class="controls"><?php echo $this->form->getInput('gmap_report_latitude'); ?><?php echo $this->form->getInput('gmap_report_longitude'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('gmap'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('gmap'); ?></div>
			</div>
            
			</div>
 			<?php  endif; ?>
            
	
    		<div class="fltlft well" style="width:80%;">

<?php if ( $params->get('send_mail_auto', '0') ): ?>
			<hr>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('emailtext'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('emailtext'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('automail_off'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('automail_off'); ?></div>
			</div>
<?php endif; ?>


			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('article_id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('article_id'); ?></div>
			</div>
    
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('status_fb'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('status_fb'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('modified_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('modified_by'); ?></div>
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('department'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('department'); ?></div>
			</div>


			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('params'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('params'); ?></div>
			</div>
			
            		<fieldset class="panelform">

            <input type="hidden" name="jform[status]" value="<?php echo $this->item->status; ?>" />
			

            </fieldset>
			
			
    	</div>
		



		
   </div>     
        <input type="hidden" name="task" value="" />
			<input type='hidden' name="action" value="Filedata" />
        <?php echo HTMLHelper::_('form.token'); ?>
        
    </div>
	


</form>

<?php if ($params->get('gmap_action','0') == '1') : ?>

<!-- Javascript für GMap-Anzeige -->

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $params->get ('gmapkey','AIzaSyAuUYoAYc4DI2WBwSevXMGhIwF1ql6mV4E') ;?>&callback=initMap&v=weekly"
      async
    ></script>

<script type="text/javascript"> 
      var map = null;
      var marker = null;
      var marker2 = null;
	  var geocoder;

	  
function codeAddress2() {
    var address = document.getElementById("jform_address").value+"<?php echo ' '.$params->get('ort_geocode','');?>";
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        placeMarker(results[0].geometry.location);
		latLng = marker.getPosition();
            document.getElementById("jform_gmap_report_latitude").value=latLng.lat();
            document.getElementById("jform_gmap_report_longitude").value=latLng.lng();
            document.getElementById("jform_address").style.color = "green";
            document.getElementById("jform_address").style.border = "solid green 2px";
      } else {
            document.getElementById("jform_address").style.color = "red";
            document.getElementById("jform_address").style.border = "solid red 2px";
      }
    });
  }	 
  
 function placeMarker(location) {
     if (marker) {
      //  if marker already was created change positon
         marker.setPosition(location);
     } else {
    //    create a marker
         marker = new google.maps.Marker({
             position: location,
             map: map,
             draggable: true
         });
     }
 }
   
 
// A function to create the marker and set up the event window function 
 function createMarker(latlng, name, html) {
     var contentString = html;
     var marker = new google.maps.Marker({
         position: latlng,
         map: map,
         draggable: true,
         zIndex: Math.round(latlng.lat()*-100000)<<5
         });
   google.maps.event.addListener(marker, 'dragend', function() {
     latLng = marker.getPosition();
             document.getElementById("jform_gmap_report_latitude").value=latLng.lat();
             document.getElementById("jform_gmap_report_longitude").value=latLng.lng();
         });
      google.maps.event.addListener(marker, 'click', function() {
       latLng = marker.getPosition();
             document.getElementById("jform_gmap_report_latitude").value=latLng.lat();
             document.getElementById("jform_gmap_report_longitude").value=latLng.lng();
         });
     google.maps.event.trigger(marker, 'click');    
     return marker;
 }
 
 function updateInfoWindow () {
 }
 
 function initMap() {
 // create the map
   geocoder = new google.maps.Geocoder();
   var myOptions = {
    zoom: <?php echo $this->gmap_config->gmap_zoom_level; ?>,
    center: new google.maps.LatLng(<?php echo $gmap_latitude; ?>,<?php echo $gmap_longitude; ?>), 
    mapTypeControl: true,
      scrollwheel: false,
      disableDoubleClickZoom: true,
	  streetViewControl: false,
      keyboardShortcuts: false,
      mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
      navigationControl: true,
      navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
    mapTypeId: google.maps.MapTypeId.<?php echo $this->gmap_config->gmap_onload; ?>
  }
  map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
  
var marker2 = new google.maps.Marker({
        position: new google.maps.LatLng(<?php echo $gmap_latitude; ?>,<?php echo $gmap_longitude; ?>), 
        map: map,
        draggable: true,
        title:""
    });
    google.maps.event.addListener(map, 'click', function(event) {
	//call function to create marker
         if (marker) {
            marker.setMap(null);
            marker = null;
			marker2 = null;
         }
         if (marker2) {
			marker = null;
            marker2.setMap(null);
            marker2 = null;
         }
	  marker = createMarker(event.latLng, "name", "<b>Location</b><br>"+event.latLng);
	  map.panTo(latLng);
   });
 }
    
// Onload handler to fire off the app.
   window.initMap = initMap;
</script>
<!-- Javascript für GMap-Anzeige ENDE -->

<?php endif;?>