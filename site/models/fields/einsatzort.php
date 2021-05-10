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
use Joomla\CMS\Language\Text;
jimport('joomla.form.formfield');
/**
 * Supports an HTML select list of categories
 */
class FormFieldEinsatzort extends FormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'einsatzort';
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


$db = Factory::getDBO();
$query = 'SELECT id, address as title FROM #__eiko_einsatzberichte WHERE state="1" GROUP BY address ORDER BY address';
$db->setQuery($query);
$addressDb = $db->loadObjectList();

$params = ComponentHelper::getParams('com_einsatzkomponente');


//$db = JFactory::getDBO();
//$query = 'SELECT gmap_report_latitude, gmap_report_longitude FROM #__eiko_einsatzberichte WHERE id="'.$id.'" ';
//$db->setQuery($query);
//$coords = $db->loadObjectList(); 



$html[]='<input class="control-label" type="text"  name="'. $this->name.'"  id="'.$this->id.'"  value="'.$this->value.'" size="'.$this->size.'" />';
if ($params->get('gmap_action','0')) :
$html[]='<button type="button" id="Geocode" value="Geocode" onclick="codeAddress2()" class="hasTooltip control-label btn btn-danger btn-sm" title="Koordinaten automatisch anhand der Adresse ermitteln">Geocode</button>&nbsp;';
endif;

if (count($addressDb)):
$address[] = JHTML::_('select.option', '', Text::_('COM_EINSATZKOMPONENTE_ADRESSE_AUSWAEHLEN'), 'title', 'title');
$address = array_merge($address, $addressDb);
$html[].= '</br></br>'.JHTML::_('select.genericlist', $address, "adresse", 'onchange="changeText_einsatzort()" ', 'title', 'title', '0');

if ($params->get('gmap_action','0')) :
$html[].='<script type="text/javascript">
function changeText_einsatzort(){
    var userInput1 = document.getElementById("adresse").value;
	document.getElementById("'.$this->id.'").value = userInput1;
	codeAddress2();
}
</script>';
else:
$html[].='<script type="text/javascript">
function changeText_einsatzort(){
    var userInput1 = document.getElementById("adresse").value;
	document.getElementById("'.$this->id.'").value = userInput1;
	}
</script>';
endif;


endif;



        
		return implode($html);
	}
}