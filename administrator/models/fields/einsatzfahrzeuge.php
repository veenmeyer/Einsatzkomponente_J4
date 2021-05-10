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
use Joomla\CMS\Form\FormHelper;


/**
 * Supports an HTML select list of categories
 */
class JFormFieldeinsatzfahrzeuge extends FormField
{
        /**
         * The form field type.
         *
         * @var         string
         * @since       1.6
         */
        protected $type = 'einsatzfahrzeuge';
        /**
         * Method to get the field input markup.
         *
         * @return      string  The field input markup.
         * @since       1.6
         */
        protected function getInput()
		{
                // Initialize variables.
				$selected = '';
                $html = array();
                $db = Factory::getDBO();
                $query = 'SELECT id,name from #__eiko_organisationen where state=1 order by ordering ASC';
                $db->setQuery($query);
                $orgs = $db->loadObjectList();
                $html[] .= '<select id="'.$this->id.'" name="'.$this->name.'[]" multiple>';
                $html[] .= '<option>&nbsp;</option>';
				
                foreach ($orgs as $org) {
                        $html[].='<optgroup label="'.$org->name.'">';
                        $query = 'SELECT id,name from #__eiko_fahrzeuge where department = "' . $org->id . '" and state = 1 order by ordering ASC';
                        $db->setQuery($query);
                        $vehicles = $db->loadObjectList();
                                foreach ($vehicles as $vehicle) {
									if ($this->value) : 
										foreach ($this->value as $value) {
										if ($value == $vehicle->id) : $selected = 'selected';endif;
										}
								   endif;
                                        $html[].='<option '.$selected.' value="'.$vehicle->id.'">' . $vehicle->name . ' ( '.$org->name.' ) </option>';
										$selected = '';
                                }
                        $html[].='</optgroup>';
                }

					
								
								
					$query = 'SELECT id,name from #__eiko_fahrzeuge where department = "" and state = 1 order by ordering ASC';
                        $db->setQuery($query);
                        if ($vehicles = $db->loadObjectList()) :
                        $html[].='<optgroup label="sonstige">';
                                foreach ($vehicles as $vehicle) {
										if ($this->value) : 
											foreach ($this->value as $value) {
											if ($value == $vehicle->id) : $selected = 'selected';endif;
											}
										endif;
                                        $html[].='<option '.$selected.' value="'.$vehicle->id.'">' . $vehicle->name . ' ( sonstige ) </option>';
										$selected = '';
                                }
                        $html[].='</optgroup>';
						endif;
						
                        $query = 'SELECT id,name from #__eiko_fahrzeuge where state = 2 order by ordering ASC';
                        $db->setQuery($query);
                        if ($vehicles = $db->loadObjectList()) :
                        $html[].='<optgroup label="außer Dienst">';
						
                                foreach ($vehicles as $vehicle) {
										if ($this->value) : 
											foreach ($this->value as $value) {
											if ($value == $vehicle->id) : $selected = 'selected';endif;
											}
										endif;
                                        $html[].='<option '.$selected.' value="'.$vehicle->id.'">' . $vehicle->name . ' - a.D. ( ID '.$vehicle->id.' ) </option>';
										$selected = '';
                                }
                        $html[].='</optgroup>'; 
						endif;
						
                $html[].='</select>';
                return implode($html);
        }
}
