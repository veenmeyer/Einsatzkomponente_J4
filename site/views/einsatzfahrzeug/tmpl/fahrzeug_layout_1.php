
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
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

require_once JPATH_SITE.'/administrator/components/com_einsatzkomponente/helpers/einsatzkomponente.php'; // Helper-class laden

$canEdit = Factory::getUser()->authorise('core.edit', 'com_einsatzkomponente.' . $this->item->id);
if (!$canEdit && Factory::getUser()->authorise('core.edit.own', 'com_einsatzkomponente' . $this->item->id)) {
	$canEdit = Factory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>


	<div class="item_fields">
		<table class="table">

<?php if ($this->params->get('show_fahrzeuge_beschreibung','1')) : ?>
<?php if( $this->item->desc) : ?>
<tr>
	<?php jimport('joomla.html.content'); ?>  
	<?php $Desc = JHTML::_('content.prepare', $this->item->desc); ?>
	<div class="eiko_orga_desc">
	<?php echo $Desc;?>
	<br/>

			</div>
</tr>
<?php endif;?>
<?php endif;?> 


<?php if (!$this->params->get('show_fahrzeuge_beschreibung','0')) : ?>



  <!-- Page Content -->
  
  <style>
  .portfolio-item {
    margin-bottom: 25px;
}
.img-responsive {padding-top:10px;}
  </style>
  
  
    <div class="container">

        <!-- Portfolio Item Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
								<?php if ($this->params->get('show_fahrzeuge_detail_1','1')) : ?>
								<?php //echo $this->item->detail1_label; ?>
								<?php echo $this->item->detail1; ?>
								<?php endif;?>

                    <small><?php echo $this->item->name; ?>
					</small>
                </h1>
				
					<?php if ($this->params->get('show_fahrzeuge_orga','1')) : ?>
					<h3><?php echo 'Organisation'; ?>:
					<?php echo $this->item->department; ?></h3>
					<?php endif;?>
				
            </div>
        </div>
        <!-- /.row -->

        <!-- Portfolio Item Row -->
        <div class="row">

            <div class="col-md-8">
                <img class="img-responsive" src="<?php echo $this->item->image;?>" alt="">
            </div>

            <div class="col-md-4">
			<?php if ($this->params->get('show_fahrzeuge_desc','1')) : ?>
			<?php if( $this->item->desc) : ?>
            <h3><?php echo Text::_('COM_EINSATZKOMPONENTE_DESC');?></h3>
			<p>
				<?php jimport('joomla.html.content'); ?>  
				<?php $Desc = JHTML::_('content.prepare', $this->item->desc); ?> 
				<div class="eiko_fahrzeuge_desc">
				<?php echo $Desc;?>
				</div>
			</p>
			<?php endif;?>
			<?php endif;?>
                <h3><?php echo Text::_('COM_EINSATZKOMPONENTE_WEITERE_DATEN');?></h3>
                <ul>
					<?php if ($this->params->get('show_fahrzeuge_detail_2','1')) : ?>
					<li><?php echo $this->item->detail2_label; ?>:
					<?php echo $this->item->detail2; ?></li>
					<?php endif;?>
					<?php if ($this->params->get('show_fahrzeuge_detail_3','1')) : ?>
					<li><?php echo $this->item->detail3_label; ?>:
					<?php echo $this->item->detail3; ?></li>
					<?php endif;?>
					
					<?php if ($this->params->get('show_fahrzeuge_detail_4','1')) : ?>
					<li><?php echo $this->item->detail4_label; ?>:
					<?php echo $this->item->detail4; ?></li>
					<?php endif;?>

					<?php if ($this->params->get('show_fahrzeuge_detail_5','1')) : ?>
					<li><?php echo $this->item->detail5_label; ?>:
					<?php echo $this->item->detail5; ?></li>
					<?php endif;?>

					<?php if ($this->params->get('show_fahrzeuge_detail_6','1')) : ?>
					<li><?php echo $this->item->detail6_label; ?>:
					<?php echo $this->item->detail6; ?></li>
					<?php endif;?>

					<?php if ($this->params->get('show_fahrzeuge_detail_7','1')) : ?>
					<li><?php echo $this->item->detail7_label; ?>:
					<?php echo $this->item->detail7; ?></li>
					<?php endif;?>
					<?php if ($this->params->get('show_fahrzeuge_link','1')) : ?>
					<?php if( $this->item->link) : ?>
					<?php echo '<br/><li>Link zur Webseite: <a href="" target="blank" class="eiko_fahrzeuge_link">'.$this->item->link.'</a></li>'; ?>
					<?php endif;?>
					<?php endif;?>
					
					<?php if ($this->params->get('show_fahrzeuge_einsatz','1')) : ?>
						<?php // letzter Einsatz   
						$database			= Factory::getDBO();
						$query = 'SELECT * FROM #__eiko_einsatzberichte WHERE FIND_IN_SET ("'.$this->item->id.'",vehicles) AND (state ="1" OR state="2") ORDER BY date1 DESC' ;
						$database->setQuery( $query );
						$total = $database->loadObjectList();
						?>
						<?php if ($total) : ?>
						<br/><li><?php echo Text::_('COM_EINSATZKOMPONENTE_LETZTER_EINTRAG');?> : 
						<a href="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&Itemid='.$this->params->get('homelink','').'&id='.(int) $total[0]->id); ?>"><?php echo date("d.m.Y", strtotime($total[0]->date1));?></a></li>
						<?php endif; ?>
					<?php endif;?>
<!-- Ausrüstung anzeigen -->  
<?php 	if ($this->params->get('show_fahrzeuge_ausruestung','0')) : 
		if(!$this->item->ausruestung == '') :
		if ($this->params->get('eiko','0')) : 
				$array = array();
				$ausruestung = '';
				$this->item->ausruestung = explode(",", $this->item->ausruestung);
				foreach((array)$this->item->ausruestung as $value): 
					if(!is_array($value)):
						$array[] = $value;
					endif;
				endforeach;
				$data = array();
				foreach($array as $value):
					$ausruestung .= '<li> '.$value.'</li>';
				endforeach; 
  
 ?>
 <br/><li><?php echo Text::_('COM_EINSATZKOMPONENTE_BELADUNG_AUSRUESTUNG');?>: <ul><?php echo $ausruestung;?></ul></li> 
 <?php endif;?>
 <?php endif;?>
 <?php endif;?>
<!-- Ausrüstung anzeigen ENDE -->  

                </ul>
            </div>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->	



<?php endif;?>

<input type="button" class="btn eiko_back_button" value="<?php echo Text::_('COM_EINSATZKOMPONENTE_ZURUECK');?>" onClick="history.back();">


		</table>
	</div>
	
	
	
	
	
	<br/>
	
	
	<?php if($canEdit): ?>
		<a class="btn" href="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=einsatzfahrzeugform.&id='.$this->item->id); ?>"><?php echo Text::_("COM_EINSATZKOMPONENTE_EDIT"); ?></a>
	<?php endif; ?>
								<?php //if(JFactory::getUser()->authorise('core.delete','com_einsatzkomponente.einsatzfahrzeug.'.$this->item->id)):?>
									<!-- <a class="btn" href="<?php echo Route::_('index.php?option=com_einsatzkomponente&task=einsatzfahrzeug.remove&id=' . $this->item->id, false, 2); ?>"><?php echo Text::_("JDELETE"); ?></a> -->
								<?php //endif; ?>
	<?php
else:
	echo Text::_('COM_EINSATZKOMPONENTE_ITEM_NOT_LOADED');
endif;?>













