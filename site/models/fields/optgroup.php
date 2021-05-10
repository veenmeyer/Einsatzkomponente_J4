<?php
/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
defined('JPATH_BASE') or die;
jimport('joomla.form.formfield');
/**
 * Supports an HTML select list of categories
 */
class JFormFieldoptgroup extends JFormField
{
        /**
         * The form field type.
         *
         * @var         string
         * @since       1.6
         */
        protected $type = 'optgroup';
        /**
         * Method to get the field input markup.
         *
         * @return      string  The field input markup.
         * @since       1.6
         */
        protected function getInput()
        {
                // Initialize variables.
                $html = array();
                $db = JFactory::getDBO();
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
						
								if (count($vehicles) > 1) {
										$v = array();
										foreach ($vehicles as $vehicle) {
											$v[] .= $vehicle->id;
										}
                                        $html[].='<option value="'.implode(',',$v).'">'.$org->name .' ( alle Fahrzeuge)</option>';
								}

                                foreach ($vehicles as $vehicle) {
                                        $html[].='<option value="'.$vehicle->id.'">' . $vehicle->name . ' ( '.$org->name.' ) </option>';
                                }
                        $html[].='</optgroup>';
                }

						$query = 'SELECT id,name from #__eiko_fahrzeuge where department = "" and state = 1 order by ordering ASC';
                        $db->setQuery($query);
                        if ($vehicles = $db->loadObjectList()) :
                        $html[].='<optgroup label="sonstige">';
                                foreach ($vehicles as $vehicle) {
                                        $html[].='<option value="'.$vehicle->id.'">' . $vehicle->name . ' ( sonstige ) </option>';
                                }
                        $html[].='</optgroup>';
						endif;
						
                        $query = 'SELECT id,name from #__eiko_fahrzeuge where state = 2 order by ordering ASC';
                        $db->setQuery($query);
                        if ($vehicles = $db->loadObjectList()) :
                        $html[].='<optgroup label="außer Dienst">';
                                foreach ($vehicles as $vehicle) {
                                        $html[].='<option value="'.$vehicle->id.'">' . $vehicle->name . ' - a.D. ( ID '.$vehicle->id.' ) </option>';
                                }
                        $html[].='</optgroup>';
						endif;
						
                $html[].='</select>';
                return implode($html);
        }
}
