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
use Joomla\CMS\Date\Date;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormHelper;
/**
 * Supports an HTML select list of categories
 */
class JFormFieldTimecreated extends FormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'timecreated';
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
        
		$time_created = $this->value;
		if (!$time_created) {
			$time_created = date("Y-m-d H:i:s");
			$html[] = '<input type="hidden" name="'.$this->name.'" value="'.$time_created.'" />';
		}
		$jdate = new Date($time_created);
		$pretty_date = $jdate->format(Text::_('DATE_FORMAT_LC2'));
		$html[] = "<div>".$pretty_date."</div>";
        
		return implode($html);
	}
}