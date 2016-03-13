<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao module om_fastaccess
 *
 * @copyright  OMOS.de 2016 <http://www.omos.de>
 * @author     René Fehrmann <rene.fehrmann@omos.de>
 * @package    om_fastaccess
 * @license    GPL v3.0
 */


/**
 * Class OmFastAccess
 *
 * @copyright  OMOS.de 2016 <http://www.omos.de>
 * @author     René Fehrmann <rene.fehrmann@omos.de>
 */
class OmFastAccess extends Frontend
{
    /**
     * HOOK
     *
     * @param PageModel $objPage
     * @param LayoutModel $objLayout
     * @param PageRegular $objPageRegular
     */
    public function myGeneratePage(PageModel $objPage, LayoutModel  $objLayout, PageRegular $objPageRegular)
    {
        if ($objPage->fastAccess && $objPage->fastAccessToken <> $this->Input->get('token'))
        {
            // get page model from jumpTo page
            $page = PageModel::findById($objPage->fastAccessJumpTo);
      
            // prevent redirect to same site
            if ($page->id != $objPage->id)
            {
                $this->redirect($this->generateFrontendUrl($page->row()));
            }
        }
    }
}
