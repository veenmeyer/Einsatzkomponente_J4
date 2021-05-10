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
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\HTML\HTMLHelper;
//echo count ($this->items).' - '.count($this->all_items);
//print_r ($this->all_items);
?>
<!-- Das neueste kompilierte und minimierte CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> 

<style>
.container {} 
.eiko_icon {}
.eiko_img_einsatzbild_main_5 {max-height:200px;width:100%;}
.eiko_h2 {font-size:16px;font-weight:bolder;}
.einsatzlistefooter {width:100%;}
.pagination {display: block;}

</style>


<?php echo '<span class="mobile_hide_320">'.$this->modulepos_2.'</span>';?>

<form action="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=einsatzarchiv&Itemid='.$this->params->get('homelink','').''); ?>" method="post" name="adminForm" id="adminForm">

    <?php echo LayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>




  



  
      <div class="container-fluid">
	
	<?php 	$m ='';
			$y=''; //print_r ($this->items);
			$marker_colors = array();
			$o=0;
	?>
    <?php foreach ($this->items as $i => $item) : ?>


	
<?php $o++; ?>

        <!-- Example row of columns -->
	<?php if ($o=='1') { ?>	
        <div class="row-fluid">
	<?php } ?>
          <div class="col-md-4">
            <h2 class="eiko_h2">
					<?php if ($this->params->get('display_tickerkat_icon')) : ?>
					<img class="eiko_icon " src="<?php echo JURI::Root();?><?php echo $item->tickerkat_image;?>" alt="<?php echo $item->tickerkat;?>" title="Kategorie: <?php echo $item->tickerkat;?>"/>
					<?php endif;?>
			<?php echo $item->summary;?></h2>

			
		<?php $date_image = $this->params->get('display_home_date_image','1') ?>
           <?php if ($date_image == '0' || $date_image == '2') : ?>
               <p><i class="icon-calendar"></i> <?php echo date('d.m.Y', $item->date1); ?>
               <?php if ($date_image == '2') : ?>
               <i class="icon-clock"></i> <?php echo date('H:i', $item->date1); ?>Uhr</p>
               <?php endif; ?>
       <?php endif; ?>

	   
	   
					<!-- Einsatzbild --> 
           <?php if ($this->params->get('display_home_image')) : ?>
		   <p>
		   <?php if ($item->image) : ?>
					<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo HTMLHelper::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'einsatzarchiv.', $canCheckin); ?>
					<?php endif; ?> 
					
					<?php if ($this->params->get('display_home_links_3','0')) : ?>
					<a href="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&id='.(int) $item->id); ?>">
					<?php endif; ?> 

					<img  class="img-rounded eiko_img_einsatzbild_main_5" src="<?php echo JURI::Root();?><?php echo $item->image;?>"/>
					
					<?php if ($this->params->get('display_home_links_3','0')) : ?>
					</a>
					<?php endif;?>
           <?php endif;?>
		   <?php if (!$item->image AND $this->params->get('display_home_image_nopic','0')) : ?>
					<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo HTMLHelper::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'einsatzarchiv.', $canCheckin); ?>
					<?php endif; ?> 
					
					<?php if ($this->params->get('display_home_links_3','0')) : ?>
					<a href="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&id='.(int) $item->id); ?>">
					<?php endif; ?> 

					<img  class="img-rounded eiko_img_einsatzbild_main_5" src="<?php echo JURI::Root().'images/com_einsatzkomponente/einsatzbilder/nopic.png';?>"/>
					
					<?php if ($this->params->get('display_home_links_3','0')) : ?>
					</a>
					<?php endif;?>
           <?php endif;?>
		   </p>
		   
           <?php endif;?>
		   
		   
					<!-- Einsatzbild ENDE --> 

					
					
	   
		   <?php if ($item->desc) : ?>
			<?php jimport('joomla.html.content'); ?>  
			<?php $desc = strip_tags( $item->desc);?>
			<?php $Desc = JHTML::_('content.prepare', $desc); ?>
			<?php $Desc = (strlen($Desc) > '200') ? substr($Desc,0,strrpos(substr($Desc,0,'200'+1),' ')).' ...' : $Desc;?>
			<?php echo $Desc;?>
            <?php endif;?>
            <p><a class="btn btn-secondary" href="#" role="button">weitere Details &raquo;</a></p>
          </div>
	<?php if ($o=='3') {  $o=0; ?>	
        </div>
	<?php } ?>


	
	
    <?php endforeach; ?>

      </div> <!-- /container -->
	        <hr>
	
<table class="einsatzlistefooter">
<?php require_once JPATH_COMPONENT_SITE . '/views/einsatzarchiv/tmpl/main_layout_bottom.php'; ?>
