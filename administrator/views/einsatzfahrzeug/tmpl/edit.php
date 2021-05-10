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
$params = JComponentHelper::getParams('com_einsatzkomponente');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

$version = new JVersion;
if ($version->isCompatible('3.0')) :
JHtml::_('formbehavior.chosen', 'select');
endif;

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_einsatzkomponente/assets/css/einsatzkomponente.css');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'einsatzfahrzeug.cancel' || document.formvalidator.isValid(document.id('einsatzfahrzeug-form'))) {
			Joomla.submitform(task, document.getElementById('einsatzfahrzeug-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&layout=edit&id='.(int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="einsatzfahrzeug-form" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
            <fieldset class="adminform">
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail1_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail1'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail2_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail2'); ?></div>
			</div>
            
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail3_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail3'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail4_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail4'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail5_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail5'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail6_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail6'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls"><?php echo $this->form->getInput('detail7_label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail7'); ?></div>
			</div>
            
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('department'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('department'); ?></div>
			</div>
			<div class="control-group hide_ausruestung">
				<div class="control-label line"><?php echo $this->form->getLabel('ausruestung'); ?></div>
				<div class="controls hideme"><?php echo $this->form->getInput('ausruestung'); ?></div>
				<?php if (!$params->get('eiko','0')) : ?>
				<style>
				.hideme {display:none;}
				.line {text-decoration: line-through;}
				</style>
				<?php endif;?>
			</div>
				<?php if (!$params->get('display_detail_ausruestung','1')) : ?>
				<style>
				.hide_ausruestung {display:none;}
				</style>
				<?php endif;?>
			
			<?php
				foreach((array)$this->item->ausruestung as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="ausruestung" name="jform[ausruestunghidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>
			<script type="text/javascript">
				jQuery.noConflict();
				jQuery('input:hidden.ausruestung').each(function(){
					var name = jQuery(this).attr('name');
					if(name.indexOf('ausruestunghidden')){
						jQuery('#jform_ausruestung option[value="'+jQuery(this).val()+'"]').attr('selected',true);
					}
				});
			</script>			
   
                
		   
		   
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('link'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('link'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('image'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('image'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('desc'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('desc'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
			<!--<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>-->
				
            </fieldset>
    	</div>
        
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
        
    </div>
</form>