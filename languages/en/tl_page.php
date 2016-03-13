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
 * Legends
 */
$GLOBALS['TL_LANG']['tl_page']['fastAccess_legend'] = 'Token-Settings (om_fastaccess)';


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_page']['fastAccess']       = array('Protect page with token', 'Protect this page with a token.');
$GLOBALS['TL_LANG']['tl_page']['fastAccessToken']  = array('Security token', 'The automatically generated security token');
$GLOBALS['TL_LANG']['tl_page']['fastAccessURL']    = array('URL', 'With this url you can connect to the protected page. This field is read-only.');
$GLOBALS['TL_LANG']['tl_page']['fastAccessJumpTo'] = array('Forwarding page', 'To this page will be forwarded if the specified token does not match.');
