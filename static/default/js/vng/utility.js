/* 
 * @namespace JS Framework
 * @author danhdvd <danhdvd@yahoo.com>
 * @copyright Đoàn Vũ Đình Danh 2012
 * 
 * @name Utility
 * @type Javascript
 * @description Support helpful utilities
 * @property Optional 6
 * 
 */

var UTIL_CLEAR_BTN = CONFIG_DVD_PREFIX + "util_clear_btn";
var UTIL_CLEAR_TXT = CONFIG_DVD_PREFIX + "util_clear_txt";

var UTIL_ENTER_BTN = CONFIG_DVD_PREFIX + "util_enter_btn";
var UTIL_ENTER_DIV = CONFIG_DVD_PREFIX + "util_enter_div";

var UTIL_FOCUS_TXT = CONFIG_DVD_PREFIX + "util_focus_txt";

$(document).ready(function(){
    
    //clear 
    $(UTIL_CLEAR_BTN).click(function(){
        
        var div = $(this).attr(CONFIG_ATTR_DIV);
        $(UTIL_CLEAR_TXT).each(function(){
            if($(this).attr(CONFIG_ATTR_DIV) == div)
            {
                $(this).val("");
            }
        })
    }) 
    
    //enter to click
    $(UTIL_ENTER_DIV).live('keypress', function(event) {

        if(event.keyCode == 13 && event.shiftKey)
        {
            
        }
        else if(event.which == 13) {          
          
            //not go to new line          
            //            event.preventDefault();
            $(UTIL_ENTER_DIV + " " + UTIL_ENTER_BTN).click();       
        }
    });
    
    //focus 
    $(UTIL_FOCUS_TXT).live( 'focus',function(e) {
                
        //get value
        var value = $(this).val();
        
        //get default value
        var default_value = $(this).attr(CONFIG_ATTR_DATA);
        
        if(default_value == value) 
            $(this).val('');
    });
    
    $(UTIL_FOCUS_TXT).live('focusout',function(e) {
        
        //get value
        var value = $(this).val();
        
        //get default value
        var default_value = $(this).attr(CONFIG_ATTR_DATA);
        
        //save defautl content
        var current_value = $(this).val();
        if(current_value == '')
            $(this).val(default_value);
    });
    
});

