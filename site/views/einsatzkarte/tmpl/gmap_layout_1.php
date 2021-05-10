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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Date\Date;

//Load admin language file
$lang = Factory::getLanguage();
$lang->load('com_einsatzkomponente', JPATH_ADMINISTRATOR);

// Mootools laden
JHtml::_('behavior.framework', true);

?>
<script> 
jQuery(document).ready(function(){
  jQuery("#einsatzarten_flip").click(function(){
    jQuery("#einsatzarten_panel").slideToggle("slow");
  });
});
</script>
 
<style> 
#einsatzarten_panel,#einsatzarten_flip
{
padding:5px;
text-align:center;
border:solid 1px #c3c3c3;
}
#einsatzarten_panel
{
display:none;
}
#einsatzarten_flip
{ margin-top:-10px;
}
</style>
 

<!--Page Heading-->
<?php if ($this->params->get('show_page_heading', 1)) : ?>
<div class="page-header">
<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
</div>
<?php endif;?>

<?php
$reports = $this->reports;
JFilterOutput::objectHtmlSafe($reports);
//print_r ($reports);
	 
$Monat ='';
$selectedYear = '';
$show_all = $this->params->get('show_all','true');
// Gmap - Konfiguration laden
$gmapconfig = $this->gmap_config; 
//print_r ($gmapconfig);

	

		if ($this->params->get('display_einsatzkarte_organisationen','1')) :
			// Feuerwehrliste aus DB holen
			$db = Factory::getDBO();
			$query = 'SELECT id, name,gmap_icon_orga,gmap_latitude,gmap_longitude,link,detail1 FROM #__eiko_organisationen WHERE state=1 ORDER BY id';
			$db->setQuery($query);
			$orga = $db->loadObjectList();

	  		$organisationen='['; // Feuerwehr Details  ------>
	  		$n=0;
	  		for($i = 0; $i < count($orga); $i++) {
			$orga_image 	= $orga[$i]->gmap_icon_orga;
			if (!$orga_image) : $orga_image= 'images/com_einsatzkomponente/images/map/icons/'.$this->params->get('einsatzkarte_orga_image','haus_rot.png'); endif;
		  	if($i==$n-1){
			$organisationen=$organisationen.'["'.$orga[$i]->name.'",'.$orga[$i]->gmap_latitude.','.$orga[$i]->gmap_longitude.','.$i.',"'.$orga_image.'"]';
		 	}else {
			$organisationen=$organisationen.'["'.$orga[$i]->name.'",'.$orga[$i]->gmap_latitude.','.$orga[$i]->gmap_longitude.','.$i.',"'.$orga_image.'"';
			$organisationen=$organisationen.'],';
		    }
	        }
	  		$organisationen=substr($organisationen,0,strlen($organisationen)-1);
	  		$organisationen=$organisationen.' ];';
		else:
			$organisationen	 = '[["",1,1,0,"images/com_einsatzkomponente/images/map/icons/'.$this->params->get('einsatzkarte_orga_image','haus_rot.png').'"],["",1,1,0,"images/com_einsatzkomponente/images/map/icons/'.$this->params->get('einsatzkarte_orga_image','haus_rot.png').'"] ]';	
			endif;
			

//echo $organisationen;break;


		if ($this->params->get('display_einsatzkarte_einsatzgebiet','1')) :
	  	 $alarmareas1  = $this->gmap_config->gmap_alarmarea;  // Einsatzgebiet  ---->
	 	 $alarmareas = explode('|', $alarmareas1);
	     $einsatzgebiet='[ ';
		  for($i = 0; $i < count($alarmareas)-1; $i++)
		  {
			  	  $areas = explode(',', $alarmareas[$i]);
				  $einsatzgebiet=$einsatzgebiet.'new google.maps.LatLng('.$areas[0].','.$areas[1].'),';
		  }
		$areas = explode(',', $alarmareas[0]);
		$einsatzgebiet=$einsatzgebiet.'new google.maps.LatLng('.$areas[0].','.$areas[1].'),';
	    $einsatzgebiet=substr($einsatzgebiet,0,strlen($einsatzgebiet)-1);
	    $einsatzgebiet=$einsatzgebiet.' ]';	
		else:
		$einsatzgebiet='[[0,0]]';
		endif;





// Einsatzarten als Kategorie setzen
$db = Factory::getDBO();
$query = 'SELECT COUNT(r.data1) as total,r.data1,rd.marker,rd.marker,rd.icon,rd.title as einsatzart FROM #__eiko_einsatzberichte r JOIN #__eiko_einsatzarten rd ON r.data1 = rd.id WHERE r.state = "1" AND rd.state = "1" GROUP BY r.data1';
$db->setQuery($query);
$pie = $db->loadObjectList();
//print_r ($pie);
JFilterOutput::objectHtmlSafe($pie);

$catinit ='';
$cat_count ='';
$catbox = '';
$i = 0;
while($i < count($pie))
{
$catinit    .= 'show("'.$pie[$i]->data1.'");';
$cat_count    .= 'cat_count("'.$pie[$i]->data1.'");';


$catbox .= '<div class="eiko_gmap_toolbar"><label for="'.$pie[$i]->data1.'box"><button type="button" class="btn btn-default btn-xs eiko_gmap_toolbar_button" onClick="boxclick(&#39;'.$pie[$i]->data1.'&#39;)"  id="div_'.$pie[$i]->data1.'"><input type="checkbox" class="eiko_gmap_checkbox" id="'.$pie[$i]->data1.'box" /><img src="'.JURI::base().$pie[$i]->icon.'" class="eiko_gmap_toolbar_icon" />&nbsp;'.$pie[$i]->einsatzart.'<span class="pull-right" style ="font-size:8px;" ><span class="eiko_gmap_count" id="'.$pie[$i]->data1.'count"></span> / '.$pie[$i]->total.' '.Text::_('COM_EINSATZKOMPONENTE_EINSAETZE').'</span></button></label></div>';

$i++; 
} 
if ($this->params->get('display_einsatzkarte_einsatzgebiet','1')) :
$catbox .= '<div class="eiko_gmap_toolbar"><label for="area"><button type="button" class="btn btn-default btn-xs eiko_gmap_toolbar_button" onClick="togglearea()" id="div_area"><input type="checkbox" class="eiko_gmap_checkbox" id="area" onClick="togglearea()" checked/>&nbsp;&nbsp;<img src="'.JURI::base().'images/com_einsatzkomponente/images/map/icons/'.$this->params->get('einsatzkarte_orga_image','haus_rot.png').'" class="eiko_gmap_toolbar_icon" />'.Text::_('COM_EINSATZKOMPONENTE_EINSATZGEBIET_ANZEIGEN').'</button></label></div>';
endif;
if (!$this->params->get('display_einsatzkarte_einsatzgebiet','1')) :
$catbox .= '';
endif;



$database			=Factory::getDBO();
$query = 'SELECT COUNT(id) as total FROM #__eiko_einsatzberichte WHERE gmap="1" AND state = "1" ' ;
$database->setQuery( $query );
$total = $database->loadObjectList();	
$totalRecords = $total[0]->total;


	  
// -------------------- Filter Jahr ----------------------------------
  function getYear()
  {
	$db = Factory::getDBO();
	$query = 'SELECT Year(date1) as id, Year(date1) as title FROM #__eiko_einsatzberichte WHERE gmap="1" AND state = "1" GROUP BY title';
	$db->setQuery($query);
	return $db->loadObjectList();
  }
	  
	  
	  
	  
?>

<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=<?php echo $this->params->get ('gmapkey','AIzaSyAuUYoAYc4DI2WBwSevXMGhIwF1ql6mV4E') ;?>"></script> 
 
    
    <script type="text/javascript">
    //<![CDATA[
      // this variable will collect the html which will eventually be placed in the side_bar 
      var side_bar_html = ""; 
      var gmarkers = [];
      var map = null;
      var standorte = [];
      var polyline = null;
      var polygon = null;
	  var bild = null;
	  var bildschatten = null;
 
var infowindow = new google.maps.InfoWindow(
  { 
    size: new google.maps.Size(150,120)
  });
 
function createHouse(latlng, label, html,index,image) {
    var contentString = '<div class="infowindow"><span class="infowindowlabel">'+label+'</span><br/>'+html+'</div>';
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        icon: image,
        title: label,
        zIndex: index
        });
 
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString); 
        infowindow.open(map,marker);
        });
    standorte.push(marker);
}

      // A function to create the marker and set up the event window
function createMarker(latlng,name,html,category,image,id,date1,day,month,year,foto,itemid) {
var contentString = "<div align='center'><span class='label label-info' style='font-size:16px;padding: 2px 2px 2px 2px;margin:2px 2px 2px 2px;font-weight:bold;'>" + html + "</span><br/>" + name + "<br/>" + day + "." + month + "." + year + "<?php if ($this->params->get('display_einsatzkarte_links','1')) :?><br/>" + "<a class='btn-home' href=<?php echo Route::_('index.php?option=com_einsatzkomponente'.$this->layout_detail_link.'&view=einsatzbericht&id=' ); ?>"+id+"><?php echo Text::_('COM_EINSATZKOMPONENTE_DETAILS');?></a><?php endif;?></div>";

var detailString = "<table style='height:100px;'><tr><td width='88%'><div style=' background-color:#ffffff;' align='left'><span style='font-size:14px;padding: 2px 2px 2px 2px;margin:2px 2px 2px 2px;font-weight:bold;color:#fff;background-color:#ff0000;'>" + html + "</span>" + "<p></p>Einsatzdatum : " + day + "." + month + "." + year + "<p></p><strong>" + name + "</strong> " + "" + "<p></p>" + "<p align='left'>" + "<a href=<?php echo Route::_('index.php?option=com_reports2&all=0');?>" + "&view=show&Itemid=" + itemid + "&gmaplink=1&id=" + id + "> zum Detailbericht <\/a></p></div></td><td style='padding-right:20px;margin-right:20px;'><img style='border:1px solid;' src='/components/com_reports2/images/noimage.png' height='90' /></td></tr></table>";

if (foto != "") 
{
var detailString = "<table style='height:100px;'><tr><td width='88%'><div style=' background-color:#ffffff;' align='left'><span style='font-size:14px;padding: 2px 2px 2px 2px;margin:2px 2px 2px 2px;font-weight:bold;color:#fff;background-color:#ff0000;'>" + html + "</span>" + "<p></p>Einsatzdatum : " + day + "." + month + "." + year + "<p></p><strong>" + name + "</strong> " + "" + "<p></p>" + "<p align='left'>" + "<a href=<?php echo Route::_('index.php?option=com_reports2&all=0');?>" + "&view=show&Itemid=" + itemid + "&gmaplink=1&id=" + id + "> zum Detailbericht <\/a></p></div></td><td style='padding-right:20px;margin-right:20px;'><img style='border:1px solid;' src='/" + foto + "' height='90' /></td></tr></table>";
}

var bild = new google.maps.MarkerImage("<?php echo JURI::root()."/";?>"+ image,null, null, null, new google.maps.Size(<?php echo $this->params->get('einsatzkarte_gmap_icon', 14);?>, <?php echo $this->params->get('einsatzkarte_gmap_icon', 14);?>));
var bildschatten = new google.maps.MarkerImage("<?php echo JURI::root()."/shadow-";?>"+ image,new google.maps.Size(<?php echo $this->params->get('einsatzkarte_gmap_icon', 14);?>, <?php echo $this->params->get('einsatzkarte_gmap_icon', 14);?>), null, null, new google.maps.Size(<?php echo $this->params->get('einsatzkarte_gmap_icon', 14);?>, <?php echo $this->params->get('einsatzkarte_gmap_icon', 14);?>));

  // Marker sizes are expressed as a Size of X,Y
  // where the origin of the image (0,0) is located
  // in the top left of the image.
    var marker = new google.maps.Marker({
        position: latlng,
        icon: bild,
        shadow: bildschatten,
        map: map,
        title: name,
        zIndex: Math.round(latlng.lat()*-100000)<<5
        });
        // === Store the category and name info as a marker properties ===
        marker.mycategory = category;                                 
        marker.myname = name;
		marker.year = year;
		marker.month = month;
		marker.day = day;
		marker.date1 = date1;
		marker.id = id;
		marker.image = image;
        marker.itemid = itemid;
        gmarkers.push(marker);
 
    google.maps.event.addListener(marker, 'click', function() {
		infowindow.setContent(contentString); 
        infowindow.open(map,marker);
		document.getElementById("details").innerHTML = detailString;
        });
}
 
      // == shows all markers of a particular category, and ensures the checkbox is checked ==
      function show(category) {
        jahr = document.getElementById("selectstartyear").value;
        monat = document.getElementById("selectstartmonth").value;
        jahrend = document.getElementById("selectendyear").value;
        monatend = document.getElementById("selectendmonth").value;
		var n=0;
        for (var i=0; i<gmarkers.length; i++) {
          if (gmarkers[i].mycategory == category && gmarkers[i].date1 >= jahr + "-" + monat + "-00 00:00:00" && gmarkers[i].date1 <= jahrend + "-" + monatend + "-31 23:59:59") {
			n++;  
            gmarkers[i].setVisible(true);
			
          }
		  
        }
        // == check the checkbox ==
        document.getElementById(category+"box").checked = true;
		document.getElementById(category+"count").innerHTML = n;
		document.getElementById("div_" + category).addClass('active');
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
		document.getElementById(category+"count").innerHTML = '0';
		document.getElementById("div_" + category).removeClass('active');
        // == close the info window, in case its open on a marker that we just hid
        infowindow.close();
      }
	  
      function cat_count(category) {
        jahr = document.getElementById("selectstartyear").value;
        monat = document.getElementById("selectstartmonth").value;
        jahrend = document.getElementById("selectendyear").value;
        monatend = document.getElementById("selectendmonth").value;
		var n=0;
        for (var i=0; i<gmarkers.length; i++) {
          if (gmarkers[i].mycategory == category && gmarkers[i].date1 >= jahr + "-" + monat + "-00 00:00:00" && gmarkers[i].date1 <= jahrend + "-" + monatend + "-31 23:59:59") {
			n++;  
          }
		  
        }
        // == check the checkbox ==
			document.getElementById(category+"count").innerHTML = n;
      }
 
      // == a checkbox has been clicked ==
      function boxclick(category) {
        if (document.getElementById(category+"box").checked == false) {
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
        var side = "";
        for (var i=0; i<gmarkers.length; i++) {
          if (gmarkers[i].getVisible()) {
          side += '<div class="eiko_gmap_sidebar_div"><a class="eiko_gmap_sidebar_link" href="javascript:myclick(' + i + ')">' + gmarkers[i].day + "." + gmarkers[i].month + "." + gmarkers[i].year + "  " + '<img src="<?php echo JURI::base();?>'+gmarkers[i].image+'" class ="eiko_gmap_sidebar_icon" alt=""/>' + gmarkers[i].myname + '<\/a></div>';
          }
        }
        document.getElementById("side_bar").innerHTML = side;
		document.getElementById("details").innerHTML = '<table style="width:100%;height:100px;"><div align="center"><p></p><p></p><p></p>F&uuml;r weitere Details, bitte einen Einsatz ausw&auml;hlen</div></table>';
        infowindow.close();
      }
 
      function selectdate() {
        jahr = document.getElementById("selectstartyear").value;
        monat = document.getElementById("selectstartmonth").value;
        jahrend = document.getElementById("selectendyear").value;
        monatend = document.getElementById("selectendmonth").value;
        for (var i=0; i<gmarkers.length; i++) {
          if (gmarkers[i].date1 >= jahr + "-" + monat + "-00 00:00:00" && gmarkers[i].date1 <= jahrend + "-" + monatend + "-31 23:59:59") {
			  box =  document.getElementById(gmarkers[i].mycategory+"box").checked;
			  if (box == true) { 
              gmarkers[i].setVisible(true);
              }
			}
   else {
          gmarkers[i].setVisible(false);
        }
		}
		 makeSidebar();
		 <?php echo $cat_count;?>
	  }
 
togglearea = function(opt_enable) {
  if (typeof opt_enable == 'undefined') {
    opt_enable = !polygon.getMap();
  }
  polygon.setMap(opt_enable ? map : null);
};



  function initialize() {
    var latlng = new google.maps.LatLng(<?php echo $gmapconfig->start_lat;?>, <?php echo $gmapconfig->start_lang;?>);
	
		var myOptions = {
		  maxZoom: <?php echo $this->params->get('display_einsatzkarte_max_zoom_level', 14);?>,
		  zoom: <?php echo $this->params->get('display_einsatzkarte_zoom_level', 14);?>,
		  center: latlng,
		  mapTypeId: google.maps.MapTypeId.<?php echo $gmapconfig->gmap_onload ;?>,
          mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
		  mapTypeControl: true,
		  panControl: false,
	      draggable: true,
          scrollwheel: false,
          disableDoubleClickZoom: true,
     	  streetViewControl: false,
          keyboardShortcuts: false,
          navigationControl: false, 
          navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL}
		};
		
    map = new google.maps.Map(document.getElementById("map"), myOptions);
 
 
    google.maps.event.addListener(map, 'click', function() {
        infowindow.close();
		document.getElementById("details").innerHTML = '<table style="width:100%;height:100px;"><div align="center"><p></p><p></p><p></p>F&uuml;r weitere Details, bitte einen Einsatz ausw&auml;hlen</div></table>';

        });
 
	  
<?php // Marker stellen
$i = 0;
$hide = 0;

while($i < count($reports))
{
	
$rSummary = (strlen($reports[$i]->summary) > 100) ? substr($reports[$i]->summary,0,strrpos(substr($reports[$i]->summary,0,100+1),' ')) : $reports[$i]->summary;
$rSummary = htmlspecialchars($rSummary, ENT_QUOTES);
$year = date("Y",strtotime($reports[$i]->date1));  ### 111225
$month = date("m",strtotime($reports[$i]->date1)); ### 111225
$day = date("d",strtotime($reports[$i]->date1));   ### 111225


if ($reports[$i]->gmap AND $reports[$i]->gmap_report_latitude != "0") {

?>
var marker = createMarker(new google.maps.LatLng(<?php echo $reports[$i]->gmap_report_latitude;?>,<?php echo $reports[$i]->gmap_report_longitude;?>),"<?php echo $rSummary;?>","<?php echo $reports[$i]->einsatzart;?>","<?php echo $reports[$i]->data1;?>","<?php echo $reports[$i]->icon;?>","<?php echo $reports[$i]->id;?>","<?php echo $reports[$i]->date1;?>","<?php echo $day;?>","<?php echo $month;?>","<?php echo $year;?>","<?php echo $reports[$i]->image;?>","");
<?php 
}
else {$hide++;}
$i++; 
} 
?>

var homes = <?php echo $organisationen;?>  
var infowindow = new google.maps.InfoWindow(
  { 
    size: new google.maps.Size(150,120)
  });
  for (var i = 0; i < homes.length; i++) {
    var homi = homes[i];
	var image = new google.maps.MarkerImage("<?php echo JURI::root()."/";?>"+ homi[4],null, null, null, new google.maps.Size(<?php echo $this->params->get('einsatzkarte_gmap_icon_orga', 24);?>, <?php echo $this->params->get('einsatzkarte_gmap_icon_orga', 24);?>));
    var myLatLng = new google.maps.LatLng(homi[1], homi[2]);
    var marker = createHouse(myLatLng,homi[0],'',homi[3],image);
    
  }

		// == show or hide the categories initially ==
<?php echo $catinit;?>
<?php echo $cat_count;?>

   
        // == create the initial sidebar ==
		
		
        // Initialize time filter
        now = new Date();
        document.getElementById("selectstartmonth").options[now.getMonth()].selected = false;
        years = document.getElementById("selectstartyear").options;
		for(i=0; i<years.length; i++)
		{
			 if(years[i].value == now.getFullYear()-1)
				{
				years[i].selected = <?php echo $show_all;?>;	
                document.getElementById("selectstartmonth").options[0].selected = <?php echo $show_all;?>;
				}
			if(years[i].value == now.getFullYear())
				years[i].selected = <?php echo $show_all;?>;
			if(now.getMonth == 0)
				years[i-1].selected = <?php echo $show_all;?>;
		}
        document.getElementById("selectendmonth").options[now.getMonth()].selected = true;
        years = document.getElementById("selectendyear").options;
        for(i=0; i<years.length; i++)
		{
                if(years[i].value == now.getFullYear()-1)
				{
				years[i].selected = true;	
                document.getElementById("selectendmonth").options[11].selected = true;
				}
				if(years[i].value == now.getFullYear())
				{
				years[i].selected = true;
                document.getElementById("selectendmonth").options[now.getMonth()].selected = true;
				}
		}


// Enable Zeitfilter und Sdebar
selectdate();
		
var alarmarea = <?php echo $einsatzgebiet;?>

  // Create a polyline connected alarmarea.
    polygon = new google.maps.Polygon({
    path: alarmarea,
    fillOpacity: 0.2,
    strokeColor: '#ff0000',
    strokeWeight: 3,
    fillColor: '#f00000'
  });
		
polygon.setMap(map);      
}
    </script>
 
  </head>
<body style="margin:0px; padding:0px;" onLoad="initialize()"> 
 
    
    
<?php 

  $Mona = [];
  for ($i = 0; $i < 12; $i++):
    $Mona[$i] = JHTML::_('select.option', sprintf('%02d', $i + 1), JTEXT::_((new JDate)->monthToString($i + 1)),'id','title');
  endfor;

  $years = getyear();

?>

<form action="#">   

<div class="container-fluid">

<div class="well row-fluid" id="catbox"> 
 <?php
  echo JHTML::_('select.genericlist', $Mona, 'selectstartmonth', 'class="eiko_gmap_month_select" onchange=selectdate() ','id', 'title', $Monat);
  echo JHTML::_('select.genericlist',  $years, 'selectstartyear', 'class="eiko_gmap_year_select" onchange=selectdate() ', 'id', 'title', $selectedYear);
  echo ' '.Text::_('COM_EINSATZKOMPONENTE_BIS').' ';
  echo JHTML::_('select.genericlist', $Mona, 'selectendmonth', 'class="eiko_gmap_month_select" onchange=selectdate() ','id', 'title', $Monat);
  echo JHTML::_('select.genericlist',  $years, 'selectendyear', 'class="eiko_gmap_year_select" onchange=selectdate() ', 'id', 'title', $selectedYear);
  ?>

<button type="button" id="einsatzarten_flip" class="btn btn-sm"><?php echo Text::_('COM_EINSATZKOMPONENTE_EINSATZARTEN_AUSWAEHLEN');?></button>

</div>

<?php echo '<div class="well row-fluid btn-toolbar" id="einsatzarten_panel">'.$catbox.'</div>';?>

  <div class="row-fluid">
 <?php if ($this->params->get('display_einsatzkarte_sidebar','1')) : ?>
<div class="well eiko_gmap_sidebar span6" id="side_bar" style="height: <?php echo $this->params->get('einsatzkarte_map_height','450');?>px"></div>
<?php endif; ?>
 <?php if (!$this->params->get('display_einsatzkarte_sidebar','1')) : ?>
<div class="well eiko_gmap_sidebar span6" id="side_bar" style="display:none;height: <?php echo $this->params->get('einsatzkarte_map_height','450');?>px"></div>
<?php endif; ?>
 <?php if ($this->params->get('display_einsatzkarte_map','1')) : ?>
<div class="well eiko_gmap_map well span6" id="map" style="height: <?php echo $this->params->get('einsatzkarte_map_height','450');?>px"></div>
<?php endif; ?>
 <?php if (!$this->params->get('display_einsatzkarte_map','1')) : ?>
<div class="well eiko_gmap_map well span6" id="map" style="display:none;"></div>
<?php endif; ?>
</div>
<?php if ($hide) :?>
<div class="eiko_privat"><span class="glyphicon glyphicon-info-sign"></span> <?php echo Text::_('COM_EINSATZKOMPONENTE_EINSAETZE_KARTE_1');?> <?php echo $hide;?> <?php echo Text::_('COM_EINSATZKOMPONENTE_EINSAETZE_KARTE_2');?></div>
<?php endif;?>

<div class="row-fluid">

<div class="span6" id="details" style="display:none;"><?php echo Text::_('COM_EINSATZKOMPONENTE_EINSAETZE_DATEN_LESEN');?> ...</div>
<!--Höhe der sidebar-tabelle an catbox-tabelle anpassen --> 

</div>

<?php if (!$this->params->get('eiko')) : ?>
<div class="row-fluid">
        <div class="span12"><!-- Bitte das Copyright nicht entfernen. Danke. -->
            <span class="copyright">Einsatzkomponente V<?php echo $this->version; ?>  (C) 2017 by Ralf Meyer ( <a class="copyright_link" href="https://einsatzkomponente.de" target="_blank">www.einsatzkomponente.de</a> )</span>
        </div>
</div>

	<?php endif; ?>
</div>
</form>   

 <?php
   
   
   
   
   
