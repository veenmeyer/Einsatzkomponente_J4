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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormHelper;
/**
 * displays the information panel for SimpleCalendar
 *
 * @package     com_simplecalendar
 * @subpackage  settings
 * @since       3.0
 */
class JFormFieldInfo extends FormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since   3.0
	 */
	protected $type = 'info';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string	The field input markup.
	 * @since   3.0
	 */
	 
	 
	protected function getInput()
	{
		
		$document = Factory::getDocument();
		require_once JPATH_SITE.'/administrator/components/com_einsatzkomponente/helpers/einsatzkomponente.php'; 
		$html = array();
		$val ='';
		$val= EinsatzkomponenteHelper::getValidation();

		if ($val == '12') : 
		$html[] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><span aria-hidden="true" class="icon-cancel"></span> ' . Text::_('COM_EINSATZKOMPONENTE_OPTION_INFO_1');		
		else:
		$html[] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">x</button><span aria-hidden="true" class="icon-cancel"></span>'.JText::_('COM_EINSATZKOMPONENTE_OPTION_INFO_2').'</div><a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9HDFKVJSKSEFY"><div>'.JText::_('COM_EINSATZKOMPONENTE_OPTION_INFO_3').' : <img border=0  src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" /></div></a><br/><br/>
';		
		if ($val=='1') :	$html[] =  '<span class="label label-important">'.Text::_('COM_EINSATZKOMPONENTE_OPTION_INFO_4').'</span>'; 	endif;
		if ($val=='2') :	$html[] =  '<span class="label label-important">'.Text::_('COM_EINSATZKOMPONENTE_OPTION_INFO_5').'</span>'; 	endif; 
		endif;
		$html[] = '<h2>Einsatzkomponente Version 3.x</h2>';
		if ($val=='12') :	$html[] = '';
		else:
		$html[] = '<h3>'.Text::_('COM_EINSATZKOMPONENTE_OPTION_INFO_6').'</h3>';
		endif;
		$html[] = '<p></p>';
		$html[] = '<p><a href="https://www.einsatzkomponente.de/" target="_blank">Supportforum: https://www.einsatzkomponente.de/</a></p>';	
		return implode($html);
	}
}