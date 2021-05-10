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
//Load admin language file
$lang = Factory::getLanguage();
$lang->load('com_einsatzkomponente', JPATH_ADMINISTRATOR);
?>
<?php if( $this->item ) : ?>
    <div class="item_fields">
        
        <ul class="fields_list">
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_ID'); ?>:
			<?php echo $this->item->id; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_ORDERING'); ?>:
			<?php echo $this->item->ordering; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_DATA1'); ?>:
			<?php echo $this->item->data1.' : '.$this->item->einsatzart; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_IMAGE'); ?>:
			<?php $this->item->image = preg_replace("%thumbs/%", "", $this->item->image,1); ?>
			<?php echo $this->item->image; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_ADDRESS'); ?>:
			<?php echo $this->item->address; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_DATE1'); ?>:
			<?php echo $this->item->date1; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_DATE2'); ?>:
			<?php echo $this->item->date2; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_DATE3'); ?>:
			<?php echo $this->item->date3; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_SUMMARY'); ?>:
			<?php echo $this->item->summary; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_BOSS'); ?>:
			<?php echo $this->item->boss; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_BOSS2'); ?>:
			<?php echo $this->item->boss2; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_PEOPLE'); ?>:
			<?php echo $this->item->people; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_DEPARTMENT'); ?>:
			<?php echo $this->item->department; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_DESC'); ?>:
			<?php echo $this->item->desc; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_ALERTING'); ?>:
			<?php echo $this->item->alerting; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_GMAP_REPORT_LATITUDE'); ?>:
			<?php echo $this->item->gmap_report_latitude; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_GMAP_REPORT_LONGITUDE'); ?>:
			<?php echo $this->item->gmap_report_longitude; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_COUNTER'); ?>:
			<?php echo $this->item->counter; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_GMAP'); ?>:
			<?php echo $this->item->gmap; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_PRESSE'); ?>:
			<?php echo $this->item->presse; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_PRESSE2'); ?>:
			<?php echo $this->item->presse2; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_PRESSE3'); ?>:
			<?php echo $this->item->presse3; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_UPDATEDATE'); ?>:
			<?php echo $this->item->updatedate; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_EINSATZTICKER'); ?>:
			<?php echo $this->item->einsatzticker; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_NOTRUFTICKER'); ?>:
			<?php echo $this->item->notrufticker; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_TICKERKAT'); ?>:
			<?php echo Text::_($this->item->tickerKat->title); ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_AUSWAHLORGA'); ?>:
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
						->select('name')
						->from('#__eiko_organisationen')
						->where('id = "' .$value.'"');
					$db->setQuery($query);
					$results = $db->loadObjectList();
					$data[] = $results[0]->name;
				endforeach;
				$this->item->auswahl_orga = implode(',',$data); ?>
			<?php echo $this->item->auswahl_orga; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_VEHICLES'); ?>:
			<?php
				$array = array();
				foreach((array)$this->item->vehicles as $value): 
					if(!is_array($value)):
						$array[] = $value;
					endif;
				endforeach;
				$data = array();
				foreach($array as $value):
					$db = Factory::getDbo();
					$query	= $db->getQuery(true);
					$query
						->select('name')
						->from('#__eiko_fahrzeuge')
						->where('id = "' .$value.'"');
					$db->setQuery($query);
					$results = $db->loadObjectList();
					$data[] = $results[0]->name;
				endforeach;
				$this->item->vehicles = implode(',',$data); ?>
			<?php echo $this->item->vehicles; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_STATUS'); ?>:
			<?php echo $this->item->status; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_STATE'); ?>:
			<?php echo $this->item->state; ?></li>
			<li><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZBERICHT_CREATED_BY'); ?>:
			<?php echo $this->item->created_by; ?></li>
            
            <?php if( $this->item->gmap_report_latitude != '0' ) : ?> 
			<?php if ($this->params->get('gmap_action','0') == '1') :?>
  			<li><div id="map-canvas" style="width:100%; height:<?php echo $this->params->get('detail_map_height','250px');?>;">
    		<noscript>Dieser Teil der Seite erfordert die JavaScript Unterstützung Ihres Browsers!</noscript>
			</div></li>
            <?php endif;?>
			<?php if ($this->params->get('gmap_action','0') == '2') :?>
				<li><body onLoad="drawmap();"></body>
				<!--<div id="descriptionToggle" onClick="toggleInfo()">Informationen zur Karte anzeigen</div>
				<div id="description" class="">Einsatzkarte</div>-->
				<div id="map" style="width:100%; height:<?php echo $this->params->get('detail_map_height','250px');?>;"></div> 
    		<noscript>Dieser Teil der Seite erfordert die JavaScript Unterstützung Ihres Browsers!</noscript>
            <?php endif;?>
            <?php endif;?>
            
        </ul>
        
		<?php
			$plugin = PluginHelper::getPlugin('content', 'myshariff') ;
			if ($plugin) : 	echo JHTML::_('content.prepare', '{myshariff}');endif;
			?>

    </div>
<?php else: ?>
    Could not load the item
<?php endif; ?>
