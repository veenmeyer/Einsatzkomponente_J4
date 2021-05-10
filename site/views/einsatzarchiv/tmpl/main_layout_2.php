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
//echo count ($this->items).' - '.count($this->all_items);
//print_r ($this->all_items);
?>

<?php echo '<span class="mobile_hide_320">'.$this->modulepos_2.'</span>';?>

<form action="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzarchiv&Itemid='.$this->params->get('homelink','').''); ?>" method="post" name="adminForm" id="adminForm">

    <?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
    <table class="table" id = "einsatzberichtList" >
        <thead >
		
			<?php $eiko_col = 0;?>

            <tr class="mobile_hide_480 ">
			
				<th class='left'>
				<?php echo 'Nr.'; ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>

				<th class='left'>
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_DATE1'); ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
				
    			<th class='left'>
				<?php echo ''; ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
				
           <?php if ($this->params->get('display_home_image')) : ?>
				<th class='left mobile_hide_480 '>
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_IMAGE'); ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
			<?php endif;?>
				
		<!--		<th class='left'>
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_IMAGES'); ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th> -->
				<th class='left mobile_hide_480'>
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_SUMMARY'); ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
				<?php if ($this->params->get('display_home_orga','0')) : ?>
				<th class='left'>
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_AUSWAHLORGA'); ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th> 
				<?php endif; ?>
		<!--		<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_VEHICLES', 'a.vehicles', $listDirn, $listOrder); ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th> -->
				<?php if ($this->params->get('display_home_counter','1')) : ?>
				<th class='left mobile_hide_480 '>
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_ZUGRIFFE'); ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
				<?php endif;?>
		<!--		<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_CREATED_BY', 'a.created_by', $listDirn, $listOrder); ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th> -->


    <?php if (isset($this->items[0]->id)): ?>
      <!--  <th width="1%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				<?php $eiko_col = $eiko_col+1;?>
        </th> -->
    <?php endif; ?>

    		<?php if ($canEdit || $canDelete): ?>
             <?php if (isset($this->items[0]->state)): ?>
				<th width="1%" class="nowrap center">
				<?php echo JText::_('Actions'); ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
			<?php endif; ?>  
			<?php endif; ?>
	

    </tr>
    <?php if ($canCreate): ?>
        <tr>
        <td colspan="<?php echo $eiko_col;?>">
        <a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzberichtform&layout=edit&id=0&addlink=1', false, 2); ?>"
           class="btn btn-success btn-small"><i
                class="icon-plus"></i> <?php echo JText::_('COM_EINSATZKOMPONENTE_ADD'); ?></a>
		</td></tr>
    <?php endif; ?>
    </thead>
	
    <tbody>
	
	<?php 	$m ='';
			$y='';
	?>
    <?php foreach ($this->items as $i => $item) : ?>
        <?php $canEdit = $user->authorise('core.edit', 'com_einsatzkomponente'); ?>

        				<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_einsatzkomponente')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

           <!--Anzeige des Jahres-->
           <?php if ($item->date1_year != $y&& $this->params->get('display_home_jahr','1')) : ?>
		   <tr class="eiko_einsatzarchiv_jahr_tr"><td class="eiko_einsatzarchiv_jahr_td" colspan="<?php echo $eiko_col; ?>">
           <?php $y= $item->date1_year;?>
           <?php $m= ''; /* reset month for new year */ ?>
		   <?php echo '<div class="eiko_einsatzarchiv_jahr_div">';?>
           <?php echo 'Einsatzberichte '. $item->date1_year.'';?> 
           <?php echo '</div>';?>
           </td></tr>
           <?php endif;?>
           <!--Anzeige des Jahres ENDE-->

           <!--Anzeige des Monatsnamen-->
           <?php if (($item->date1_month != $m || $item->date1_year != $y) && $this->params->get('display_home_monat','1')) : ?>
           <?php $y = $item->date1_year; // $y may not have been set before if display_home_jahr is 0 ?>
		   <tr class="eiko_einsatzarchiv_monat_tr"><td class="eiko_einsatzarchiv_monat_td" colspan="<?php echo $eiko_col; ?>">
           <?php $m= $item->date1_month;?>
		   <?php echo '<div class="eiko_einsatzarchiv_monat_div">';?>
           <?php echo (new JDate)->monthToString($m);?>
           <?php echo '</div>';?>
           </td></tr>
           <?php endif;?>
           <!--Anzeige des Monatsnamen ENDE-->

		   <tr class="row<?php echo $i % 2; ?>">

			<td>
			<?php //echo $item->number;?>
			</td>

        <?php $date_image = $this->params->get('display_home_date_image','1') ?>
        <?php if ($date_image == '0' || $date_image == '2') : ?>
          <td class="eiko_td_datum_main_1">
            <?php echo date('d.m.Y', $item->date1); ?>
            <?php if ($date_image == '2') : ?>
              <br /><?php echo date('H:i', $item->date1); ?>Uhr
            <?php endif; ?>
          </td>
        <?php endif; ?>

        <?php if ($date_image == '1' || $date_image == '3') : ?>
          <td class="eiko_td_kalender_main_1">
            <div class="home_cal_icon">
              <div class="home_cal_monat"><?php echo date('M', $item->date1); ?></div>
              <div class="home_cal_tag"><?php echo date('d', $item->date1); ?></div>
              <div class="home_cal_jahr"><span style="font-size:10px;"><?php echo date('Y', $item->date1); ?></span></div>
              <?php if ($date_image == '3') : ?>
                <div style="font-size: 12px; white-space: nowrap;"><?php echo date('H:i', $item->date1); ?>Uhr</div>
              <?php endif;?>
            </div>
          </td>
        <?php endif;?>

            	<td>
					<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'einsatzarchiv.', $canCheckin); ?>
					<?php endif; ?> 
					
					<?php if ($this->params->get('display_home_links','1')) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&id='.(int) $item->id); ?>">
					<?php endif; ?> 
					
					<?php if ($this->params->get('display_home_alertimage','0')) : ?>
					<img class="eiko_icon " src="<?php echo JURI::Root();?><?php echo $item->alerting_image;?>" title="Alarmierung über: <?php echo $item->alerting;?>" />
					<?php endif;?>
					<?php if ($this->params->get('display_list_icon')) : ?>
					<img class="eiko_icon " src="<?php echo JURI::Root();?><?php echo $item->list_icon;?>" alt="<?php echo $item->list_icon;?>" title="Einsatzart: <?php echo $item->data1;?>"/>
					<?php endif;?>
					<?php if ($this->params->get('display_tickerkat_icon')) : ?>
					<img class="eiko_icon " src="<?php echo JURI::Root();?><?php echo $item->tickerkat_image;?>" alt="<?php echo $item->tickerkat;?>" title="Kategorie: <?php echo $item->tickerkat;?>"/>
					<?php endif;?>
					
					<span class="eiko_nowrap"><b><?php echo $item->data1; ?></b></span>
					<?php if ($this->params->get('display_home_links','1')) : ?>
					</a>
					<?php endif;?>
					<br/>
					<?php if ($item->address): ?>
					<?php //echo '<i class="icon-arrow-right"></i> '.$this->escape($item->address); ?>
					<?php echo ''.$this->escape($item->address); ?>
					<br/>
					<?php endif;?>

					

				</td>
				
           <?php if ($this->params->get('display_home_image')) : ?>
		   <td class="mobile_hide_480  eiko_td_einsatzbild_main_1">
		   <?php if ($item->image) : ?>
					<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'einsatzarchiv.', $canCheckin); ?>
					<?php endif; ?> 
					
					<?php if ($this->params->get('display_home_links_3','0')) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&id='.(int) $item->id); ?>">
					<?php endif; ?> 
					
		   <img  class="img-rounded eiko_img_einsatzbild_main_1" style="width:<?php echo $this->params->get('display_home_image_width','80px');?>;" src="<?php echo JURI::Root();?><?php echo $item->image;?>"/>
		   
					<?php if ($this->params->get('display_home_links_3','0')) : ?>
					</a>
					<?php endif; ?> 
           <?php endif;?>
		   
		   <?php if (!$item->image AND $this->params->get('display_home_image_nopic','0')) : ?>
					<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'einsatzarchiv.', $canCheckin); ?>
					<?php endif; ?> 
					
					<?php if ($this->params->get('display_home_links_3','0')) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&id='.(int) $item->id); ?>">
					<?php endif; ?> 

					<img  class="img-rounded eiko_img_einsatzbild_main_1" style="width:<?php echo $this->params->get('display_home_image_width','80px');?>;" src="<?php echo JURI::Root().'images/com_einsatzkomponente/einsatzbilder/nopic.png';?>"/>
					
					<?php if ($this->params->get('display_home_links_3','0')) : ?>
					</a>
					<?php endif;?>
           <?php endif;?>
		   
		   </td>
           <?php endif;?>
		<!--		<td>

					<?php echo $item->images; ?>
				</td> -->
				
				<td class="mobile_hide_480">

					<?php echo $item->summary; ?>
				</td>
				
				
           <?php if ($this->params->get('display_home_orga','0')) : ?>
           <?php 					
					$data = array();
					foreach(explode(',',$item->auswahl_orga) as $value):
						if($value){
							$data[] = '<!-- <span class="label label-info"> --!>'.$value.'<!-- </span>--!>'; 
						}
					endforeach;
					$auswahl_orga=  implode('</br>',$data); 
?>
		   <td nowrap class="eiko_td_organisationen_main_1 mobile_hide_480"> <?php echo $auswahl_orga;?></td>
           <?php endif;?>
		   
		<!--		<td>

					<?php echo $item->vehicles; ?>
				</td> -->
				
				<?php if ($this->params->get('display_home_counter','1')) : ?>
				<td class="mobile_hide_480 ">

					<?php echo $item->counter; ?>
				</td>
				<?php endif; ?>
				


            <?php if (isset($this->items[0]->id)): ?>
          <!--      <td class="center hidden-phone">
                    <?php echo (int)$item->id; ?>
                </td> -->
            <?php endif; ?>

			
            <?php if (isset($this->items[0]->state)): ?>
                <?php $class = ($canEdit || $canChange) ? 'active' : 'disabled'; ?>
                <td class="center">
					<?php if ($canEdit): ?>
                    <a class="btn btn-mini <?php echo $class; ?>"
                       href="<?php echo ($canChange) ? JRoute::_('index.php?option=com_einsatzkomponente&task=einsatzberichtform.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
                        <?php if ($item->state == 1): ?>
                            <i class="icon-publish"></i>
                        <?php else: ?>
                            <i class="icon-unpublish"></i>
                        <?php endif; ?>
                    </a>
					<?php endif; ?>
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=einsatzberichtform.edit&layout=edit&id=' . $item->id, true, 2); ?>" class="btn btn-mini eiko_action_button" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<button data-item-id="<?php echo $item->id; ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></button>
						<?php endif; ?>
                </td>
            <?php endif; ?>

        </tr>
		
		
    <?php endforeach; ?>
    </tbody>

<?php require_once JPATH_COMPONENT_SITE . '/views/einsatzarchiv/tmpl/main_layout_bottom.php'; ?>
