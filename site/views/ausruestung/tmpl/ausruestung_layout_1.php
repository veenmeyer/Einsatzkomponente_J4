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
        <table class="table">
<tr>
			<td>
			<img class="img-rounded ftm_img_ausbildung_detail_1" style="float:right;margin-top:20px;margin-right:10px;margin-left:10px;width:250px;" src="<?php echo JURI::Root();?><?php echo $this->item->image;?>" title="<?php echo $this->item->name;?>"/>
			
			<?php if ($this->item->beschreibung) :?>
			<?php $this->item->beschreibung = str_replace('<hr id="system-readmore" />', "", $this->item->beschreibung); ?>

			<?php jimport('joomla.html.content'); ?>  
			<?php $Desc = JHTML::_('content.prepare', $this->item->beschreibung); ?>
			<?php echo $Desc; ?>
			<?php endif;?>
			</td>
</tr>
<tr>
			<td>
			<input style="float:left;" type="button" class="btn eiko_back_button" value="<?php echo JText::_('COM_EINSATZKOMPONENTE_ZURUECK');?>" onClick="history.back();">
			</td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn btn-warning" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=ausruestungform&id='.$this->item->id); ?>"><?php echo JText::_("COM_EINSATZKOMPONENTE_EDIT"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_einsatzkomponente.ausruestung.'.$this->item->id)):?>
									<a class="btn btn-danger" href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=ausruestung.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_EINSATZKOMPONENTE_LOESCHEN"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_EINSATZKOMPONENTE_ITEM_NOT_LOADED');
endif;
?>
