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
use Joomla\CMS\Factory;

//Load admin language file
$lang = Factory::getLanguage();
$lang->load('com_einsatzkomponente', JPATH_ADMINISTRATOR);


?>

<!--Page Heading-->
<?php if ($this->params->get('show_page_heading', 1)) : ?>
<div class="page-header eiko_header_main">
<h1 class="eiko_header_main_h1"> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1> 
</div>
<br/>
<?php endif;?>

<?php
require_once JPATH_SITE.'/components/com_einsatzkomponente/views/organisation/tmpl/'.$this->params->get('orga_detail_layout','organisation_layout_1.php').''; 


?> 