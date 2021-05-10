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
?>
<!--Page Heading-->
<?php if ($this->params->get('show_page_heading', 1)) : ?>
<div class="page-header">
<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
</div>
<?php endif;?>
<div class="items">
    <ul class="items_list">
        <?php $show = false; ?>
        <?php foreach ($this->items as $item) :?>
                
				<?php
					if($item->state == 1 || ($item->state == 0 && JFactory::getUser()->authorise('core.edit.own',' com_einsatzkomponente.organisation.'.$item->id))):
						$show = true;
						?>
							<li>
								<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=organisation&id=' . (int)$item->id); ?>"><?php echo $item->name; ?></a>
								<?php
									if(JFactory::getUser()->authorise('core.edit.state','com_einsatzkomponente.organisation'.$item->id)):
									?>
										<a href="javascript:document.getElementById('form-organisation-state-<?php echo $item->id; ?>').submit()"><?php if($item->state == 1):?>Unpublish<?php else:?>Publish<?php endif; ?></a>
										<form id="form-organisation-state-<?php echo $item->id ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=organisation.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="jform[ordering]" value="<?php echo $item->ordering; ?>" />
											<input type="hidden" name="jform[name]" value="<?php echo $item->name; ?>" />
											<input type="hidden" name="jform[detail1]" value="<?php echo $item->detail1; ?>" />
											<input type="hidden" name="jform[link]" value="<?php echo $item->link; ?>" />
											<input type="hidden" name="jform[gmap_latitude]" value="<?php echo $item->gmap_latitude; ?>" />
											<input type="hidden" name="jform[gmap_longitude]" value="<?php echo $item->gmap_longitude; ?>" />
											<input type="hidden" name="jform[ffw]" value="<?php echo $item->ffw; ?>" />
											<input type="hidden" name="jform[state]" value="<?php echo (int)!((int)$item->state); ?>" />
											<input type="hidden" name="option" value="com_einsatzkomponente" />
											<input type="hidden" name="task" value="organisation.save" />
											<?php echo JHtml::_('form.token'); ?>
										</form>
									<?php
									endif;
									if(JFactory::getUser()->authorise('core.delete','com_einsatzkomponente.organisation'.$item->id)):
									?>
										<a href="javascript:document.getElementById('form-organisation-delete-<?php echo $item->id; ?>').submit()">Delete</a>
										<form id="form-organisation-delete-<?php echo $item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=organisation.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="jform[ordering]" value="<?php echo $item->ordering; ?>" />
											<input type="hidden" name="jform[name]" value="<?php echo $item->name; ?>" />
											<input type="hidden" name="jform[detail1]" value="<?php echo $item->detail1; ?>" />
											<input type="hidden" name="jform[link]" value="<?php echo $item->link; ?>" />
											<input type="hidden" name="jform[gmap_latitude]" value="<?php echo $item->gmap_latitude; ?>" />
											<input type="hidden" name="jform[gmap_longitude]" value="<?php echo $item->gmap_longitude; ?>" />
											<input type="hidden" name="jform[ffw]" value="<?php echo $item->ffw; ?>" />
											<input type="hidden" name="jform[state]" value="<?php echo $item->state; ?>" />
											<input type="hidden" name="jform[created_by]" value="<?php echo $item->created_by; ?>" />
											<input type="hidden" name="option" value="com_einsatzkomponente" />
											<input type="hidden" name="task" value="organisation.remove" />
											<?php echo JHtml::_('form.token'); ?>
										</form>
									<?php
									endif;
								?>
							</li>
						<?php endif; ?>
        <?php endforeach; ?>
        <?php if(!$show): ?>
            There are no items in the list
        <?php endif; ?>
    </ul>
</div>
<?php if($show): ?>
    <div class="pagination">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>
