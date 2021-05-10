<?php
/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
defined('JPATH_BASE') or die;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Form\FormHelper;
/**
 * Supports an HTML select list of categories
 */
class JFormFieldSummary extends FormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'summary';
	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		// Initialize variables.
		$html = array();
		$address = array();
        
$id = Factory::getApplication()->input->getVar('id', 0);

$params = ComponentHelper::getParams('com_einsatzkomponente');

$db = Factory::getDBO();
$query = 'SELECT id, summary as title FROM #__eiko_einsatzberichte WHERE state="1" GROUP BY summary ORDER BY summary';
$db->setQuery($query);
$arrayDb = $db->loadObjectList();

$html[]='<input class="control-label" type="text"  name="'. $this->name.'"  id="'.$this->id.'"  value="'.$this->value.'" size="'.$this->size.'" />';

if (count($arrayDb)):
$array[] = JHTML::_('select.option', '', 'Kurzbericht auswählen', 'title', 'title');
$array = array_merge($array, $arrayDb);
$html[].= '<br/><br/>'.JHTML::_('select.genericlist', $array, "kurzbericht", 'onchange="changeText_kurzbericht()" ', 'title', 'title', '0');

$html[].='<script type="text/javascript">
function changeText_kurzbericht(){
    var userInput1 = document.getElementById("kurzbericht").value;
	document.getElementById("'.$this->id.'").value = userInput1;
}
</script>';
endif;
        
		return implode($html);
	}
}