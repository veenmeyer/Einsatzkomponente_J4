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
            <tr class="mobile_hide_480 ">
			
				<?php $eiko_col = 0;?>
				
				<?php if ($this->params->get('display_home_number','1') ) : ?>
				<th class='left'>
				<?php echo 'Nr.'; ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
				<?php endif;?>
				
				<th class='left'>
				<!--<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_DATE1', 'a.date1', $listDirn, $listOrder);?>-->
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_DATE1');?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
				
    			<th class='left'>
				<?php echo ''; ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
				
				
		<!--		<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_IMAGES', 'a.images', $listDirn, $listOrder); ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th> -->
				<th class='left mobile_hide_480'>
				<!--<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_SUMMARY', 'a.summary', $listDirn, $listOrder);?>-->
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_SUMMARY');?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
				<?php if ($this->params->get('display_home_orga','0')) : ?>
				<th class='left'>
				<!--<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_AUSWAHLORGA', 'a.auswahl_orga', $listDirn, $listOrder); ?>-->
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_AUSWAHLORGA');?>
				<?php $eiko_col = $eiko_col+1;?>
				</th> 
				<?php endif; ?>
				
           <?php if ($this->params->get('display_home_image')) : ?>
				<th class='left mobile_hide_480 '>
				<!--<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_IMAGE', 'a.image', $listDirn, $listOrder); ?>-->
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_IMAGE');?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
			<?php endif;?>
				
				<?php if ($this->params->get('display_home_presse','0') ) : ?>
				<th class='left'>
					<?php if ($this->params->get('presse_image','')) : ?>					
					<img class="eiko_icon_press" src="<?php echo JURI::Root();?><?php echo $this->params->get('presse_image','');?>" title="" />
					<?php else:?>
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_PRESSEBERICHT'); ?>
				<?php endif;?>
				<?php $eiko_col = $eiko_col+1;?>
				</th>
				<?php endif;?>
				
		<!--		<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_VEHICLES', 'a.vehicles', $listDirn, $listOrder); ?>
				<?php $eiko_col = $eiko_col+1;?>
				</th> -->
				<?php if ($this->params->get('display_home_counter','1')) : ?>
				<th class='left mobile_hide_480 '>
				<!--<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_ZUGRIFFE', 'a.counter', $listDirn, $listOrder); ?>-->
				<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_ZUGRIFFE');?>
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
        <tr class="eiko_action_button">
        <td colspan="<?php echo $eiko_col;?>">
        <a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzberichtform&layout=edit&id=0&addlink=1', false, 2); ?>"
           class="btn btn-success btn-small"><i
                class="icon-plus"></i> <?php echo JText::_('COM_EINSATZKOMPONENTE_ADD'); ?></a>
		</td></tr>
    <?php endif; ?>
    </thead>
	
    <tbody>
	
	<?php 	$m ='';
			$y=''; //print_r ($this->items);
			$marker_colors = array();
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
           <?php echo '<b>'.(new JDate)->monthToString($m).'</b>';?>
           <?php echo '</div>';?>
           </td></tr>
           <?php endif;?>
           <!--Anzeige des Monatsnamen ENDE-->

		   <tr class="row<?php echo $i % 2; ?>">

           <?php if ($this->params->get('display_home_number','1') ) : ?>
      <td class="mobile_hide_480 eiko_td_marker_main_1 eiko_td_marker_color_<?php echo $item->data1_id; ?>">
			<?php echo '<span style="white-space: nowrap;" class="eiko_span_marker_main_1">Nr. '.EinsatzkomponenteHelper::ermittle_einsatz_nummer($item->date1,$item->data1_id).'</span>';?> 
			</td>
           <?php endif;?>


          <?php $date_image = $this->params->get('display_home_date_image','1') ?>
          <?php if ($date_image == '0' || $date_image == '2') : ?>
            <td class="eiko_td_datum_main_1">
              <i class="icon-calendar"></i> <?php echo date('d.m.Y', $item->date1); ?>
              <?php if ($date_image == '2') : ?>
                <br /><i class="icon-clock"></i> <?php echo date('H:i', $item->date1); ?>Uhr
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
                <?php endif; ?>
              </div>
            </td>
          <?php endif; ?>

            	<td>
					<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'einsatzarchiv.', $canCheckin); ?>
					<?php endif; ?> 
					
					<?php if ($this->params->get('display_home_links_2','1')) : ?>
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
					
					<?php if ($this->params->get('display_home_links_2','1')) : ?>
					</a>
					<?php endif;?>
					
					<br/>
					<?php if ($item->address): ?>
					<?php echo '<i class="icon-location" ></i> '.$this->escape($item->address); ?>
					<br/>
					<?php endif;?>
					<!-- Einsatzstärke -->
					<?php if ($this->params->get('display_home_einsatzstaerke','1')) { ?>
					<?php if ($item->people) : $people = $item->people; endif;?>
					<?php if (!$item->people) : $people = '0'; endif;?>
		  			<?php $vehicles = explode (",",$item->vehicles);?>
					<?php $vehicles = count($vehicles); ?>
		  			<?php $auswahl_orga = explode (",",$item->auswahl_orga);?>
					<?php $auswahl_orga = count($auswahl_orga); ?>
					<?php $strength = ($people*$this->params->get('einsatzstaerke_people','0.5')) + ($vehicles*$this->params->get('einsatzstaerke_vehicles','2')) + ($auswahl_orga*$this->params->get('einsatzstaerke_orga','15')) ; ?>
					<div class="progress progress-danger progress-striped " style="margin-top:5px;margin-bottom:5px;color:#000000 !important;width:180px;" title="<?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZKRAFT'); ?>: <?php if ($auswahl_orga) :echo $auswahl_orga;?> <?php echo JText::_('COM_EINSATZKOMPONENTE_ORGANISATIONEN'); ?> //<?php endif;?> <?php if ($vehicles):echo $vehicles;?> <?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE'); ?> <?php endif;?><?php if ($people) :echo '// '.$people;?> Einsatzkräfte <?php endif;?>"> 
					<div class="bar" style="color:#000000 !important;width:<?php echo $strength;?>px"></div></div>
					<?php } ?>
					<!-- Einsatzstärke ENDE --> 
					
					<?php if ($this->params->get('display_home_info','1') or $this->params->get('display_home_links','1')) : ?>
					<div class="eiko_td_buttons_main_1">
					<?php endif;?>

					<!-- Button Kurzinfo --> 
					<?php if ($this->params->get('display_home_info','1')) : ?>
					<input type="button" class="btn btn-primary" onClick="jQuery.toggle<?php echo $item->id;?>(div<?php echo $item->id;?>)" value="<?php echo JTEXT::_('COM_EINSATZKOMPONENTE_KURZINFO');?>"></input>
					<script type="text/javascript">
					jQuery.toggle<?php echo $item->id;?> = function(query)
						{
						jQuery(query).slideToggle("5000");
						jQuery("#tr<?php echo $item->id;?>").fadeToggle("fast");
						}   
					</script>
					<?php endif;?>
					
					<!-- Button Detaillink --> 
					<?php if ($this->params->get('display_home_links','1')) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&id='.(int) $item->id); ?>" type="button" class="btn btn-primary"><?php echo JText::_('COM_EINSATZKOMPONENTE_DETAILS'); ?></a>	
					<?php endif;?>
					<br/>
				</td>
				

				
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
		   
					<!-- Einsatzbild --> 
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
					<?php endif;?>
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
		   
		   
					<!-- Einsatzbild ENDE --> 
		   
		   
		   
				<?php if ($this->params->get('display_home_presse','0')) : ?>
				<td class="mobile_hide_480 ">
					<?php if ($item->presse or $item->presse2 or $item->presse3) : ?>
					<?php echo ''.JText::_('COM_EINSATZKOMPONENTE_EINSATZBERICHTE_PRESSEBERICHT').''; ?>
					<?php endif;?>
				</td>
				<?php endif; ?>

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
                    <a class="btn btn-mini <?php echo $class; ?> eiko_action_button"
                       href="<?php echo ($canChange) ? JRoute::_('index.php?option=com_einsatzkomponente&task=einsatzberichtform.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
                        <?php if ($item->state == 1): ?>
                            <i class="icon-save"></i>
                        <?php else: ?>
                            <i class="icon-radio-unchecked"></i>
                        <?php endif; ?>
                    </a>
					<?php endif; ?>
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=einsatzberichtform.edit&layout=edit&id=' . $item->id, true, 2); ?>" class="btn btn-mini eiko_action_button" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<button data-item-id="<?php echo $item->id; ?>" class="btn btn-mini delete-button eiko_action_button" type="button"><i class="icon-trash" ></i></button>
						<?php endif; ?>
                </td>
            <?php endif; ?>

        </tr>
		
        <!-- Zusatzinformation Kurzinfo -->
		<?php if ($this->params->get('display_home_info','1')) : ?>
			<?php		
					$data = array();
					foreach(explode(',',$item->auswahl_orga) as $value):
						if($value){
							$data[] = '<!-- <span class="label label-info"> --!>'.$value.'<!-- </span>--!>'; 
						}
					endforeach;
					$auswahl_orga=  implode(' +++ ',$data); ?> 
					
            <tr id="tr<?php echo $item->id;?>" class="eiko_tr_zusatz_main_1" style=" display:none;" >
            <td class="eiko_td_marker_gradient_<?php echo $item->data1_id;?>">
            </td>
            <td colspan="<?php echo $eiko_col-1; ?>" class="eiko_td_zusatz_main_1">
			<div id ="div<?php echo $item->id;?>" style="display:none;">
            <h3 style="text-decoration:underline;"><?php echo JText::_('COM_EINSATZKOMPONENTE_ALARMIERUNGSZEIT');?> </h3><?php echo date('d.m.Y', $item->date1);?> um <?php echo date('H:i', $item->date1);?> Uhr
            <h3 style="text-decoration:underline;"><?php echo JText::_('COM_EINSATZKOMPONENTE_EINSATZKRAEFTE');?> </h3><?php echo $auswahl_orga;?><br/>
		   <?php if ($item->desc) : ?>
			<?php jimport('joomla.html.content'); ?>  
			<?php $Desc = JHTML::_('content.prepare', $item->desc); ?>
			<h3 style="text-decoration:underline;"><?php echo JText::_('COM_EINSATZKOMPONENTE_TITLE_MAIN_3');?> </h3><?php echo $Desc;?>
            <?php endif;?>
            <br /><input type="button" class="btn btn-info" onClick="jQuery.toggle<?php echo $item->id;?>(div<?php echo $item->id;?>)" value="<?php echo JText::_('COM_EINSATZKOMPONENTE_INFO_SCHLIESSEN');?>"></input>
					<?php if ($this->params->get('display_home_links','1')) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&id='.(int) $item->id); ?>" type="button" class="btn btn-primary"><?php echo JText::_('COM_EINSATZKOMPONENTE_DETAILS'); ?></a>	
					<?php endif;?>
           </div> 
           </td>
           </tr>
	<?php endif;?>
     <!-- Zusatzinformation Kurzinfo ENDE -->

      <?php $marker_colors[$item->data1_id] = $item->marker; //add marker color to array to create CSS from ?>

    <?php endforeach; ?>
    </tbody>

<?php require_once JPATH_COMPONENT_SITE . '/views/einsatzarchiv/tmpl/main_layout_bottom.php'; ?>
