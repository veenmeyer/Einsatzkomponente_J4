<?php

/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
defined('_JEXEC') or die;


use \Joomla\CMS\Factory;

class EinsatzkomponenteFrontendHelper {

  public static function hex2rgba($color, $opacity = false) {  // Farbe von HEX zu RGBA umwandeln
    $default = 'rgb(0,0,0)';
    //Return default if no color provided
    if(empty($color))
      return $default;
      //Sanitize $color if "#" is provided
    if ($color[0] == '#' ) {
      $color = substr( $color, 1 );
    }
    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
      $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
      $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
      return $default;
    }
    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);
    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
      if (abs($opacity) > 1)
        $opacity = 1.0;
      $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
      $output = 'rgb('.implode(",",$rgb).')';
    }
    //Return rgb(a) color string
    return $output;
  }
  

  
  
}
