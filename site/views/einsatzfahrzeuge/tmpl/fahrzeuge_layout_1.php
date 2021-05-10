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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');


?>

<form action="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeuge&Itemid='.$this->params->get('vehiclelink','').''); ?>" method="post" name="adminForm" id="adminForm">

	<?php //echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
	<table class="table" id="fahrzeugList">
		<thead>
		<tr>

		<th>
		</th>
							<th class="eiko_einsatzfahrzeug_name">
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_NAME', 'a.name', $listDirn, $listOrder); ?>
				</th>
				
				<?php if ($this->params->get('show_fahrzeuge_detail1','1')) : ?>
				<th class="eiko_einsatzfahrzeug_beschreibung">
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_BESCHREIBUNG', 'a.detail1', $listDirn, $listOrder); ?>
				</th>
				<?php endif;?>
	
				<?php if ($this->params->get('show_fahrzeuge_detail2','1')) : ?>
				<th class="eiko_einsatzfahrzeug_detail2  mobile_hide_480">
				<?php echo JHtml::_('grid.sort',  '', 'a.detail2', $listDirn, $listOrder); ?>
				</th>
				<?php endif;?>
				
				<?php if ($this->params->get('show_fahrzeuge_einsatz','1')) : ?>
				<th  class="eiko_einsatzfahrzeug_letzter  mobile_hide_480"
				><?php echo JText::_('COM_EINSATZKOMPONENTE_LETZTER_EINTRAG');?>
				</th>
				<?php endif; ?>
				
				<?php if ($this->params->get('show_fahrzeuge_orga','1')) : ?>
				<th  class="eiko_einsatzfahrzeug_organisation  mobile_hide_480">
				<?php echo JText::_('COM_EINSATZKOMPONENTE_ORGANISATION');?>
				</th>
				<?php endif;?>

							<?php if ($canEdit || $canDelete): ?>
					<th class="eiko_admin_action center">
				<?php echo JText::_('COM_EINSATZKOMPONENTE_ADMIN_ACTION'); ?>
				</th>
				<?php endif; ?>

		</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
<?php if (!$this->params->get('eiko')) : ?>
        <tr><!-- Bitte das Copyright nicht entfernen. Danke. -->
            <th colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>"><span class="copyright">Einsatzkomponente V<?php echo $this->version; ?>  (C) 2018 by Ralf Meyer ( <a class="copyright_link" href="https://einsatzkomponente.de" target="_blank">www.einsatzkomponente.de</a> )</span></th>
        </tr>
	<?php endif; ?>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) : ?> 
			<?php $canEdit = $user->authorise('core.edit', 'com_einsatzkomponente'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_einsatzkomponente')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">

				<td>
					<img  class="img-rounded eiko_img_einsatzbild_main_1" style="margin-right:10px;width:<?php echo $this->params->get('display_home_image_width','80px');?>;" src="<?php echo JURI::Root();?><?php echo $item->image;?>" title="<?php echo $item->name;?>"/>

				</td>
				
				<td class="eiko_checkout">
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'einsatzfahrzeuge.', $canCheckin); ?>
				<?php endif; ?>
				<a class="eiko_fahrzeug_link" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeug&id='.(int) $item->id); ?>">
				<?php echo $this->escape($item->name); ?></a>
				</td>
				
				<?php if ($this->params->get('show_fahrzeuge_detail1','1')) : ?>
					<td class="eiko_fahrzeug_detail1">
						<?php echo $item->detail1; ?>
					</td>
				<?php endif;?>
				
				<?php if ($this->params->get('show_fahrzeuge_detail2','1')) : ?>
					<td class="eiko_fahrzeug_detail2  mobile_hide_480">

						<?php echo $item->detail2; ?>
					</td>
				<?php endif;?>
				
				<?php if ($this->params->get('show_fahrzeuge_einsatz','1')) : ?>
					<?php // letzter Einsatz   
					$database			= JFactory::getDBO();
					$query = 'SELECT * FROM #__eiko_einsatzberichte WHERE FIND_IN_SET ("'.$item->id.'",vehicles) AND (state ="1" OR state="2") ORDER BY date1 DESC' ;
					$database->setQuery( $query );
					$total = $database->loadObjectList();
					?>
					<?php if ($total) : ?>
					<td  class="eiko_fahrzeug_letzter_einsatz  mobile_hide_480"><a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&Itemid='.$this->params->get('homelink','').'&id='.(int) $total[0]->id); ?>"><?php echo date("d.m.Y", strtotime($total[0]->date1));?></a></td>
					<?php else: ?>
					<td><?php echo '-'; ?></td>
					<?php endif;?>
				<?php endif;?>
				
           <?php if ($this->params->get('show_fahrzeuge_orga','1')) : ?>
           <?php 					
					$data = array();
					foreach(explode(',',$item->department) as $value):
						if($value){
							$data[] = '<!-- <span class="label label-info"> --!>'.$value.'<!-- </span>--!>'; 
						}
					endforeach;
					$department=  implode('</br>',$data); 
?>
		   <td nowrap class="eiko_td_organisationen_main_1 mobile_hide_480"> <?php echo $department;?></td>
           <?php endif;?>
				
				
								<?php if ($canEdit || $canDelete): ?>
					<td class="center eiko_admin_action">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=einsatzfahrzeugform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<button data-item-id="<?php echo $item->id; ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></button>
						<?php endif; ?>
					</td>
				<?php endif; ?>

			</tr>
			
			
		<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($canCreate) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=einsatzfahrzeugform.edit&id=0', false, 2); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo JText::_('COM_EINSATZKOMPONENTE_ADD'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {
		var item_id = jQuery(this).attr('data-item-id');
		<?php if($canDelete) : ?>
		if (confirm("<?php echo JText::_('COM_EINSATZKOMPONENTE_WIRKLICH_LOESCHEN'); ?>")) {
			window.location.href = '<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=einsatzfahrzeugform.remove&id=', false, 2) ?>' + item_id;
		}
		<?php endif; ?>
	}
</script>


