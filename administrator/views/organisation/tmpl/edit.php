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
$params = JComponentHelper::getParams('com_einsatzkomponente');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

JHtml::_('formbehavior.chosen', 'select');


// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_einsatzkomponente/assets/css/einsatzkomponente.css');


 

?>

<?php $gmap_latitude = $this->item->gmap_latitude; ?>
<?php $gmap_longitude = $this->item->gmap_longitude; ?>
<?php if ($gmap_latitude < '1') $gmap_latitude = $this->gmap_config->start_lat; ?>
<?php if ($gmap_longitude < '1') $gmap_longitude = $this->gmap_config->start_lang; ?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'organisation.cancel' || document.formvalidator.isValid(document.id('organisation-form'))) {
			Joomla.submitform(task, document.getElementById('organisation-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&layout=edit&id='.(int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="organisation-form" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
            <fieldset class="adminform">
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
            </div>   
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('gmap_icon_orga'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('gmap_icon_orga'); ?></div>
            </div>   
<?php // zugeordnete Fahrzeuge aufrufen ----------------------------------
if ($this->item->name)
{
?>
            <div class="control-group">  
            
<?php 
	echo '<div class="control-label">';echo JText::_('COM_EINSATZKOMPONENTE_ZUGORDNETE_FAHRZEUGE').':';echo '</div>';
	echo '<div class="controls"><ul class="adminformlist">';
$database			= JFactory::getDBO();
$query = 'SELECT * FROM #__eiko_fahrzeuge WHERE department = "'.$this->item->id.'" ORDER BY ordering,state ASC ' ;
$database->setQuery( $query );
$total = $database->loadObjectList();	
		if ($total) {
		foreach($total as $totale): 
		echo '<li>';
		echo '<a title="Fahrzeug bearbeiten" href="index.php?option=com_einsatzkomponente&task=einsatzfahrzeug.edit&id='.$totale->id.'); ">';
		echo $totale->name;
		if ($totale->detail2): echo ' ( '.$totale->detail2.' )'; endif;
		if ($totale->detail1): echo ' '.$totale->detail1; endif;
		echo '</a>';
                if ($totale->state == 2): echo JText::_('COM_EINSATZKOMPONENTE_FAHRZEUG_AUSSER_DIENST'); endif;
                if ($totale->state == 0): echo JText::_('COM_EINSATZKOMPONENTE_FAHRZEUG_DEAKTIVIERT'); endif;
                echo '</li>';
		endforeach; 
		}
		else
		{
		echo '<span class="label label-important">'.JText::_('COM_EINSATZKOMPONENTE_KEINE_FAHRZEUGE').'</span>';
		}
echo '</ul></div></div>';
}
else {}  // zugeordnete Fahrzeuge aufrufen   ENDE --------------------------
?>
			
            
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail1_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail1'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail2_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail2'); ?></div>
			</div>
            
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail3_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail3'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail4_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail4'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail5_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail5'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail6_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail6'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail7_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail7'); ?></div>
			</div>

			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('link'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('link'); ?></div>
			</div>
            
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('ffw'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('ffw'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('desc'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('desc'); ?></div>
			</div>
            
            
<!--			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>
-->            
            <?php if ($params->get('gmap_action','0') == '1' or $params->get('gmap_action','0') == '2') : ?>
	           <!--Slider für Ortsangaben-->
            <?php $gmap_config = $this->gmap_config;  // GMap-Config Daten laden?>
			<div class="fltlft" style="width:80%;">
            <div class="control-group" id="map_canvas" style="width:100%;max-width:600px;height:400px;border:1px solid;">Karte</div>
			<div class="control-group">
            <div class="controls"><input id="jform_address" class="input-large" placeholder="Adresse hier eingeben" type="text" value="">&nbsp;&nbsp;
            <input class="btn btn-danger" type="button" id="Geocode" value="Geocode" onclick="codeAddress()"></div>
			</div>		
			<div class="control-group">
			<div class="control-label"><?php echo 'Latitude / Longitude'; ?></div>
            <div class="controls"><?php echo $this->form->getInput('gmap_latitude'); ?><?php echo $this->form->getInput('gmap_longitude'); ?></div>
			</div>
            <?php endif;?>
			<?php if ($params->get('gmap_action','0') == '2') : ?>
			<?php OsmHelper::installOsmMap();?>
			<?php OsmHelper::callOsmMap($gmap_config->gmap_zoom_level,$gmap_latitude,$gmap_longitude); ?>
			<?php OsmHelper::addMarkerOsmMap($gmap_latitude,$gmap_longitude); ?> 
			<?php endif;?>
			
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>

			</div>
			</fieldset>
			</div>

<?php if ($params->get('gmap_action','0') == '1') : ?>

              <!-- Javascript für GMap-Anzeige -->
			  
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=<?php echo $params->get ('gmapkey','AIzaSyAuUYoAYc4DI2WBwSevXMGhIwF1ql6mV4E') ;?>"></script> 

              <script type="text/javascript"> 
                    var map = null;
                    var marker = null;
                    var marker2 = null;
                    var geocoder;
                    
              function codeAddress() {
                  var address = document.getElementById("jform_address").value;
                  geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                      map.setCenter(results[0].geometry.location);
                      var marker = new google.maps.Marker({
                          map: map, 
                          position: results[0].geometry.location
                      });
                      latLng = marker.getPosition();
                          document.getElementById("jform_gmap_report_latitude").value=latLng.lat();
                          document.getElementById("jform_gmap_report_longitude").value=latLng.lng();
                    } else {
                      alert("Geocode war nicht erfolgreich aus folgendem Grund: " + status);
                    }
                  });
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
               
              function initialize() {
                // create the map
                geocoder = new google.maps.Geocoder();
                var myOptions = {
                  zoom: <?php echo $gmap_config->gmap_zoom_level; ?>,
                  center: new google.maps.LatLng(<?php echo $gmap_latitude; ?>,<?php echo $gmap_longitude; ?>), 
                  mapTypeControl: true,
                    scrollwheel: false,
                    disableDoubleClickZoom: true,
                    streetViewControl: false,
                    keyboardShortcuts: false,
                    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
                    navigationControl: true,
                    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
                  mapTypeId: google.maps.MapTypeId.<?php echo $gmap_config->gmap_onload; ?>
                }
                map = new google.maps.Map(document.getElementById("map_canvas"),
                                              myOptions);
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
                          marker2.setMap(null);
                          marker2 = null;
                       }
                   marker = createMarker(event.latLng, "name", "<b>Location</b><br>"+event.latLng);
				   map.panTo(latLng);
                });
              }
                  
              // Onload handler to fire off the app.
              google.maps.event.addDomListener(window, 'load', initialize);
              </script>
              <!-- Javascript für GMap-Anzeige ENDE -->
  <?php  endif; ?>
				
        
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
        
    </div>
</form>
