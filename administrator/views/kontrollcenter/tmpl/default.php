<?php
/**
 * @version     4.00.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2021 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

HTMLHelper::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$val= EinsatzkomponenteHelper::getValidation();

HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('bootstrap.renderModal', 'a.modal'); 
HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('formbehavior.chosen', 'select'); 
HTMLHelper::_('stylesheet','administrator/components/com_einsatzkomponente/assets/css/einsatzkomponente.css');
// Versions-Nummer 
$db = Factory::getDbo();
$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = "com_einsatzkomponente"');
$params = json_decode( $db->loadResult(), true );
$user	= Factory::getUser();
$userId	= $user->get('id');
?>

<?php
if (!empty($this->extra_sidebar)) {
    $this->sidebar .= $this->extra_sidebar;
}
?>
<form action="<?php echo Route::_('index.php?option=com_einsatzkomponente&view=kontrollcenter'); ?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php //echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>

	<div class="center">
		<?php 
			echo '<h2>'.Text::_('COM_EINSATZKOMPONENTE_KONTROLLCENTER_TITLE').' <span class="badge bg-secondary">Joomla 4</span></h2>';
			?>
	</div>
					
               
        
			  <div >
	    					<a class="btn" href="index.php?option=com_einsatzkomponente&view=einsatzberichte">
		    				<img style="width:50px;height:50px;" alt="<?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_EINSATZBERICHTE'); ?>" src="components/com_einsatzkomponente/assets/images/menu/liste.png" /><br/>
		    				<span style="font-size:11px;"><?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_EINSATZBERICHTE'); ?></span>
	    					</a>
							
	    					<a class="btn" href="index.php?option=com_einsatzkomponente&view=kategorien">
		    				<img style="width:50px;height:50px;" alt="<?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_KATEGORIEN'); ?>" src="components/com_einsatzkomponente/assets/images/menu/einsatzarten.png" /><br/>
		    				<span style="font-size:11px;"><?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_KATEGORIEN'); ?></span>
	    					</a>   						
						
	    					<a class="btn" href="index.php?option=com_einsatzkomponente&view=einsatzarten">
		    				<img style="width:50px;height:50px;" alt="<?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_EINSATZARTEN'); ?>" src="components/com_einsatzkomponente/assets/images/menu/einsatzarten.png" /><br/>
		    				<span style="font-size:11px;"><?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_EINSATZARTEN'); ?></span>
	    					</a>    						
						
	    					<a class="btn" href="index.php?option=com_einsatzkomponente&view=organisationen">
		    				<img style="width:50px;height:50px;" alt="<?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_ORGANISATIONEN'); ?>" src="components/com_einsatzkomponente/assets/images/menu/organisationen.png" /><br/>
		    				<span style="font-size:11px;"><?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_ORGANISATIONEN'); ?></span>
	    					</a>    						
						
	    					<a class="btn" href="index.php?option=com_einsatzkomponente&view=alarmierungsarten">
		    				<img style="width:50px;height:50px;" alt="<?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_ALARMIERUNGSARTEN'); ?>" src="components/com_einsatzkomponente/assets/images/menu/alarmierungsarten.png" /><br/>
		    				<span style="font-size:11px;"><?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_ALARMIERUNGSARTEN'); ?></span>
	    					</a>    						
						
	    					<a class="btn" href="index.php?option=com_einsatzkomponente&view=einsatzfahrzeuge">
		    				<img style="width:50px;height:50px;" alt="<?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_EINSATZFAHRZEUGE'); ?>" src="components/com_einsatzkomponente/assets/images/menu/einsatzfahrzeuge.png" /><br/>
		    				<span style="font-size:11px;"><?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_EINSATZFAHRZEUGE'); ?></span>
	    					</a>
    						
	    					<!--<a class="btn" href="index.php?option=com_einsatzkomponente&view=beispiel">
		    				<img  style="width:50px;height:50px;" alt="<?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_BEISPIEL'); ?>" src="components/com_einsatzkomponente/assets/images/menu/beispiel.png" /><br/>
		    				<span style="font-size:11px;"><?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_BEISPIEL'); ?></span>
	    					</a>-->
    					
	    					<a class="btn" href="index.php?option=com_einsatzkomponente&view=einsatzbildmanager">
		    				<img style="width:50px;height:50px;" alt="<?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_EINSATZBILDMANAGER'); ?>" src="components/com_einsatzkomponente/assets/images/menu/einsatzbildmanager.png" /><br/>
		    				<span style="font-size:11px;"><?php echo Text::_('COM_EINSATZKOMPONENTE_TITLE_EINSATZBILDMANAGER'); ?></span>
	    					</a>

	    					<a class="btn" href="index.php?option=com_config&view=component&component=com_einsatzkomponente">
		    				<img style="width:50px;height:50px;" alt="<?php echo Text::_('COM_EINSATZKOMPONENTE_OPTIONS'); ?>" src="components/com_einsatzkomponente/assets/images/menu/einstellungen.png" /><br/>
		    				<span style="font-size:11px;"><?php echo Text::_('COM_EINSATZKOMPONENTE_OPTIONS'); ?></span>
	    					</a>

				</div>
					
					
			<table class="table"> 
			<thead>
				<tr>
					<th>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>

<div class="span5">
					<div class="well well-small" style=" float:left;">
						<dl class="dl-horizontal">
							<dt>installierte Version:</dt>
							<dd><?php echo $params['version'];?>
							<button type="button" class="btn-sml btn-light" data-bs-toggle="modal" data-bs-target="#eiko-changelog">Changelog	</button>
							<?php if ($val) : ?>
							<?php echo '<span class="label label-success"> ( validiert ) </span>';?>
                            <?php else:?>
							<?php echo '<div class="alert alert-danger" role="alert"> ( nicht validiert ) siehe Optionen / Info </div>';?>
                            <?php endif;?> 
							</dd>
							<dt>verfügbare Version:</dt> <dd><iframe  frameborder="0" height="30px" width="250px" src="https://www.feuerwehr-veenhusen.de/images/einsatzkomponenteJ40/index.html" scrolling="no"></iframe></dd>						
								</br>
						
						
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal1">
						  Verfügbare Module ...
						</button>
						

							<hr>
							<dt>Release-Datum:</dt>
							<dd><?php echo $params['creationDate'];?></dd>
							<dt>Autor:</dt>
							<dd><?php echo $params['author'];?></dd>
							<dt>Autor-Email:</dt>
							<dd><?php echo $params['authorEmail'];?></dd>
							<dt>Copyright:</dt>
							<dd><?php echo $params['copyright'];?></dd>
							<dt>Lizenz:</dt>
							<dd>GNU General Public License version 2 or later </dd>
						</dl>
						<hr>
							<b>Premiumfunktionen (nur für Premium-User):</b></br>
							<?php if ($val) : ?>
							<?php echo '<span style="margin-bottom:5px;" class="label label-success">Mehrfachbild-Upload im Frontend-Edit</span></br>';?>
							<?php else:?>
							<?php echo '<span style="margin-bottom:5px;text-decoration: line-through;" class="label label-important">Mehrfach-Bildupload im Frontend-Edit</span></br>';?>
							<?php endif;?>
							<?php if ($this->params->get('eiko')) : ?>
							<?php echo '<span style="margin-bottom:5px;" class="label label-success">Option Ausrüstung</span></br>';?>
							<?php else:?>
							<?php echo '<span style="margin-bottom:5px;text-decoration: line-through;" class="label label-important">Option Ausrüstung</span></br>';?>
							<?php endif;?>
							<hr>
						<b>Informationen:</b></br>
						<a target="_blank" style="margin-bottom:5px;" style="margin-bottom:5px;" class="label label-info" href="https://www.einsatzkomponente.de">Download-Link Webseite</a> 
						<br/>
						<a target="_blank" style="margin-bottom:5px;" class="label label-info" href="https://github.com/veenmeyer/Einsatzkomponente">Link zu GitHub</a>			
					</br>
					




						<hr>
						<b>Info PHP-Funktionen:</b></br>
						
						<?php 
							if( ini_get('allow_url_fopen') ) {
								echo '<span class="label label-success">allow_url_fopen aktiv</span>';
								} else {
								echo '<span class="label label-important">allow_url_fopen deaktiviert</span>';
								}
						?>
						
						
</div> 
          

				
						
					</td>
                    
               </tr>
               
                
                <tr>
               		 <td>
						<div class="alert alert-block alert-info">
						<h4 style="margin-bottom:5px;">Hilfreiche Links</h4>
						<ul>
						<li>
						<a target="_blank" href="https://einsatzkomponente.de" style="text-decoration:underline">Supportforum für die Einsatzkomponente</a>
						</li>
						<li>
						<a target="_blank" href="https://joomla4.einsatzkomponente.de" style="text-decoration:underline">Testseite für die Einsatzkomponente V4.x für J4</a>
						</li>
						</ul>
						</div>
                  </td>
             </tr>
                
            </tbody>
            
		</table>
		<input type="hidden" name="task" value="" />
		<?php echo HTMLHelper::_('form.token'); ?>
	</div>
	
<div class="span4">
<div class="alert alert-info" style=" float:left;">
<a target="_blank" href="https://www.einsatzkomponente.de/index.php"><img src="<?php echo Uri::base(); ?>components/com_einsatzkomponente/assets/images/komponentenbanner.jpg" style="float:left; margin-right:20px; padding-right:20px;"/></a>
<span class="label label-important" style="padding: 5px 5px 5px 5px;font-size:larger;"><?php echo Text::_('COM_EINSATZKOMPONENTE_KONTROLLCENTER_PAYPAL_1');?></span><br/><br/> 
<span class="label label-important" style="padding: 5px 5px 5px 5px;font-size:larger;"><?php echo 'Bzw. Werde Premium-User';?></span><br/><br/>
<?php echo Text::_('COM_EINSATZKOMPONENTE_KONTROLLCENTER_PAYPAL_2');?>

<div><a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9HDFKVJSKSEFY"><span style="float:left;"><?php echo Text::_('COM_EINSATZKOMPONENTE_KONTROLLCENTER_SPENDEN_UEBER_PAYPAL');?>: <img border=0  src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" /></span></a>
</div>
<p class="alert alert-warning" style=" float:left;margin-top:10px;">PS: Ihr dürft auch gerne per PayPal <b>eine kleine monatliche Spende</b> einrichten.</p>


</div>
</div>

</form>     
	
<?php	
	function changelog($file, $onlyLast = false)
	{
		$ret = '';

		$lines = @file($file);

		if(empty($lines)) return $ret;

		array_shift($lines);

		foreach($lines as $line)
		{
			$line = trim($line);

			if(empty($line)) continue;

			$type = substr($line,0,1);

			switch($type)
			{
				case '=':
					break;
				case '-':
					$ret .= '<li><span style="font-size:8pt;color:#ff0000;">Removed:</span> '.substr($line, 1).'</li>';
					break;
				case '+':
					$ret .= '<li><span style="font-size:8pt;color:#ff0000;">Added:</span> '.substr($line, 1)."</li>";
					break;
				case '#':
					$ret .= '<li><span style="font-size:8pt;color:#00e600;">Bugfix:</span> '.substr($line, 1)."</li>";
					break;

				default:



					$ret .= $line;
					break;
			}
		}

		return $ret;
	}

	
?>

						<!-- Modal -->
						<div class="modal fade" id="eiko-changelog" tabindex="-1" aria-labelledby="eiko-changelogLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="eiko-changelogLabel">Changelog</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							  </div>
							  <div class="modal-body">
								<?php echo changelog (JPATH_COMPONENT_ADMINISTRATOR.'/CHANGELOG.php'); ?>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<!--	<button type="button" class="btn btn-primary">Save changes</button> -->
							  </div>
							</div>
						  </div>
						</div>


						<!-- Modal -->
						<div class="modal fade" id="Modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Verfügbare Module ...</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							  </div>
							  <div class="modal-body">
						<ul>
						<li><a href="https://einsatzkomponente.de/forum/index.php?thread/1225-mod-eiko-last-f%C3%BCr-j3-x/" target="_blank" class="">mod_eiko_last</a> (Modul zur Anzeige der letzten Einsätze auf einer Modulposition)</li>
						<li><a href="https://einsatzkomponente.de/forum/index.php?thread/1234-mod-eiko-chart-statistik-modul-als-kuchen-f%C3%BCr-j3-x/" target="_blank" class="">mod_eiko_chart</a> (Modul zur Anzeige einer Statistik in Kuchenform auf einer Modulposition)</li>
						<li><a href="https://einsatzkomponente.de/forum/index.php?thread/1228-mod-eiko-statistik-f%C3%BCr-j3-x/" target="_blank" class="">mod_eiko_statistik</a> (Modul zur Anzeige einer Statistik als Balkendiagramm auf einer Modulposition)</li>
						<li><a href="https://einsatzkomponente.de/forum/index.php?thread/1238-mod-eiko-melder-f%C3%BCr-j3-x/" target="_blank" class="">mod_eiko_melder (nur Premium User)</a> (Modul zur Anzeige des letzten Einsatzes auf einen Meldeempfänger)</li>
						<li><a href="https://einsatzkomponente.de/forum/index.php?thread/1235-mod-eiko-einsatzticker-f%C3%BCr-j3-x/" target="_blank" class="">mod_eiko_einsatzticker</a> (Modul zur Anzeige des letzten Einsatzes als Tickerlaufschrift)</li>
						</ul>
						<h4>Mehr Infos dazu auf <a href="https://www.einsatzkomponente.de/" target="_blank" class="">www.einsatzkomponente.de</a></h4>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<!--	<button type="button" class="btn btn-primary">Save changes</button> -->
							  </div>
							</div>
						  </div>
						</div>
