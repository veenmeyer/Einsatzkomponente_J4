<?php defined('_JEXEC') or die; 
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
?>
<tfoot>
  <!--Prüfen, ob Pagination angezeigt werden soll-->
  <?php if ($this->params->get('display_home_pagination')) : ?>
    <tr>
      <td colspan="<?php echo $eiko_col; ?>">
        <form action="#" method=post>
		
		<p class="counter float-end pt-3 pe-2">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
		
          <?php echo $this->pagination->getPagesLinks(); ?><!--Pagination anzeigen-->
        </form>
      </td>
    </tr>
  <?php endif;?><!--Prüfen, ob Pagination angezeigt werden soll   ENDE -->

  <?php if (!$this->params->get('eiko')) : ?>
    <tr><!-- Bitte das Copyright nicht entfernen. Danke. -->
      <td colspan="<?php echo $eiko_col; ?>">
        <span class="copyright">Einsatzkomponente V<?php echo $this->version; ?>  (C) 2020 by Ralf Meyer ( <a class="copyright_link" href="https://einsatzkomponente.de" target="_blank">www.einsatzkomponente.de</a> )</span>
      </td>
    </tr>
  <?php endif; ?>
</tfoot>

<input type="hidden" name="task" value=""/>
<input type="hidden" name="boxchecked" value="0"/>
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
<?php echo HTMLHelper::_('form.token'); ?>

</form>

<?php if ($this->params->get('gmap_action','0') != '0') :?>
<?php if ($this->params->get('display_home_map')) : ?>
  <tr>
    <td colspan="<?php echo $eiko_col;?>" class="eiko_td_gmap_main_1">
      <h4>Einsatzgebiet</h4>
	  
      <?php if ($this->params->get('gmap_action','0') == '1') :?>
        <div id="map-canvas" style="width:100%; height:<?php echo $this->params->get('home_map_height','300px');?>;">
          <noscript>Dieser Teil der Seite erfordert die JavaScript Unterstützung Ihres Browsers!</noscript>
        </div>
      <?php endif;?>
	  
      <?php if ($this->params->get('gmap_action','0') == '2') :?>
        <div id="map_canvas" style="width:100%; height:<?php echo $this->params->get('home_map_height','300px');?>;">
          <noscript>Dieser Teil der Seite erfordert die JavaScript Unterstützung Ihres Browsers!</noscript>
        </div>
			<?php OsmHelper::installOsmMap();?>
			<?php OsmHelper::callOsmMap($this->gmap_config->gmap_zoom_level,$this->gmap_config->start_lat,$this->gmap_config->start_lang); ?>
			
			<?php if ($this->params->get('display_home_missions','1')) :?>
			<?php if ($this->params->get('display_detail_map_for_only_user','0')) :?>
			<?php OsmHelper::addEinsatzorteMap($this->einsatzorte);?>
			<?php endif;?>
			<?php endif;?>
			<?php if ($this->params->get('display_home_organisationen','1')) :?>
			<?php OsmHelper::addOrganisationenMap($this->organisationen);?>
			<?php endif;?>
			<?php if ($this->params->get('display_home_einsatzgebiet','1')) :?>
			<?php OsmHelper::addPolygonMap($this->einsatzgebiet,'blue');?>
			<?php endif;?>

			<?php endif;?>
    </td>
  </tr>
<?php endif;?>
<?php endif;?>
</table>

<?php echo '<span class="mobile_hide_320">'.$this->modulepos_1.'</span>'; ?>

<script type="text/javascript">
jQuery(document).ready(function () {
    jQuery('.delete-button').click(deleteItem);
});

function deleteItem() {
    var item_id = jQuery(this).attr('data-item-id');
    if (confirm("<?php echo Text::_('COM_EINSATZKOMPONENTE_WIRKLICH_LOESCHEN'); ?>")) {
        window.location.href = '<?php echo Route::_('index.php?option=com_einsatzkomponente&task=einsatzberichtform.remove&id=', false, 2) ?>' + item_id;
    }
}
</script>

<?php /* create CSS rules for marker colors */
if ($this->params->get('display_home_marker','1') && !empty($marker_colors)) {
  JLoader::register('EinsatzkomponenteFrontendHelper', JPATH_COMPONENT_SITE . '/helpers/einsatzkomponente.php');
  $markers_css = '';
  foreach ($marker_colors as $id => $color) {
    $rgba = EinsatzkomponenteFrontendHelper::hex2rgba($color, 0.7);
    $markers_css .= '.eiko_td_marker_color_' . $id . ' {background-color: ' . $color . ';}' . "\n";
    $markers_css .= '.eiko_td_marker_gradient_' . $id . ' {background: linear-gradient(to bottom, ' . $rgba . ' 0%,rgba(125,185,232,0) 100%);}' . "\n";
  }
  Factory::getDocument()->addStyleDeclaration($markers_css);
}
?>
