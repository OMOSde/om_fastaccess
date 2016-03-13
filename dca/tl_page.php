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
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][]  = 'fastAccess';
$GLOBALS['TL_DCA']['tl_page']['palettes']['regular']        .= ';{fastAccess_legend},fastAccess';


/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['fastAccess']   = 'fastAccessToken,fastAccessURL,fastAccessJumpTo';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['fastAccess'] = array (
  'label'                   => &$GLOBALS['TL_LANG']['tl_page']['fastAccess'],
  'inputType'               => 'checkbox',
  'eval'                    => array('submitOnChange'=>true),
  'sql'                     => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_page']['fields']['fastAccessToken'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_page']['fastAccessToken'],
  'inputType'               => 'text',
  'load_callback'           => array(array('tl_page_fastaccess', 'createToken')),
  'save_callback'           => array(array('tl_page_fastaccess', 'saveToken')),
  'wizard'                  => array(array('tl_page_fastaccess', 'createWizard')),   
  'eval'                    => array('maxlength'=>255, 'tl_class'=>'wizard'),
  'sql'                     => "varchar(100) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_page']['fields']['fastAccessURL'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_page']['fastAccessURL'],
  'inputType'               => 'text',
  'load_callback'           => array(array('tl_page_fastaccess', 'loadCallbackURL')),
  'eval'                    => array('readonly' => true, 'maxlength'=>255, 'tl_class'=>'long'),
  'sql'                     => "varchar(100) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_page']['fields']['fastAccessJumpTo'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_page']['fastAccessJumpTo'],
  'exclude'                 => true,
  'inputType'               => 'pageTree',
  'eval'                    => array('fieldType'=>'radio', 'mandatory' => true),
  'sql'                     => "int(10) unsigned NOT NULL default '0'"
);


/**
 * Javascript
 */
$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/om_fastaccess/assets/javascripts/AjaxOmFastAccess.js';


/**
 * Class tl_page_fastaccess
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  OMOS.de 2016 <http://www.omos.de>
 * @author     René Fehrmann <rene.fehrmann@omos.de>
 */
class tl_page_fastaccess extends Frontend
{ 
    /**
     * Callback on load
     */
    public function loadCallbackUrl($value, DataContainer $dc)
    {
        // get all pages
        $arrPages = $this->Database->prepare("SELECT * FROM tl_page")->execute()->fetchAllAssoc();
                               
        // create key based array
        foreach ($arrPages as $page)
        {
            $pages[$page['id']] = $page;
        }
                                   
        // find root page
        $rootId = $dc->activeRecord->id;
        while ($pages[$rootId]['type'] != 'root')
        {
            $rootId = $pages[$rootId]['pid'];
        }
    
        // create dns
        $strDns = ($pages[$rootId]['dns']) ? 'http://' . $pages[$rootId]['dns'] . '/' : $this->Environment->base;
    
        return  $strDns . $this->generateFrontendUrl($pages[$dc->activeRecord->id]) . '?token=' . $dc->activeRecord->fastAccessToken;
    }


    /**
     * Create wizard
     */
    public function createWizard()
    {
        return '<img src="system/modules/om_fastaccess/assets/icons/wizard.gif" onclick="AjaxOmFastAccess.createToken(\'' . $this->Environment->base . '\');" width="20" height="20" alt="" id="toggle_start" style="padding-left:4px; vertical-align: -6px; cursor: pointer; ">';
    }


    /**
     * Create a random token
     */
    public function createToken($varValue, DataContainer $dc)
    {
        if (!$varValue)
        {
            return md5(uniqid(mt_rand(), true));
        }
        return $varValue;
    }


    /**
     * Save a generated token
     */
    public function saveToken($varValue, DataContainer $dc)
    {
        return $varValue;
    }
}
