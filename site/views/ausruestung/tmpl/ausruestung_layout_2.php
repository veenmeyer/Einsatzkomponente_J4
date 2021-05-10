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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_einsatzkomponente.' . $this->item->id);
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_einsatzkomponente' . $this->item->id)) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

    <div class="item_fields">
        <table class="table eiko_table_ausruestung">
            <tr>
			<th><?php echo JText::_('COM_EINSATZKOMPONENTE_FORM_LBL_AUSRUESTUNG_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EINSATZKOMPONENTE_FORM_LBL_AUSRUESTUNG_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EINSATZKOMPONENTE_FORM_LBL_AUSRUESTUNG_IMAGE'); ?></th>
			<td><img src="<?php echo $this->item->image; ?>" alt="<?php echo $this->item->name; ?>" style="width: 100%;" </td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EINSATZKOMPONENTE_FORM_LBL_AUSRUESTUNG_BESCHREIBUNG'); ?></th>
			<td><?php echo $this->item->beschreibung; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EINSATZKOMPONENTE_FORM_LBL_AUSRUESTUNG_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EINSATZKOMPONENTE_FORM_LBL_AUSRUESTUNG_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=ausruestungform&id='.$this->item->id); ?>"><?php echo JText::_("Bearbeiten"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_einsatzkomponente.ausruestung.'.$this->item->id)):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=ausruestung.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("Löschen"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_EINSATZKOMPONENTE_ITEM_NOT_LOADED');
endif;
?>
