/**
 * Contao module om_fastaccess
 *
 * @copyright  OMOS.de 2016 <http://www.omos.de>
 * @author     René Fehrmann <rene.fehrmann@omos.de>
 * @package    om_fastaccess
 * @license    GPL v3.0
 */


/**
 * Class AjaxOmFastAccess
 *
 * @type {{createToken: Function}}
 */
var AjaxOmFastAccess =
{
    /**
     * Set a new request token
     * @param string
     */
    createToken: function(base)
    {
        if (window.XMLHttpRequest)
        {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            http=new XMLHttpRequest();
        }
        else
        {
            // code for IE6, IE5
            http=new ActiveXObject("Microsoft.XMLHTTP");
        }
    
        http.onreadystatechange=function()
        {
            if (http.readyState==4 && http.status==200)
            {
                arrUrl = document.getElementById("ctrl_fastAccessURL").value.split("?");
        
                document.getElementById("ctrl_fastAccessToken").value = http.responseText;
                document.getElementById("ctrl_fastAccessURL").value   = arrUrl[0] + "?token=" + http.responseText;
            }
        }
    
        // open and send with post header
        http.open("POST", base + "system/modules/om_fastaccess/assets/php/AjaxCreateToken.php", true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send();
    }
}


/**
 * Add event listener
 */
window.addEvent('domready', function()
{
    function addEvent( obj, type, fn )
    {
        if ( obj.attachEvent )
        {
            obj['e'+type+fn] = fn;
            obj[type+fn] = function(){obj['e'+type+fn]( window.event );}
            obj.attachEvent( 'on'+type, obj[type+fn] );
        } else
            obj.addEventListener( type, fn, false );
    }
  
    addEvent( document.getElementById('ctrl_fastAccessToken'), 'keyup', function()
    {
        arrUrl = document.getElementById("ctrl_fastAccessURL").value.split("?");
        document.getElementById("ctrl_fastAccessURL").value   = arrUrl[0] + "?token=" + document.getElementById('ctrl_fastAccessToken').value;
    });
});
