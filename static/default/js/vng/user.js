/* 
 * @namespace JS Framework
 * @author danhdvd <danhdvd@yahoo.com>
 * @copyright Đoàn Vũ Đình Danh 2012
 * 
 * @name Users
 * @type Javascript
 * @description check in user permission
 * @property Optional 1
 * 
 */

//config
//var SSO_LOGIN_URL = "https://sso2.zing.vn/index.php?method=login";
//var SSO_LOGOUT_URL = "http://sso2.zing.vn/?method=logout&return=" + CONFIG_URL_FULL;
//var SSO_LOGIN_URL_CONTROLL = CONFIG_URL_BASE + "users/ax_sso_login";
//var SSO_LOGIN_PID = 69;

//class
var USER_LOGIN_DIV_POPUP             = CONFIG_DVD_PREFIX + "user_login_div_pop";
var USER_LOGIN_BTN_POPUP             = CONFIG_DVD_PREFIX + "user_login_btn_pop";
var USER_LOGIN_BTN_CHECK             = CONFIG_DVD_PREFIX + "user_login_btn_check";
var USER_LOGIN_BTN_SUBMIT            = CONFIG_DVD_PREFIX + "user_login_btn_submit";
var USER_LOGIN_TXT_USERNAME          = CONFIG_DVD_PREFIX + "user_login_txt_username";
var USER_LOGIN_TXT_PASSWORD          = CONFIG_DVD_PREFIX + "user_login_txt_password";
var USER_LOGIN_BOX_REMEMBER          = CONFIG_DVD_PREFIX + "user_login_box_remember";
var USER_LOGIN_DIV_FORM                = "";

$(document).ready(function(){
    
    //check need login or not
    $(USER_LOGIN_BTN_CHECK).live('click', function(){
       
        if(dvd_can_submit)
        {
            if((dvd_is_login()) == false)
            {
                dvd_flag_login = false;
                
                if($(this).attr(CONFIG_ATTR_TYPE) == 'popup')
                {
                    $(USER_LOGIN_DIV_POPUP).fadeIn(1000);
                }
                else
                {
                    $('#btn_login_popup').click();
//                    jAlert("error", "Mời bạn đăng nhập!" , "Thông báo");
                }
                
                return false

            }
            else
            {
                dvd_flag_login = true;
                return true;
            }
        }
    })
   
  
        
//login by sso
//    $(POPUP_LOGIN_BTN).click(function(){
//            
//        if(_can_submit == true)
//        {
//            $.post(SSO_LOGIN_URL, {
//                u: $(POPUP_LOGIN_TXT_USERNAME).val(),
//                p: $(POPUP_LOGIN_TXT_PASSWORD).val(),
//                u1: SSO_LOGIN_URL_CONTROLL,
//                fp: SSO_LOGIN_URL_CONTROLL,
//                pid: SSO_LOGIN_PID               
//            }, function(data){
//                alert(data);
//            })
//        }
//
//    })
   
    
    
})
