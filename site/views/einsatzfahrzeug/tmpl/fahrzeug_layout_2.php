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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
?>
<?php if( $this->item ) : ?>



<table class="fahrzeug_box_1 table-striped" cellpadding="2">
<tbody>

<tr class="fahrzeug_box_4">
<th class="fahrzeug_box_6" colspan="2">
<span class="fahrzeug_box_detail1"><?php echo $this->item->detail1; ?></span><br/>
<span class="fahrzeug_box_title"><?php echo $this->item->name; ?></span> 
</th>
</tr>

<tr class="fahrzeug_box_3">
<td colspan="2" align="center">
<p><img src="./<?php echo $this->item->image; ?>" alt="<?php echo $this->item->name; ?>" width="100%" class="eiko_fahrzeug_detail_image" /></p>
</td>
</tr>
<tr class="fahrzeug_box_5" ><th class="fahrzeug_box_2" colspan="2"><?php echo Text::_('Fahrzeugdaten');?></th></tr>
<?php if ($this->item->name) : ?>
<tr class="fahrzeug_box_3">
<td><strong>Abk&uuml;rzung:</strong></td>
<td><?php echo $this->item->name; ?></td> 
</tr>
<?php endif; ?>
<?php if ($this->item->detail1) : ?>
<tr class="fahrzeug_box_3">
<td><strong><?php echo $this->item->detail1_label; ?>:</strong></td>
<td><?php echo $this->item->detail1; ?></td> 
</tr>
<?php endif; ?>

<?php if ($this->params->get('show_fahrzeuge_orga','1')) : ?>
	<?php if ($this->item->department) : ?>
	<tr class="fahrzeug_box_3">
	<td><strong>Organisation:</strong></td>
	<td><?php echo $this->item->department; ?></td> 
	</tr>
	<?php endif; ?>
<?php endif; ?>

<?php if ($this->item->detail2) : ?>
<tr class="fahrzeug_box_3">
<td><strong><?php echo $this->item->detail2_label; ?>:</strong></td>
<td><?php echo $this->item->detail2; ?></td> 
</tr>
<?php endif; ?>
<?php if ($this->item->detail3) : ?>
<tr class="fahrzeug_box_3"> 
<td><strong><?php echo $this->item->detail3_label; ?>:</strong></td>
<td><?php echo $this->item->detail3; ?></td>
</tr>
<?php endif; ?>
<?php if ($this->item->detail4) : ?>
<tr class="fahrzeug_box_3">
<td><strong><?php echo $this->item->detail4_label; ?>:</strong></td>
<td><?php echo $this->item->detail4; ?></td>
</tr>
<?php endif; ?>
<?php if ($this->item->detail5) : ?>
<tr class="fahrzeug_box_3">
<td><strong><?php echo $this->item->detail5_label; ?>:</strong></td>
<td><?php echo $this->item->detail5; ?></td>
</tr>
<?php endif; ?>
<?php if ($this->item->detail7) : ?>
<tr class="fahrzeug_box_3">
<td><strong><?php echo $this->item->detail7_label; ?>:</strong></td>
<td><?php echo $this->item->detail7; ?></td>
</tr>
<?php endif; ?>


<?php if ($this->params->get('show_fahrzeuge_einsatz','1')) : ?>
	<?php // letzter Einsatz   
	$database			= Factory::getDBO();
	$query = 'SELECT * FROM #__eiko_einsatzberichte WHERE FIND_IN_SET ("'.$this->item->id.'",vehicles) AND (state ="1" OR state="2") ORDER BY date1 DESC' ;
	$database->setQuery( $query );
	$total = $database->loadObjectList();
	?>
	<?php if ($total) : ?>
	<tr class="fahrzeug_box_3">
	<td><strong>Letzter Eintrag:</strong></td>
	<td><a href="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&Itemid='.$this->params->get('homelink','').'&id='.(int) $total[0]->id); ?>"><?php echo date("d.m.Y", strtotime($total[0]->date1));?></a></td>
	</tr> 
	<?php endif; ?>
<?php endif; ?>

</tbody>
</table>
<!--<h4><span><?php echo $this->item->detail1; ?> <?php echo $this->item->name; ?></span></h4>-->
<br/>

<?php if ($this->params->get('show_fahrzeug_beschreibung','1')) : ?>
	<!--Einsatzbericht anzeigen mit Plugin-Support-->           
	<?php jimport('joomla.html.content'); ?>  
	<?php $Desc = JHTML::_('content.prepare', $this->item->desc); ?>
	<table class="fahrzeug_box_7"><tr><td><?php echo $Desc; ?></td></tr></table>
<?php endif; ?>

	<table class="fahrzeug_box_7">
	<tr><td>
		<input type="button" class="btn eiko_back_button" value="<?php echo Text::_('COM_EINSATZKOMPONENTE_ZURUECK');?>" onClick="history.back();">
	</td></tr>
	</table>
    
<?php else: ?>
    Could not load the item
<?php endif; ?>
<?php
/**
 * @version    CVS: 3.9
 * @package    Com_Einsatzkomponente
 * @author     Ralf Meyer <ralf.meyer@einsatzkomponente.de>
 * @copyright  Copyright (C) 2015. Alle Rechte vorbehalten.
 * @license    GNU General Public License Version 2 oder später; siehe LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

$canEdit = Factory::getUser()->authorise('core.edit', 'com_einsatzkomponente.' . $this->item->id);
if (!$canEdit && Factory::getUser()->authorise('core.edit.own', 'com_einsatzkomponente' . $this->item->id)) {
	$canEdit = Factory::getUser()->id == $this->item->created_by;
}
?>



<!--  Orignal Items deaktivert

<?php if ($this->item) : ?>

	<div class="item_fields">
		<table class="table">
			<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL1_LABEL'); ?></th>
			<td><?php echo $this->item->detail1_label; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL1'); ?></th>
			<td><?php echo $this->item->detail1; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL2_LABEL'); ?></th>
			<td><?php echo $this->item->detail2_label; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL2'); ?></th>
			<td><?php echo $this->item->detail2; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL3_LABEL'); ?></th>
			<td><?php echo $this->item->detail3_label; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL3'); ?></th>
			<td><?php echo $this->item->detail3; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL4_LABEL'); ?></th>
			<td><?php echo $this->item->detail4_label; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL4'); ?></th>
			<td><?php echo $this->item->detail4; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL5_LABEL'); ?></th>
			<td><?php echo $this->item->detail5_label; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL5'); ?></th>
			<td><?php echo $this->item->detail5; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL6_LABEL'); ?></th>
			<td><?php echo $this->item->detail6_label; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL6'); ?></th>
			<td><?php echo $this->item->detail6; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL7_LABEL'); ?></th>
			<td><?php echo $this->item->detail7_label; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DETAIL7'); ?></th>
			<td><?php echo $this->item->detail7; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DEPARTMENT'); ?></th>
			<td><?php echo $this->item->department; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_AUSRUESTUNG'); ?></th>
			<td><?php echo $this->item->ausruestung; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_LINK'); ?></th>
			<td><?php echo $this->item->link; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_IMAGE'); ?></th>
			<td><?php echo $this->item->image; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_DESC'); ?></th>
			<td><?php echo $this->item->desc; ?></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo Text::_('COM_EINSATZKOMPONENTE_FORM_LBL_EINSATZFAHRZEUG_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>

		</table>
	</div>
	<?php if($canEdit): ?>
		<a class="btn" href="<?php echo Route::_('index.php?option=com_einsatzkomponente&task=einsatzfahrzeug.edit&id='.$this->item->id); ?>"><?php echo Text::_("COM_EINSATZKOMPONENTE_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(Factory::getUser()->authorise('core.delete','com_einsatzkomponente.einsatzfahrzeug.'.$this->item->id)):?>
									<a class="btn" href="<?php echo Route::_('index.php?option=com_einsatzkomponente&task=einsatzfahrzeug.remove&id=' . $this->item->id, false, 2); ?>"><?php echo Text::_("COM_EINSATZKOMPONENTE_DELETE_ITEM"); ?></a>
								<?php endif; ?>
	<?php
else:
	echo Text::_('COM_EINSATZKOMPONENTE_ITEM_NOT_LOADED');
endif;
?>
-->
