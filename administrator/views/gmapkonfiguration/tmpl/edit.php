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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

JHtml::_('formbehavior.chosen', 'select');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_einsatzkomponente/assets/css/einsatzkomponente.css');
?>
<script type="text/javascript">
    
    
	Joomla.submitbutton = function(task)
	{
        
		if (task == 'gmapkonfiguration.cancel' || document.formvalidator.isValid(document.id('gmapkonfiguration-form'))) {
			Joomla.submitform(task, document.getElementById('gmapkonfiguration-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>




<form action="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&layout=edit&id='.(int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="gmapkonfiguration-form" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
            <fieldset class="adminform">

			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('gmap_zoom_level'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('gmap_zoom_level'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('gmap_onload'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('gmap_onload'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('gmap_alarmarea'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('gmap_alarmarea'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('start_lat'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('start_lat'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('start_lang'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('start_lang'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>

				
            </fieldset>
    	</div>
        
        <div class="clr"></div>
        
        
 
			<fieldset class="panelform">
    		<div class="alert alert-info" style="width: 500px;">
    		<ul>
    			<li><?php echo JText::_('COM_EINSATZKOMPONENTE_GMAP_1');?></li>
    			<li><?php echo JText::_('COM_EINSATZKOMPONENTE_GMAP_2');?></li>
    		</ul>
   			</div>
			<?php if ($this->params->get('gmap_action','0') == '1') : ?> 
            <input class='btn btn-warning' type='button' onclick='clearMap();return false;' value='<?php echo JText::_('COM_EINSATZKOMPONENTE_GMAP_KOORDINATEN_LOESCHEN');?>'/>
            <input class='btn btn-warning' type='button' onclick='resetarea()' value='<?php echo JText::_('COM_EINSATZKOMPONENTE_GMAP_KOORDINATENLISTE_ZUUECKSETZEN');?>'/>
			<?php endif;?>
						<!-- Button to trigger modal -->
						<a href="#myModal" role="button" class="btn" data-toggle="modal"><?php echo JText::_('COM_EINSATZKOMPONENTE_GMAP_4');?></a>
     
						<!-- Modal -->
						<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel"><?php echo JText::_('COM_EINSATZKOMPONENTE_GMAP_5');?></h3>
						</div>
						<div class="modal-body"><br/><br/>
    1. Sucht im Internet nach dem amtlichen Gemeindeschlüssel<br/>
    2. Ruft die Seite overpass-turbo.eu	auf<br/>
    3. Drück den Button „Wizard“<br/>
    4. Gebt in das freie Feld folgendes ein: „de:amtlicher_gemeindeschluessel="XXXXXX"“. Die äußersten Anführungszeichen nicht mit kopieren und für die XX den Gemeindeschlüssel einfügen.<br/>
    5. Anschließend auf „Abfrage erstellen und ausführen“ klicken<br/>
    6. Nun wird auf der Karte die Gemeinde farblich angezeigt.<br/>
    7. Drück den Button Export.<br/>
    8. Wähle GPX aus.<br/>
    9. Datei auf dem Desktop speichern.<br/>
    10.Datei mit einem Editor öffnen, zu empfehlen ist Webocton Scriptly.<br/>
    11.Alle Zeilen löschen, außer der mit den Koordinaten.<br/>
    12.Über die Funktion Suchen und Ersetzen, die Zwischenräume von lon=>lat mit einem „ , “ ersetzen. Anschließend die Zwischenräume von lat=>lon mit einem „ | “ ersetzen.<br/>
    13.Danach sollte eure Zeile so aussehen XX.YYYY,XX.YYYY|XX.YYYY,XX.YYYY|.....<br/>
    14.Diese Zeile in die Einsatzkompo einfügen und fertig.<br/>
	<h5>Vielen Dank an Martin Scholtes für diesen Hinweis.</h5>
						</div>
						<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_EINSATZKOMPONENTE_GMAP_6');?></button>
						<!--<button class="btn btn-primary">Save changes</button> !-->
						</div>
						</div>		
				</div>
			<?php if ($this->params->get('gmap_action','0') == '1') : ?> 
            <div id="map" style="width: 810px; height: 400px"><?php echo JText::_('COM_EINSATZKOMPONENTE_GMAP_7');?></div>
			<?php endif;?>

			<?php if ($this->params->get('gmap_action','0') == '2') : ?> 
            <div id="map_canvas" style="width: 810px; height: 400px"><?php echo JText::_('COM_EINSATZKOMPONENTE_GMAP_7');?></div>
			<?php OsmHelper::installOsmMap();?>
			<?php OsmHelper::callOsmMap($this->gmap_config->gmap_zoom_level,$this->gmap_config->start_lat,$this->gmap_config->start_lang); ?>
			<?php OsmHelper::addRightClickOsmMap(); ?> 
			<?php OsmHelper::editPolygonMap($this->einsatzgebiet,'blue'); ?> 
			<?php endif;?>

			
            <input type="hidden"  name="gmap_latitude"  id="gmap_latitude"  value="<?php echo $gmap_latitude; ?>" size="30"/>
            <input type="hidden"  name="gmap_longitude"  id="gmap_longitude"  value="<?php echo $gmap_longitude; ?>" size="30"/>
          
			</fieldset>
			</div>
 
 


			<!--Slider für ACL Configuration-->
<?php if (JFactory::getUser()->authorise('core.admin','einsatzkomponente')): ?>
	<div class="fltlft" style="width:80%;">
		<?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('startOffset'=>-1)); ?>
		<?php echo JHtml::_('sliders.panel', JText::_('ACL Configuration'), 'access-rules'); ?>
		<fieldset class="panelform">
			<?php echo $this->form->getLabel('rules'); ?>
			<?php echo $this->form->getInput('rules'); ?>
		</fieldset>
		<?php echo JHtml::_('sliders.end'); ?>
	</div>
<?php endif; ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
        
    </div>
</form>

<script type="text/javascript"> 

</script>



























<!-- ############ GoogleMaps  #############  -->

<?php if ($this->params->get('gmap_action','0') == '1') { ?> 

<?php // Einsatzgebiet für GMap-Karte vorbereiten
$area = substr($this->item->gmap_alarmarea, -1); 
if ($area =="|")
{
$gmap_alarmarea = substr($this->item->gmap_alarmarea, 0, -1); 
$area  = $gmap_alarmarea;
$area = explode("|", $gmap_alarmarea);
$area[] = $area[0];
$gmap_alarmarea = implode("|", $area);
}

$alarmareas1  = $gmap_alarmarea; // Einsatzgebiet  ---->
$alarmareas = explode('|', $alarmareas1);
$stralarmarea='[ ';
	$n=0;
	for($i = 0; $i < count($alarmareas); $i++)
	{
		if($i==$n-1)
		{
			$stralarmarea=$stralarmarea.'new google.maps.LatLng('.$alarmareas[$i].')';
		}
		else
		{
			$stralarmarea=$stralarmarea.'new google.maps.LatLng('.$alarmareas[$i].'),';
		}
	}
$stralarmarea=substr($stralarmarea,0,strlen($stralarmarea)-1);
$stralarmarea=$stralarmarea.' ];';

?>


 <!--Javascript für Gmap-Karte-->

<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=<?php echo $this->params->get ('gmapkey','') ;?>"></script> 

<script type="text/javascript"> 
//<![CDATA[
 
// Global variables
var map, poly;
var count = 0;
var points = new google.maps.MVCArray();
var markers = [];
var gebiet = new String("");
 
 
/**
* Tooltip based on Label overlay by Marc Ridey
* http://blog.mridey.com/2009/09/label-overlay-example-for-google-maps.html
*/
 
function Tooltip(opt_options) {
 // Initialization
 this.setValues(opt_options);
 var div = this.div_ = document.createElement("div");
 // Absolutely necessary for positioning the tooltips
 div.style.cssText = "position:absolute;"
 div.className= "tooltip";
};
 
Tooltip.prototype = new google.maps.OverlayView();
 
Tooltip.prototype.onAdd = function() {
 var pane = this.getPanes().floatPane;
 pane.appendChild(this.div_);
 this.div_.style.display = "block";
 // Ensures the right position of the tooltip when the marker is being dragged
 this.listener_ = google.maps.event.addListener(this, "position_changed", this.draw);
};
 
Tooltip.prototype.onRemove = function() {
 var parent = this.div_.parentNode;
 if (parent) parent.removeChild(this.div_);
 // Remove listener to stop updating the tooltip's position
 google.maps.event.removeListener(this.listener_);
};
 
Tooltip.prototype.draw = function() {
 var proj = this.getProjection();
 var pos = proj.fromLatLngToDivPixel(this.get("position"));
 var div = this.div_;
 div.style.display = "none";
 div.style.left = pos.x + 12 + "px";
 div.style.top = pos.y - 32 + "px";
 div.innerHTML = this.get("text").toString();
};
 
 
function createMarker(point, name) {
 
  var g = google.maps;
  var icon_url ="http://labs.google.com/ridefinder/images/";
  var image = new g.MarkerImage(icon_url + "mm_20_blue.png",
   new g.Size(12, 20),
   new g.Point(0, 0),
   new g.Point(6, 20));
 
  var shadow = new g.MarkerImage(icon_url + "mm_20_shadow.png",
    new g.Size(22, 20),
    new g.Point(0, 0),
    new g.Point(6, 20));
 
  var marker = new g.Marker({
    position: point, map: map,
    icon: image, shadow: shadow,
    draggable:true, tooltip: name
  });
 
  var tooltip = new Tooltip({ map: map });
  tooltip.bindTo("position", marker, "position");
  tooltip.bindTo("text", marker, "tooltip");
 
  g.event.addListener(marker, "mouseover", function() {
   tooltip.onAdd();
  });
 
  g.event.addListener(marker, "mouseout", function() {
   tooltip.onRemove();
  });
 
  marker.content = count;
  markers.push(marker);
 
  // Drag listener
  g.event.addListener(marker, "drag", function() {
   for (var m = 0; m < markers.length; m++) {
    if(markers[m] == marker) {
     var newpos = marker.getPosition();
     break;
    }
   }
   // Update MVCArray
   points.setAt(m, newpos);
    var gebiet = ''; 
        for (var m = 0; m < markers.length; m++) {
           latLng = markers[m].getPosition();
            var gebiet = gebiet + latLng.lat() + ',' + latLng.lng() + '|';
            document.getElementById("gmap_latitude").value=latLng.lat();
            document.getElementById("gmap_longitude").value=latLng.lng();
	    }
document.getElementById('jform_gmap_alarmarea').innerHTML = gebiet;
//   showValues();
  });
// Click listener to remove a marker
  g.event.addListener(marker, "click", function() {
   // Remove tooltip
   tooltip.onRemove();
   // Find out removed marker
   for (var n = 0; n < markers.length; n++) {
    if(markers[n] == marker) {
     marker.setMap(null);
     break;
    }
   }
   // Remove removed point from MVCArray
   points.removeAt(n);
   
 
   // Shorten array of markers and adjust counter
   markers.splice(n, 1);
    var gebiet = ''; 
        for (var m = 0; m < markers.length; m++) {
           latLng = markers[m].getPosition();
            var gebiet = gebiet + latLng.lat() + ',' + latLng.lng() + '|';
            document.getElementById("gmap_latitude").value=latLng.lat();
            document.getElementById("gmap_longitude").value=latLng.lng();
	    }
document.getElementById('jform_gmap_alarmarea').innerHTML = gebiet;
   if(markers.length == 0) {
    count = 0;
   }
   else {
    count = markers[markers.length-1].content;
   }
 });
  
  
    var gebiet = ''; 
        for (var m = 0; m < markers.length; m++) {
           latLng = markers[m].getPosition();
            var gebiet = gebiet + latLng.lat() + ',' + latLng.lng() + '|';
            document.getElementById("gmap_latitude").value=latLng.lat();
            document.getElementById("gmap_longitude").value=latLng.lng();
	    }
document.getElementById('jform_gmap_alarmarea').innerHTML = gebiet;
  
 return marker;
}
 
 
function buildMap() {
 
  var g = google.maps;
  var opts_map = {
   center: new g.LatLng(<?php echo $this->item->start_lat; ?>,<?php echo $this->item->start_lang; ?>), 
   zoom: <?php echo $this->item->gmap_zoom_level; ?>,
   mapTypeId: g.MapTypeId.<?php echo $this->item->gmap_onload; ?>,
   streetViewControl: false,
   draggableCursor:'auto', draggingCursor:'move',
   scrollwheel: false,
   scaleControl: true,
   disableDoubleClickZoom: true,
   streetViewControl: false,
   keyboardShortcuts: false,
   mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
   navigationControl: true,
   navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL}
  };
  map = new g.Map(document.getElementById("map"), opts_map);
 
  // Add listener for the click event
  g.event.addListener(map, "click", leftClick);
  g.event.addListener(map, "rightclick", rightClick);
g.event.trigger(map, 'resize');
  drawOverlay();
}
 
 
function leftClick(event) {
 
 if (event.latLng) {
  count++;
  var tooltip = "Point "+ count;
 
  // Add a marker at the clicked point
  var marker = createMarker(event.latLng, tooltip);
  points.push(event.latLng);
 
  if (poly) poly.setMap(null);
  drawOverlay();
 }
}

function rightClick(event) {
         if (cmarker) {
            cmarker.setMap(null);
            cmarker = null;
         }
 var cmarker = new google.maps.Marker({
    position: event.latLng,
	map: map,
    draggable:true, 
	title:"Center of Map"
  });		 
map.panTo(event.latLng);
            document.getElementById("jform_start_lat").value=event.latLng.lat();
            document.getElementById("jform_start_lang").value=event.latLng.lng();
}
function toggleMode() {
 
 if (poly) {
   poly.setMap(null);
   drawOverlay();
 }
}
 
 
function drawOverlay() {
 // Check radio button
	var alarmarea = <?php echo $stralarmarea;?>;
  // Create a polyline connected alarmarea.
var polyline2 = new google.maps.Polyline({
    strokeColor: '#ff0000',
	path: alarmarea,
    strokeWeight: 3
  });
polyline2.setMap(map);
   // Polyline mode
   poly = new google.maps.Polyline({ strokeColor: "#0000af",
    strokeOpacity: .8, strokeWeight: 2 });
 //  if(markers.length > 1) showValues();
   // Polygon mode
   poly = new google.maps.Polygon({ strokeColor: "#0000af",
    strokeOpacity: .8, strokeWeight: 2, fillColor: "#335599",
    fillOpacity: .2 });
 //  if(markers.length > 2) showValues();
 poly.setOptions({ map: map, path: points });
}
 
 
 
 
function clearMap() {
 
 // Clear current map and reset globals
 for (var i = 0; i < markers.length; i++) {
   markers[i].setMap(null);
 }
 if (poly) {
  poly.setMap(null);
  poly = null;
 }
 
 // Clear MVCArray - two possibilities
 // while(points.getLength() > 0) points.pop();
 for (var i = points.getLength(); i > 0; points.removeAt(--i)) {}; 
 
 
 markers.length = 0;
 count = 0;
 document.getElementById('jform_gmap_alarmarea').innerHTML = '';
}
function resetarea() {
 
 // Clear current map and reset globals
 for (var i = 0; i < markers.length; i++) {
   markers[i].setMap(null);
 }
 if (poly) {
  poly.setMap(null);
  poly = null;
 }
 
 // Clear MVCArray - two possibilities
 // while(points.getLength() > 0) points.pop();
 for (var i = points.getLength(); i > 0; points.removeAt(--i)) {}; 
 
 
 markers.length = 0;
 count = 0;
 document.getElementById('jform_gmap_alarmarea').innerHTML = '<?php echo $this->item->gmap_alarmarea;?>';
 
  poly.setMap(null);
 
 
}
//]]>
// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', buildMap);
</script>

<?php } ?>

