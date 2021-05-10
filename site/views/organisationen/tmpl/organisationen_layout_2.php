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
use Joomla\CMS\Router\Route;
require_once JPATH_SITE.'/administrator/components/com_einsatzkomponente/helpers/einsatzkomponente.php'; // Helper-class laden

?>


<table width="100%" class="table table-striped table-bordered" id="example" border="0" cellspacing="0" cellpadding="0">
    <!--<thead>
        <tr>
            <th width="">Organisation</th>
            <th width=""><?php echo $this->items[0]->detail2_label; ?></th>
        </tr>
        <tr><th colspan="6"><hr /></th></tr>
    </thead>-->
    
 <tbody>

<?php foreach ($this->items as $item) :?>
<?php if ($item->gmap_latitude >= '3') :?>
	<?php
	$orga_fahrzeuge = EinsatzkomponenteHelper::getOrga_fahrzeuge($item->id);  
	?>
        
	<tr>
    <td>    
 	<?php if ($this->params->get('display_orga_links','1')) :?>
           
		<a href="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=organisation&id=' . (int)$item->id); ?>"><?php echo $item->name; ?></a>
		<br/><?php echo $item->detail1; ?>
		<?php else: ?>	
    	<?php echo $item->name; ?>
        <br/><?php echo $item->detail1; ?>
		<?php endif; ?>
	</td>
    <td>
    <?php 
				$array = array();
				foreach((array)$orga_fahrzeuge as $value): 
					if(!is_array($value)):
						$array[] = $value;
					endif;
				endforeach; ?>
				<div class="items">
                <ul class="items_list">
                <?php foreach($array as $value): ?>
				<?php if ($value->state == '2'): $value->name = $value->name.' (a.D.)';endif;?>
				<li>
		<?php if ($this->params->get('display_orga_fhz_links','1')) :?>
					<?php if (!$value->link) :?>
					<a title ="<?php echo $value->detail2;?>" target="_self" href="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeug&Itemid='.$this->params->get('vehiclelink','').'&id=' . $value->id); ?>"><?php echo $value->name; ?></a>
					<?php else :?>
					<a title ="<?php echo $value->detail2;?>" target="_blank" href="<?php echo $value->link; ?>"><?php echo $value->name; ?></a>
					<?php endif; ?>		
                    <?php else: ?>	
                    <?php echo $value->name; ?>		
					<?php endif; ?>
				</li>
				<?php endforeach; ?>
				</ul> 
                </div>
    </td>
    </tr>
<?php endif;?>
<?php endforeach; ?>
        
</tbody>
<tfoot>
<?php if (!$this->params->get('eiko')) : ?>
        <tr><!-- Bitte das Copyright nicht entfernen. Danke. -->
            <th colspan="<?php echo $col;?>"><span class="copyright">Einsatzkomponente V<?php echo $this->version; ?>  (C) 2015 by Ralf Meyer ( <a class="copyright_link" href="http://einsatzkomponente.de" target="_blank">www.einsatzkomponente.de</a> )</span></th>
        </tr>
	<?php endif; ?>
</tfoot>

</table>



    <div class="pagination">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
