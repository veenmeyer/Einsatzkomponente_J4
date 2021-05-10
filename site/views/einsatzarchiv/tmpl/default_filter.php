<?php
/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */


defined('JPATH_BASE') or die;

$app = JFactory::getApplication();
$params = $app->getParams('com_einsatzkomponente');




$data = $displayData;

// Receive overridable options
$data['options'] = !empty($data['options']) ? $data['options'] : array();

// Set some basic options
$customOptions = array(
    'filtersHidden' => isset($data['options']['filtersHidden']) ? $data['options']['filtersHidden'] : empty($data['view']->activeFilters),
    'defaultLimit' => isset($data['options']['defaultLimit']) ? $data['options']['defaultLimit'] : JFactory::getApplication()->get('list_limit', 20),
    'searchFieldSelector' => '#filter_search',
    'orderFieldSelector' => '#list_fullordering'
);


$data['options'] = array_unique(array_merge($customOptions, $data['options']));

$formSelector = !empty($data['options']['formSelector']) ? $data['options']['formSelector'] : '#adminForm';
$filters = false;
if (isset($data['view']->filterForm)) {
    $filters = $data['view']->filterForm->getGroup('filter');
}

?>


<!--RSS-Feed Imag-->
<?php if ($params->get('display_home_rss','1')) : ?>
<div class="btn-wrapper  eiko_rss_main_1" ><a href="<?php JURI::base();?>index.php?option=com_einsatzkomponente&view=einsatzarchiv&format=feed&type=rss"><span class="icon-feed" style="color:#cccccc;font-size:24px;"> </span> </a></div>

 <!--<div class="btn-wrapper  eiko_rss_main_1" ><a href="<?php JURI::base();?>index.php?option=com_einsatzkomponente&view=einsatzarchiv&format=json&type=json"><span class="icon-feed" style="color:#000000;font-size:24px;"> </span></a></div> -->

<?php endif;?>

<?php

if ($params->get('show_filter','1')) {

// Load search tools
JHtml::_('searchtools.form', $formSelector, $data['options']);
?>

<div class="js-stools clearfix">
    <div class="clearfix">
        <div class="js-stools-container-bar">
		

		<?php if ($params->get('show_filter_search','1')) : ?>
            <!--<label for="filter_search" class="element-invisible" aria-invalid="false"><?php echo JText::_('COM_EINSATZKOMPONENTE_SUCHEN'); ?></label> -->

            <div class="btn-wrapper input-append">
                <?php echo $filters['filter_search']->input; ?>
                <button type="submit" class="btn " title="" data-original-title="<?php echo JText::_('COM_EINSATZKOMPONENTE_SUCHEN'); ?>">
                    <i class="icon-search"></i>
                </button>
            </div>
		<?php endif; ?>
		
		<?php if ($filters) : ?>
            <!-- <div class="btn-wrapper hidden-phone"> -->
            	<div class="btn-wrapper"> 
                <button type="button" class="btn  js-stools-btn-filter" title=""
                        data-original-title="<?php echo JText::_('COM_EINSATZKOMPONENTE_FILTER_AUSWAEHLEN'); ?>">
                    <?php echo JText::_('COM_EINSATZKOMPONENTE_FILTER_AUSWAEHLEN'); ?> <i class="caret"></i>
                </button>
            </div>
            <?php endif; ?>
            <!-- <div class="btn-wrapper hidden-phone"> -->
            	<div class="btn-wrapper"> 
                <button type="button" class="btn  js-stools-btn-clear" title="" data-original-title="<?php echo JText::_('COM_EINSATZKOMPONENTE_ALLE_FILTER_ZURUECKSETZEN'); ?>">
                    <?php echo JText::_('COM_EINSATZKOMPONENTE_ALLE_FILTER_ZURUECKSETZEN'); ?>
                </button>
            </div>
        </div>
    </div>
	
	
    <!-- Filters div -->
    <!-- <div class="js-stools-container-filters hidden-phone clearfix" style=""> -->
    <div class="js-stools-container-filters clearfix" style="">
        <?php // Load the form filters ?>
        <?php if ($filters) : ?>
			
		<div class="js-stools-field-filter">
		
		<?php if ($params->get('show_filter_auswahl_orga','1')) : ?>
		<?php echo $filters['filter_auswahl_orga']->input; ?>
		<?php echo '<br/><br/>';?>
		<?php endif; ?>

		<?php if ($params->get('show_filter_year','1')) : ?>
		<?php echo $filters['filter_year']->input; ?>
		<?php if ($params->get('show_filter_linebreak','0')) :echo '<br/>'; endif;?>
		<?php endif; ?>

		<?php if ($params->get('show_filter_data1','1')) : ?>
		<?php echo $filters['filter_data1']->input; ?>
		<?php if ($params->get('show_filter_linebreak','0')) :echo '<br/>'; endif;?>
		<?php endif; ?>

		<?php if ($params->get('show_filter_tickerkat','1')) : ?>
		<?php echo $filters['filter_tickerkat']->input; ?>
		<?php if ($params->get('show_filter_linebreak','0')) :echo '<br/>'; endif;?>
		<?php endif; ?>

		<?php if ($params->get('show_filter_alerting','1')) : ?>
		<?php echo $filters['filter_alerting']->input; ?>
		<?php if ($params->get('show_filter_linebreak','0')) :echo '<br/>'; endif;?>
		<?php endif; ?>

		<?php if ($params->get('show_filter_vehicles','1')) : ?>
		<?php echo $filters['filter_vehicles']->input; ?>
		<?php endif; ?>
		
		</div>
		

		<?php endif; ?>
    </div>
	

 
		<div>
		<?php $active_name = ''; ?>
		<?php $active = $data['view']->activeFilters;?>
		<?php if($active): ?>
		<?php $active_name = 'Aktive Filter : '; ?>
            <?php foreach ($active as $fieldName => $field) : ?>
						
				<?php switch ($fieldName) 
				 { 
				 	case 'vehicles': $active_name .= '<span class="label label-info">'.JText::_('COM_EINSATZKOMPONENTE_FAHRZEUG').'</span> ';break; 
				 	case 'alerting': $active_name .= '<span class="label label-info">'.JText::_('COM_EINSATZKOMPONENTE_ALARMIERUNGSART').'</span> ';break; 
				 	case 'data1': $active_name .= '<span class="label label-info">'.JText::_('COM_EINSATZKOMPONENTE_EINSATZART').'</span> ';break; 
					case 'tickerkat': $active_name .= '<span class="label label-info">'.JText::_('COM_EINSATZKOMPONENTE_KATEGORIE').'</span> ';break; 
				 	case 'auswahl_orga': $active_name .= '<span class="label label-info">'.JText::_('COM_EINSATZKOMPONENTE_ORGANISATION').'</span> ';break;
				 	case 'year': $active_name .= '<span class="label label-info">'.JText::_('COM_EINSATZKOMPONENTE_JAHR').'</span> ';break; 
				 	default: $active_name = '';break; 
				}  ?>

            <?php endforeach; ?>
			<?php echo $active_name;?>
		<?php endif; ?>
		</div>

</div>

<?php } ?>