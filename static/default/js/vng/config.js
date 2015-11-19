/* 
 * @namespace JS Framework
 * @author danhdvd <danhdvd@yahoo.com>
 * @copyright Đoàn Vũ Đình Danh 2012
 * 
 * @name Config
 * @type Javascript
 * @description inlcude all config variables, constants, set up functions
 * @property Core 1
 */

//constanst class
var CONFIG_URL_CURRENT            = current_url;
var CONFIG_URL_REQUEST            = request_url;
var CONFIG_URL_BASE               = base_url;
var CONFIG_URL_FULL               = full_url;
var CONFIG_URL_STATIC             = static_url;
var CONFIG_URL_STATIC_FRONTEND    = static_frontend;
var CONFIG_URL_MEDIA              = media_url;
var CONFIG_URL_IMAGE              = image_url;
var CONFIG_URL_VIDEO              = video_url;

//var attribute
var CONFIG_ATTR_DIV               = "ddiv"
var CONFIG_ATTR_WIDTH             = "dwidth";
var CONFIG_ATTR_HEIGHT            = "dheight";
var CONFIG_ATTR_FILE              = "dfile";
var CONFIG_ATTR_IMAGE             = "dimage";
var CONFIG_ATTR_DATA              = "ddata";
var CONFIG_ATTR_LIVE              = "dlive";
var CONFIG_ATTR_UPDATE            = "dupdate";
var CONFIG_ATTR_PARAM             = "dparam";
var CONFIG_ATTR_AJAX              = "dajax";
var CONFIG_ATTR_SSO               = "dsso";
var CONFIG_ATTR_OBJECT            = "dobject";
var CONFIG_ATTR_PATTERN           = "dpatt"
var CONFIG_ATTR_NULL              = "dnull";
var CONFIG_ATTR_SUBMIT            = "dsubmit";
var CONFIG_ATTR_TYPE              = "dtype";
var CONFIG_ATTR_EXCEPT            = 'dexcept';

//config 
var CONFIG_DVD_PREFIX = ".vng_";

//global variables
var dvd_flag_login = true;
var dvd_can_submit = true;
var dvd_is_finish = true;
var dvd_is_iframe = false;
var dvd_ajax_async = true;

var dvd_error_color = 'red';
var dvd_success_color = 'green';

var dvd_comments_delay = 3;  //second
var dvd_comment_content_min = 2//chars
var dvd_comment_content_max = 500;

//set up config
if(dvd_ajax_async == false)
{
    $.ajaxSetup({
        async : false
    })
}