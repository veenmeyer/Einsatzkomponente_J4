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
use Joomla\CMS\HTML\HTMLHelper;


// Mootools laden
JHtml::_('behavior.framework', true);



print_r ($this->reports);

?>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=<?php echo $this->params->get ('gmapkey','AIzaSyAuUYoAYc4DI2WBwSevXMGhIwF1ql6mV4E') ;?>"></script> 

<style type="text/css">
html, body { height: 100%; } 
</style>
    <script type="text/javascript">
    //<![CDATA[
      // this variable will collect the html which will eventually be placed in the side_bar 
      var side_bar_html = ""; 

      var gmarkers = [];
      var gicons = [];
      var map = null;

var infowindow = new google.maps.InfoWindow(
  { 
    size: new google.maps.Size(150,50)
  });


gicons["red"] = new google.maps.MarkerImage("mapIcons/marker_red.png",
      // This marker is 20 pixels wide by 34 pixels tall.
      new google.maps.Size(20, 34),
      // The origin for this image is 0,0.
      new google.maps.Point(0,0),
      // The anchor for this image is at 9,34.
      new google.maps.Point(9, 34));
  // Marker sizes are expressed as a Size of X,Y
  // where the origin of the image (0,0) is located
  // in the top left of the image.
 
  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.

  var iconImage = new google.maps.MarkerImage('mapIcons/marker_red.png',
      // This marker is 20 pixels wide by 34 pixels tall.
      new google.maps.Size(20, 34),
      // The origin for this image is 0,0.
      new google.maps.Point(0,0),
      // The anchor for this image is at 9,34.
      new google.maps.Point(9, 34));
  var iconShadow = new google.maps.MarkerImage('https://www.google.com/mapfiles/shadow50.png',
      // The shadow image is larger in the horizontal dimension
      // while the position and offset are the same as for the main image.
      new google.maps.Size(37, 34),
      new google.maps.Point(0,0),
      new google.maps.Point(9, 34));
      // Shapes define the clickable region of the icon.
      // The type defines an HTML &lt;area&gt; element 'poly' which
      // traces out a polygon as a series of X,Y points. The final
      // coordinate closes the poly by connecting to the first
      // coordinate.
  var iconShape = {
      coord: [9,0,6,1,4,2,2,4,0,8,0,12,1,14,2,16,5,19,7,23,8,26,9,30,9,34,11,34,11,30,12,26,13,24,14,21,16,18,18,16,20,12,20,8,18,4,16,2,15,1,13,0],
      type: 'poly'
  };

function getMarkerImage(iconColor) {
   if ((typeof(iconColor)=="undefined") || (iconColor==null)) { 
      iconColor = "red"; 
   }
   if (!gicons[iconColor]) {
      gicons[iconColor] = new google.maps.MarkerImage("mapIcons/marker_"+ iconColor +".png",
      // This marker is 20 pixels wide by 34 pixels tall.
      new google.maps.Size(20, 34),
      // The origin for this image is 0,0.
      new google.maps.Point(0,0),
      // The anchor for this image is at 6,20.
      new google.maps.Point(9, 34));
   } 
   return gicons[iconColor];

}

function category2color(category) {
   var color = "red";
   switch(category) {
     case "theatre": color = "blue";
                break;
     case "golf":    color = "green";
                break;
     case "info":    color = "yellow";
                break;
     default:   color = "red";
                break;
   }
   return color;
}

      gicons["theatre"] = getMarkerImage(category2color("theatre"));
      gicons["golf"] = getMarkerImage(category2color("golf"));
      gicons["info"] = getMarkerImage(category2color("info"));

      // A function to create the marker and set up the event window
function createMarker(latlng,name,html,category) {
    var contentString = html;
    var marker = new google.maps.Marker({
        position: latlng,
        icon: gicons[category],
        shadow: iconShadow,
        map: map,
        title: name,
        zIndex: Math.round(latlng.lat()*-100000)<<5
        });
        // === Store the category and name info as a marker properties ===
        marker.mycategory = category;                                 
        marker.myname = name;
        gmarkers.push(marker);

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString); 
        infowindow.open(map,marker);
        });
}

      // == shows all markers of a particular category, and ensures the checkbox is checked ==
      function show(category) {
        for (var i=0; i<gmarkers.length; i++) {
          if (gmarkers[i].mycategory == category) {
            gmarkers[i].setVisible(true);
          }
        }
        // == check the checkbox ==
        document.getElementById(category+"box").checked = true;
      }

      // == hides all markers of a particular category, and ensures the checkbox is cleared ==
      function hide(category) {
        for (var i=0; i<gmarkers.length; i++) {
          if (gmarkers[i].mycategory == category) {
            gmarkers[i].setVisible(false);
          }
        }
        // == clear the checkbox ==
        document.getElementById(category+"box").checked = false;
        // == close the info window, in case its open on a marker that we just hid
        infowindow.close();
      }

      // == a checkbox has been clicked ==
      function boxclick(box,category) {
        if (box.checked) {
          show(category);
        } else {
          hide(category);
        }
        // == rebuild the side bar
        makeSidebar();
      }

      function myclick(i) {
        google.maps.event.trigger(gmarkers[i],"click");
      }


      // == rebuilds the sidebar to match the markers currently displayed ==
      function makeSidebar() {
        var html = "";
        for (var i=0; i<gmarkers.length; i++) {
          if (gmarkers[i].getVisible()) {
            html += '<a href="javascript:myclick(' + i + ')">' + gmarkers[i].myname + '<\/a><br>';
          }
        }
        document.getElementById("side_bar").innerHTML = html;
      }

  function initialize() {
	  
	var isDraggable = window.innerWidth > 680 ? true : false;
	var pan = window.innerWidth > 680 ? false : true;
    var myOptions = {
      zoom: 11,
		  panControl: pan,
	      draggable: isDraggable,
      center: new google.maps.LatLng(53.8363,-3.0377),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map"), myOptions);


    google.maps.event.addListener(map, 'click', function() {
        infowindow.close();
        });


      // Read the data
 
    }

    // This Javascript is based on code provided by the
    // Community Church Javascript Team
    // http://www.bisphamchurch.org.uk/   
    // http://econym.org.uk/gmap/
    // from the v2 tutorial page at:
    // http://econym.org.uk/gmap/example_categories.htm
    //]]>
    </script>
<body style="margin:0px; padding:0px;" onload="initialize()"> 




    <!-- you can use tables or divs for the overall layout -->
    <table border=1>
      <tr>
        <td>
           <div id="map" style="width: 550px; height: 450px"></div>
        </td>
        <td valign="top" style="width:150px; text-decoration: underline; color: #4444ff;"> 
           <div id="side_bar"></div>
        </td>
      </tr>
    </table>
    <form action="#">
      Theatres: <input type="checkbox" id="theatrebox" onclick="boxclick(this,'theatre')" /> &nbsp;&nbsp;
      Golf Courses: <input type="checkbox" id="golfbox" onclick="boxclick(this,'golf')" /> &nbsp;&nbsp;
      Tourist Information: <input type="checkbox" id="infobox" onclick="boxclick(this,'info')" /><br />
    </form>  







