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
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

/**
 * OSM helper.
 */
 
class OsmHelper
{
	

		
		public static function installOsmMap()
	{
			HTMLHelper::_('stylesheet','components/com_einsatzkomponente/assets/leaflet/leaflet.css');			
			HTMLHelper::_('script','components/com_einsatzkomponente/assets/leaflet/leaflet.js');
			HTMLHelper::_('script','components/com_einsatzkomponente/assets/leaflet/geocode.js');
			
			return;
	}


public static function callOsmMap($zoom='',$lat='53.26434271775887',$lon='7.5730027132448186')
	{
	$script ="			
		var myOsmDe = L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {attribution:  'Map data &copy; <a href=\"https://osm.org/copyright\"> OpenStreetMap</a> | Lizenz: <a href=\"http://opendatacommons.org/licenses/odbl/\"> Open Database License (ODbL)</a>'});
					
		var map = L.map('map_canvas', {
			doubleClickZoom: false,
			center: [".$lat.", ".$lon."],
			minZoom: 2,
			maxZoom: 18,
			zoom: ".$zoom.",
			layers: [myOsmDe],
			scrollWheelZoom: false
			});
		//var baseLayers = {
		//	'OSM deutscher Style': myOsmDe
		//	};
		//	L.control.layers(baseLayers).addTo(map);
		var osmGeocoder = new L.Control.OSMGeocoder();
	map.addControl(osmGeocoder);
			";
			
		Factory::getDocument()->addScriptDeclaration($script);
		
		return;
}



		public static function addMarkerOsmMap($lat='53.26434271775887',$lon='7.5730027132448186')
	{
	$script ="			
	function addMarker(e){	
		map.removeLayer(marker2);
 
		var marker = new L.marker(e.latlng,{draggable:'true',icon: blueIcon}).bindPopup().addTo(map);
	
		// Koordinaten im Feld aktualisieren
		var m = marker.getLatLng();
		document.getElementById('jform_gmap_report_latitude').value=m.lat.toFixed(15);
        document.getElementById('jform_gmap_report_longitude').value=m.lng.toFixed(15);
		
		marker.on('drag', function(e) {
			var marker = e.target;
			var m = marker.getLatLng();
			//map.panTo(new L.LatLng(m.lat, m.lng));
			document.getElementById('jform_gmap_report_latitude').value=m.lat.toFixed(15);
			document.getElementById('jform_gmap_report_longitude').value=m.lng.toFixed(15);
		});

		// Marker bei Doppelklick löschen
		marker.on('dblclick', ondblclick);	
	
		// Popup aktualisieren und öffnen wenn Marker angeklickt wird 
		marker.on('click', onclick);	
	
		// löscht den letzten Marker
		// Zeile entfernen wenn mehrere Marker angezeigt werden sollen
		map.on('click', ondblclick);

		function onclick() {
			var ZoomLevel = map.getZoom();
			var m = marker.getLatLng();
			document.getElementById('jform_gmap_report_latitude').value=m.lat.toFixed(15);
			document.getElementById('jform_gmap_report_longitude').value=m.lng.toFixed(15);
			
		}  
	
		function ondblclick() 
			{	
			map.removeLayer(marker);
			}
	};


map.on('click', addMarker);

//*********************************************************************
// Icons globales Aussehen und Größe festlegen

var LeafIcon = L.Icon.extend({
			options: {
			iconSize:    [44, 36],		
			iconAnchor:  [9, 21],
			popupAnchor: [0, -14]
			}
});

//*********************************************************************
// Icons zuweisen

var blueIcon   = new LeafIcon({iconUrl:'".Uri::base()."/components/com_einsatzkomponente/assets/leaflet/pin48blue.png'});
		
		
var marker2 = new L.marker([".$lat.','.$lon."],{draggable:'true',icon: blueIcon}).bindPopup().addTo(map);

marker2.on('drag', function(e) {
    var marker2 = e.target;
    var m = marker2.getLatLng();
    //map.panTo(new L.LatLng(m.lat, m.lng));
	document.getElementById('jform_gmap_report_latitude').value=m.lat.toFixed(15);
    document.getElementById('jform_gmap_report_longitude').value=m.lng.toFixed(15);
});

";
			Factory::getDocument()->addScriptDeclaration($script);

			return;
}



		public static function addEinsatzorteMap($json='')
	{
			$app	= Factory::getApplication();
			$params = $app->getParams('com_einsatzkomponente');

	$script ="			
	var geodaten =[];
	var current;
			icsize = '".$params->get('einsatzkarte_gmap_icon','18')."';	
			geodaten = ".$json.";
			
			var LeafIcon = L.Icon.extend({
						options: {
						iconSize:    [icsize, icsize],		
						iconAnchor:  [9, 21],
						popupAnchor: [0, -14]
						}
			});


			for (var i = 0; i < geodaten.length; i++) {
				
				var current = geodaten[i];
				var Icon   = new LeafIcon({iconUrl:'".Uri::base()."'+current.icon});
				var text = '<h2 class='eiko_h2_osm'>'+current.name+'</h2><a class='btn-home' href=".Route::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&id=' )."'+current.id+'>".Text::_('COM_EINSATZKOMPONENTE_DETAILS')."</a>'

				L.marker(new L.LatLng([current.lat], [current.lon]),{icon : Icon},{title : current.name}).addTo(map)
				.bindPopup(text);

				
			}


";
			Factory::getDocument()->addScriptDeclaration($script);
			
			return;
}

		public static function addEinsatzortMap($lat='53.26434271775887',$lon='7.5730027132448186',$name='Einsatz',$icon='',$id='1')
	{
			$app	= Factory::getApplication();
			$params = $app->getParams('com_einsatzkomponente');

	$script ="			

			lat = ".$lat.";
			lon = ".$lon.";
			name = '".$name."';
			icon = '".$icon."';
			icsize = '".$params->get('einsatzkarte_gmap_icon','18')."';
			id = '".$id."';
			popup = ".$params->get('display_detail_popup','false').";
			map.setView(new L.LatLng(lat,lon),".$params->get('detail_gmap_zoom_level','12').");
			
			//map.options.minZoom = ".$params->get('detail_gmap_zoom_level','12').";
			map.options.maxZoom = ".$params->get('detail_gmap_zoom_level','12').";
			
			
			var LeafIcon = L.Icon.extend({
						options: {
						iconSize:    [icsize,icsize],		
						iconAnchor:  [9, 21],
						popupAnchor: [0, -14]
						}
			});


				
				var Icon   = new LeafIcon({iconUrl:'".Uri::base()."'+icon});
				
				if (name && popup) {
				var text = '<h2 class='eiko_h2_osm'>'+name+'</h2>'
				L.marker(new L.LatLng([lat], [lon]),{icon : Icon},{title : name}).addTo(map)
				.bindPopup(text).openPopup();
				}
				else
				{
				L.marker(new L.LatLng([lat], [lon]),{icon : Icon},{title : name}).addTo(map);
				}
				


";
			Factory::getDocument()->addScriptDeclaration($script);

			return;
}

		public static function addOrganisationenMap($json='')
	{
			$app	= Factory::getApplication();
			$params = $app->getParams('com_einsatzkomponente');
		
	$script ="			
	var geodaten =[];
	var current;
	icsize = '".$params->get('einsatzkarte_gmap_icon_orga','18')."';
	geodaten = ".$json.";
			
			var LeafIcon = L.Icon.extend({
						options: {
						iconSize:    [icsize, icsize],		
						iconAnchor:  [9, 21],
						popupAnchor: [0, -14]
						}
			});


			for (var i = 0; i < geodaten.length; i++) {
				
				var current = geodaten[i];
				var Icon   = new LeafIcon({iconUrl:'".Uri::base()."'+current.icon});
				var text = '<h2 class='eiko_h2_osm'>'+current.name+'</h2>'
				L.marker(new L.LatLng([current.lat], [current.lon]),{icon : Icon},{title : current.name})
				.bindPopup(text)
				.addTo(map);
				
			}


";
			Factory::getDocument()->addScriptDeclaration($script);

			return;
}


		public static function addPolygonMap($latlngs='[[0,0]]',$color='red')
	{
	$script ="			
			var latlngs = ".$latlngs.";
			var polygon = L.polygon(latlngs, {color: '".$color."'}).addTo(map);
";
			Factory::getDocument()->addScriptDeclaration($script);

			return;
}

		public static function addRightClickOsmMap()
	{
	$script ="			
			
			map.on('contextmenu', function(e) {
				//alert(e.target);
				var marker = new L.marker(e.latlng,{draggable:'true'}).addTo(map);
				var m = marker.getLatLng();
				map.panTo(new L.LatLng(m.lat, m.lng));
				document.getElementById('jform_start_lat').value=m.lat.toFixed(15);
				document.getElementById('jform_start_lang').value=m.lng.toFixed(15);
			});
			map.on('zoomstart',function(e){
				  var currZoom = map.getZoom();
				  document.getElementById('jform_gmap_zoom_level').value=currZoom;
				  });		
			
";
			Factory::getDocument()->addScriptDeclaration($script);

			return;
}


		public static function editPolygonMap($latlngs='[[0,0]]',$color='red')
	{
			$document = Factory::getDocument();
			$document->addStyleSheet('https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css'); 
			$document->addScript('https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js');

	$script ="			
			
			var latlngs = ".$latlngs.";
			var polygon = L.polygon(latlngs, {color: '".$color."'}).addTo(map);
			
			// Initialise the FeatureGroup to store editable layers
var editableLayers = new L.FeatureGroup();
map.addLayer(editableLayers);


var drawPluginOptions = {
  position: 'topright',
  draw: {

    polygon: {
      allowIntersection: true, // Restricts shapes to simple polygons
      drawError: {
        color: '#e1e100', // Color the shape will turn when intersects
        message: '<strong>Oh snap!<strong> you can\'t draw that!' // Message that will show when intersect
      },
      shapeOptions: {
        color: '#97009c'
      }
    },
    // disable toolbar item by setting it to false
    polyline: false,
    circle: false, // Turns off this drawing tool
    rectangle: false,
    marker: false,
	circlemarker: false,
    },
  edit: {
    featureGroup: editableLayers, //REQUIRED!!
    remove: false,
	edit: false
  }
};

	 
// Initialise the draw control and pass it the FeatureGroup of editable layers
var drawControl = new L.Control.Draw(drawPluginOptions);
map.addControl(drawControl);

var editableLayers = new L.FeatureGroup();
map.addLayer(editableLayers);

map.on('draw:created', function(e) {
  var type = e.layerType,
    layer = e.layer;

  if (type === 'marker') {
    layer.bindPopup('A popup!');
  }

if (type === 'polygon') {
        // structure the geojson object
        var geojson = {};

        // export the coordinates from the layer
        coordinates = '';
        latlngs = layer.getLatLngs()[0];

        for (var i = 0; i < latlngs.length; i++) {
            coordinates= coordinates+latlngs[i].lat+','+latlngs[i].lng+'|';
        }

		document.getElementById('jform_gmap_alarmarea').innerHTML = coordinates;
		
    }

	
  editableLayers.addLayer(layer);
});

";
			Factory::getDocument()->addScriptDeclaration($script);

			return;
}



	
}