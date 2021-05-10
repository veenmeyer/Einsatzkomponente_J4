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
use Joomla\CMS\Router\Route;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

?>

<form action="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeuge&Itemid='.$this->params->get('vehiclelink','').''); ?>" method="post" name="adminForm" id="adminForm">

	<?php echo LayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
	<table class="table table-striped" id="einsatzfahrzeugList">
		<thead>
		<tr>
			<?php if (isset($this->items[0]->state)): ?>
				<th width="5%">
	<?php echo HTMLHelper::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
</th>
			<?php endif; ?>

							<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_NAME', 'a.name', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL1_LABEL', 'a.detail1_label', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL1', 'a.detail1', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL2_LABEL', 'a.detail2_label', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL2', 'a.detail2', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL3_LABEL', 'a.detail3_label', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL3', 'a.detail3', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL4_LABEL', 'a.detail4_label', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL4', 'a.detail4', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL5_LABEL', 'a.detail5_label', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL5', 'a.detail5', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL6_LABEL', 'a.detail6_label', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL6', 'a.detail6', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL7_LABEL', 'a.detail7_label', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DETAIL7', 'a.detail7', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DEPARTMENT', 'a.department', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_AUSRUESTUNG', 'a.ausruestung', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_LINK', 'a.link', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_IMAGE', 'a.image', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_DESC', 'a.desc', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo HTMLHelper::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_CREATED_BY', 'a.created_by', $listDirn, $listOrder); ?>
				</th>


			<?php if (isset($this->items[0]->id)): ?>
				<th width="1%" class="nowrap center hidden-phone">
					<?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
			<?php endif; ?>

							<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo Text::_('COM_EINSATZKOMPONENTE_EINSATZFAHRZEUGE_ACTIONS'); ?>
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
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_einsatzkomponente'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_einsatzkomponente')): ?>
					<?php $canEdit = Factory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">

				<?php if (isset($this->items[0]->state)) : ?>
					<?php $class = ($canEdit || $canChange) ? 'active' : 'disabled'; ?>
					<td class="center">
	<a class="btn btn-micro <?php echo $class; ?>" href="<?php echo ($canEdit || $canChange) ? Route::_('index.php?option=com_einsatzkomponente&task=einsatzfahrzeug.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
		<?php if ($item->state == 1): ?>
			<i class="icon-publish"></i>
		<?php else: ?>
			<i class="icon-unpublish"></i>
		<?php endif; ?>
	</a>
</td>
				<?php endif; ?>

								<td>
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo HTMLHelper::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'einsatzfahrzeuge.', $canCheckin); ?>
				<?php endif; ?>
				<a href="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeug&id='.(int) $item->id); ?>">
				<?php echo $this->escape($item->name); ?></a>
				</td>
				<td>

					<?php echo $item->detail1_label; ?>
				</td>
				<td>

					<?php echo $item->detail1; ?>
				</td>
				<td>

					<?php echo $item->detail2_label; ?>
				</td>
				<td>

					<?php echo $item->detail2; ?>
				</td>
				<td>

					<?php echo $item->detail3_label; ?>
				</td>
				<td>

					<?php echo $item->detail3; ?>
				</td>
				<td>

					<?php echo $item->detail4_label; ?>
				</td>
				<td>

					<?php echo $item->detail4; ?>
				</td>
				<td>

					<?php echo $item->detail5_label; ?>
				</td>
				<td>

					<?php echo $item->detail5; ?>
				</td>
				<td>

					<?php echo $item->detail6_label; ?>
				</td>
				<td>

					<?php echo $item->detail6; ?>
				</td>
				<td>

					<?php echo $item->detail7_label; ?>
				</td>
				<td>

					<?php echo $item->detail7; ?>
				</td>
				<td>

					<?php echo $item->department; ?>
				</td>
				<td>

					<?php echo $item->ausruestung; ?>
				</td>
				<td>

					<?php echo $item->link; ?>
				</td>
				<td>

					<?php echo $item->image; ?>
				</td>
				<td>

					<?php echo $item->desc; ?>
				</td>
				<td>

							<?php echo Factory::getUser($item->created_by)->name; ?>				</td>


				<?php if (isset($this->items[0]->id)): ?>
					<td class="center hidden-phone">
						<?php echo (int) $item->id; ?>
					</td>
				<?php endif; ?>

								<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo Route::_('index.php?option=com_einsatzkomponente&task=einsatzfahrzeugform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
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
		<a href="<?php echo Route::_('index.php?option=com_einsatzkomponente&task=einsatzfahrzeugform.edit&id=0', false, 2); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo Text::_('COM_EINSATZKOMPONENTE_ADD'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo HTMLHelper::_('form.token'); ?>
</form>

<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {
		var item_id = jQuery(this).attr('data-item-id');
		<?php if($canDelete) : ?>
		if (confirm("<?php echo Text::_('COM_EINSATZKOMPONENTE_WIRKLICH_LOESCHEN'); ?>")) {
			window.location.href = '<?php echo Route::_('index.php?option=com_einsatzkomponente&task=einsatzfahrzeugform.remove&id=', false, 2) ?>' + item_id;
		}
		<?php endif; ?>
	}
</script>


