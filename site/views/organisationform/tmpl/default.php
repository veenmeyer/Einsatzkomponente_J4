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

$params = JComponentHelper::getParams('com_einsatzkomponente');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

$version = new JVersion;
if ($version->isCompatible('3.0')) :
JHtml::_('formbehavior.chosen', 'select');
endif;


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
	echo '<div class="control-label">';echo JText::_('Zugeordnete Fahrzeuge :');echo '</div>';
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
                if ($totale->state == 2): echo ' (Fahrzeug Au&szlig;er Dienst) '; endif;
                if ($totale->state == 0): echo ' (Fahrzeug deaktiviert!) '; endif;
                echo '</li>';
		endforeach; 
		}
		else
		{
		echo '<span class="label label-important">Es wurden keine Fahrzeuge zugeordnet !!</span>';
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
   <?php if ($params->get('gmap_action','0')) : ?>
	           <!--Slider für Ortsangaben-->
            <?php $gmap_config = $this->gmap_config;  // GMap-Config Daten laden?>
			<div class="fltlft" style="width:80%;">
            <div class="control-group" id="map_canvas" style="width:100%;max-width:600px;height:400px;border:1px solid;">Karte</div>
			<div class="control-group">
            <div class="controls"><input id="address" class="input-large" placeholder="Adresse hier eingeben" type="text" value="">&nbsp;&nbsp;
            <input class="btn btn-danger" type="button" value="Geocode" onclick="codeAddress()"></div>
			</div>		
			<div class="control-group">
            <div class="control-label">Koordinaten (Lat./Lon.):</div><div class="controls"><?php echo $this->form->getInput('gmap_latitude'); ?><?php echo $this->form->getInput('gmap_longitude'); ?></div>
			</div>
            
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>

			</div>
			</div>
			
              <!-- Javascript für GMap-Anzeige -->
			  
<?php if(isset($_SERVER['HTTPS'])) : $ssl='https://'; else:	$ssl='http://'; endif;?>
<script type="text/javascript" src="<?php echo $ssl;?>maps.google.com/maps/api/js?v=3"></script> 

              <script type="text/javascript"> 
                    var map = null;
                    var marker = null;
                    var marker2 = null;
                    var geocoder;
                    
              function codeAddress() {
                  var address = document.getElementById("address").value;
                  geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                      map.setCenter(results[0].geometry.location);
                      var marker = new google.maps.Marker({
                          map: map, 
                          position: results[0].geometry.location
                      });
                      latLng = marker.getPosition();
                          document.getElementById("jform_gmap_latitude").value=latLng.lat();
                          document.getElementById("jform_gmap_longitude").value=latLng.lng();
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
                          document.getElementById("jform_gmap_latitude").value=latLng.lat();
                          document.getElementById("jform_gmap_longitude").value=latLng.lng();
                      });
                   google.maps.event.addListener(marker, 'click', function() {
                    latLng = marker.getPosition();
                          document.getElementById("jform_gmap_latitude").value=latLng.lat();
                          document.getElementById("jform_gmap_longitude").value=latLng.lng();
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
                });
              }
                  
              // Onload handler to fire off the app.
              google.maps.event.addDomListener(window, 'load', initialize);
              </script>
              <!-- Javascript für GMap-Anzeige ENDE -->
  <?php  endif; ?>
				
        
        
		<div class="control-group">
			<div class="controls">

				<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary">
						<?php echo JText::_('JSUBMIT'); ?>
					</button>
				<?php endif; ?>
				<a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=organisationform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_einsatzkomponente"/>
		<input type="hidden" name="task"
			   value="organisationform.save"/>
		<?php echo JHtml::_('form.token'); ?>
		
    </div>			
	</fieldset>

</form>
