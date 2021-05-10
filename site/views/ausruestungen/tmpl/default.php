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
use Joomla\CMS\HTML\HTMLHelper;

//Load admin language file
$lang = Factory::getLanguage();
$lang->load('com_einsatzkomponente', JPATH_ADMINISTRATOR);


JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user = Factory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canCreate = $user->authorise('core.create', 'com_einsatzkomponente');
$canEdit = $user->authorise('core.edit', 'com_einsatzkomponente');
$canCheckin = $user->authorise('core.manage', 'com_einsatzkomponente');
$canChange = $user->authorise('core.edit.state', 'com_einsatzkomponente');
$canDelete = $user->authorise('core.delete', 'com_einsatzkomponente');

require_once JPATH_SITE.'/administrator/components/com_einsatzkomponente/helpers/einsatzkomponente.php'; // Helper-class laden

if ($this->params->get('eiko')) : 
require_once JPATH_SITE.'/components/com_einsatzkomponente/views/ausruestungen/tmpl/'.$this->params->get('ausruestungen_layout','ausruestungen_layout_1.php').''; 
else:
echo 'Zur Zeit ist keine Anzeige möglich';
endif;

?> 