<?php

/**
 * Contao module om_fastaccess
 *
 * @copyright  OMOS.de 2016 <http://www.omos.de>
 * @author     René Fehrmann <rene.fehrmann@omos.de>
 * @package    om_fastaccess
 * @license    GPL v3.0
 */

 
/**
 * Register hook to check fastaccess
 */
$GLOBALS['TL_HOOKS']['generatePage'][] = array('OmFastAccess', 'myGeneratePage');
