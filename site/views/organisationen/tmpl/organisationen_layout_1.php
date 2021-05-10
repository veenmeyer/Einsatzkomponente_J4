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
//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_einsatzkomponente', JPATH_ADMINISTRATOR);



$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_einsatzkomponente');
$canEdit    = $user->authorise('core.edit', 'com_einsatzkomponente');
$canCheckin = $user->authorise('core.manage', 'com_einsatzkomponente');
$canChange  = $user->authorise('core.edit.state', 'com_einsatzkomponente');
$canDelete  = $user->authorise('core.delete', 'com_einsatzkomponente');

require_once JPATH_SITE.'/administrator/components/com_einsatzkomponente/helpers/einsatzkomponente.php'; // Helper-class laden

?>

<form action="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=organisationen&Itemid='.$this->params->get('orgalink','').''); ?>" method="post" name="adminForm" id="adminForm">

	<?php //echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
	<table class="table" id="organisationList">
		<thead>
		<tr>

							<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_ORGANISATIONEN_NAME', 'a.name', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_DESC', 'a.detail1', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  '', 'a.detail2', $listDirn, $listOrder); ?>
				</th>
				<th><?php echo JText::_('COM_EINSATZKOMPONENTE_LETZTER_EINTRAG'); ?></th>

							<?php if ($canEdit || $canDelete): ?>
					<th class="center">
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
            <th colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>"><span class="copyright">Einsatzkomponente V<?php echo $this->version; ?>  (C) 2016 by Ralf Meyer ( <a class="copyright_link" href="https://einsatzkomponente.de" target="_blank">www.einsatzkomponente.de</a> )</span></th>
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
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'organisationen.', $canCheckin); ?>
				<?php endif; ?>
				<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=organisation&id='.(int) $item->id); ?>">
				<?php echo $this->escape($item->name); ?></a>
				</td>
				<td>

					<?php echo $item->detail1; ?>
				</td>
				<td>

					<?php echo $item->detail2; ?>
				</td>
				
				<?php // letzter Einsatz   
				$database			= JFactory::getDBO();
				$query = 'SELECT * FROM #__eiko_einsatzberichte WHERE FIND_IN_SET ("'.$item->id.'",auswahl_orga) AND (state ="1" OR state="2") ORDER BY date1 DESC' ;
				$database->setQuery( $query );
				$total = $database->loadObjectList();
				?>
				<?php if ($total) : ?>
				<td><a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&Itemid='.$this->params->get('homelink','').'&id='.(int) $total[0]->id); ?>"><?php echo date("d.m.Y", strtotime($total[0]->date1));?></a></td>
				<?php else: ?>
				<td><?php echo '-'; ?></td>
				<?php endif;?>

				
								<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=organisationform.edit&id=' . (int) $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php //if ($canDelete): ?>
							<!--<button data-item-id="<?php echo $item->id; ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></button> -->
						<?php //endif; ?>
					</td>
				<?php endif; ?>

			</tr>
			
<?php if ($this->params->get('show_orga_fahrzeuge','1')) : ?>
<tr>
<td  style="border:0px !important;" colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
<?php
				$orga_fahrzeuge = EinsatzkomponenteHelper::getOrga_fahrzeuge($item->id);  
				$array = array();
				foreach((array)$orga_fahrzeuge as $value): 
					if(!is_array($value)):
						$array[] = $value;
					endif;
				endforeach; ?>
                <?php foreach($array as $value): ?>
				<?php if ($value->state == '2'): $value->name = $value->name.' (a.D.)';endif;?>
				
		<?php if ($this->params->get('display_orga_fhz_links','1')) :?>
					<?php if (!$value->link) :?>
					<a target="_self" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeug&Itemid='.$this->params->get('vehiclelink','').'&id=' . (int) $value->id); ?>">
					<img  class="img-rounded eiko_img_einsatzbild_main_1" style="margin-right:10px;width:<?php echo $this->params->get('display_home_image_width','80px');?>;" src="<?php echo JURI::Root();?><?php echo $value->image;?>" title="<?php echo $value->name;?>"/>
					</a>
					<?php else :?>
					<a target="_blank" href="<?php echo $value->link; ?>">
					<img  class="img-rounded eiko_img_einsatzbild_main_1" style="margin-right:10px;width:<?php echo $this->params->get('display_home_image_width','80px');?>;" src="<?php echo JURI::Root();?><?php echo $value->image;?>" title="<?php echo $value->name;?>"/>
					</a>
					<?php endif; ?>		
                    <?php else: ?>	
					<img  class="img-rounded eiko_img_einsatzbild_main_1" style="margin-right:10px;width:<?php echo $this->params->get('display_home_image_width','80px');?>;" src="<?php echo JURI::Root();?><?php echo $value->image;?>" title="<?php echo $value->name;?>"/>
					<?php endif; ?>
				<?php endforeach; ?>
</td>
</tr>
<?php endif;?>
			
		<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($canCreate) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=organisationform.edit&id=0', false, 2); ?>"
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
			window.location.href = '<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=organisationform.remove&id=', false, 2) ?>' + item_id;
		}
		<?php endif; ?>
	}
</script>


