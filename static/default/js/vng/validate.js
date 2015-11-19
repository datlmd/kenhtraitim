/* 
 * @namespace JS Framework
 * @author danhdvd <danhdvd@yahoo.com>
 * @copyright Đoàn Vũ Đình Danh 2012
 * 
 * @name Validation
 * @type Javascript
 * @description validate all form inputs when submited
 * @property Optional 2
 * 
 */

//Constant
var VALID_DIV_FORM      = "";

var VALID_BTN_SUBMIT      = CONFIG_DVD_PREFIX + "valid_btn_submit";
var VALID_TXT_NUMBER      = CONFIG_DVD_PREFIX + "valid_txt_number";
var VALID_TXT_EMPTY       = CONFIG_DVD_PREFIX + "valid_txt_empty";
var VALID_TXT_EMAIL       = CONFIG_DVD_PREFIX + "valid_txt_email";
var VALID_TXT_PHONE       = CONFIG_DVD_PREFIX + "valid_txt_phone";
var VALID_TXT_DATE        = CONFIG_DVD_PREFIX + "valid_txt_date";
var VALID_DIV_ERROR       = CONFIG_DVD_PREFIX + "valid_div_error";
var VALID_TXT_MATCH       = CONFIG_DVD_PREFIX + "valid_txt_match";
var VALID_FILE_IMAGE      = CONFIG_DVD_PREFIX + "valid_file_image";

$(document).ready(function(){

    //add option 
    //$(OPT_BORDER_RADIUS).css('border-radius', '6px');
      
    $(VALID_BTN_SUBMIT).live('click', function(){
      
        //get form name
        //btn submit have to has attribute itemscope is class of parrent form
        VALID_DIV_FORM = "." + $(this).attr('ddiv');
        
        //clear error div
        $(VALID_DIV_FORM + " " + VALID_DIV_ERROR).html('');
      
        //check login
        if(dvd_is_login == false)
        {
            return;
        }
           
        var _errors = 0;
       
        //check empty
        var inputs = $(VALID_DIV_FORM + " " + VALID_TXT_EMPTY);
        
        inputs.each(function(){
                    
            var local_errors = 0;
            
            //check empty
            if(dvd_is_empty($.trim($(this).val()))) 
            {             
                local_errors++;
            }
            
            //check ajax in server
            if(!local_errors && $(this).attr(CONFIG_ATTR_AJAX))
            {
                //check sso
                var sso = $(this).attr(CONFIG_ATTR_SSO) == 1 ? true : false;
                var url = $(this).attr(CONFIG_ATTR_AJAX) + "/" + $(this).attr('name') + '/' + sso;       
                
                if(dvd_is_unique(url, $(this).val()) == 0)
                {
                    var error =  $(this).attr('name') + " đã tồn tại.<br/>";
                    error = dvd_upper_first_char(error);
                    $(VALID_DIV_FORM + " " + VALID_DIV_ERROR).html($(VALID_DIV_FORM + " " + VALID_DIV_ERROR).html() + error);
                    
                    local_errors++;
                }               
            }
            
            //check pattern
            if(!local_errors && $(this).attr(CONFIG_ATTR_PATTERN))
            {
                var patt = $(this).attr(CONFIG_ATTR_PATTERN);
                patt = new RegExp(patt);
                var input = $(this).val();
                if(!patt.test(input))
                {
                    local_errors++;
                }
            }
            
            //show error or success
            if(local_errors)
            {
                dvd_show_error($(this));
                    
                _errors++;
            }
            else
            {
                dvd_show_success($(this));
            }                  
        })
        
        //check number
        inputs = $(VALID_DIV_FORM + " " + VALID_TXT_NUMBER);
        
        inputs.each(function(){
            
            var local_errors = 0;
            
            //check empty
            if($(this).attr(CONFIG_ATTR_NULL) != 1)
            {
                if(dvd_is_empty($(this).val()) == true) 
                {
                    local_errors++;                 
                }
            }
            
            //check number
            if(!local_errors && dvd_is_number($(this).val()) == false) 
            {            
                local_errors++;
            }  
                
            //check ajax
            if(!local_errors && $(this).attr(CONFIG_ATTR_AJAX))
            {
                //check sso
                var sso = $(this).attr(CONFIG_ATTR_SSO) == 1 ? true : false;
                var url = $(this).attr(CONFIG_ATTR_AJAX) + "/" + $(this).attr('name') + '/' + sso;       
                
                if(dvd_is_unique(url, $(this).val()) == 0)
                {
                    var error =  $(this).attr('name') + " đã tồn tại.<br/>";
                    error = dvd_upper_first_char(error);
                    $(VALID_DIV_FORM + " " + VALID_DIV_ERROR).html($(VALID_DIV_FORM + " " + VALID_DIV_ERROR).html() + error);
                    
                    local_errors++;
                }             
            }         
            
            //show error or success
            if(local_errors)
            {
                dvd_show_error($(this));
                    
                _errors++;
            }
            else
            {
                dvd_show_success($(this));
            } 
        })
        
        //check email
        inputs = $(VALID_DIV_FORM + " " + VALID_TXT_EMAIL);
        
        inputs.each(function(){
            
            var local_errors = 0;
            
            //check empty
            if($(this).attr(CONFIG_ATTR_NULL) != 1)
            {
                if(dvd_is_empty($(this).val()) == true) 
                {             
                    local_errors++;
                }
            }
                
            //check email
            if(!local_errors && dvd_is_email($(this).val()) == false) {
              
                local_errors++;
            }
            
            if(!local_errors && $(this).attr(CONFIG_ATTR_AJAX))
            {
                //check sso
                var sso = $(this).attr(CONFIG_ATTR_SSO) == 1 ? true : false;
                var url = $(this).attr(CONFIG_ATTR_AJAX) + "/" + $(this).attr('name') + '/' + sso;       
                
                if(dvd_is_unique(url, $(this).val()) == 0)
                {
                    var error =  $(this).attr('name') + " đã tồn tại.<br/>";
                    error = dvd_upper_first_char(error);
                    $(VALID_DIV_FORM + " " + VALID_DIV_ERROR).html($(VALID_DIV_FORM + " " + VALID_DIV_ERROR).html() + error);
                    
                    local_errors++;
                }           
            }
            

            
            //show error or success
            if(local_errors)
            {
                dvd_show_error($(this));
                    
                _errors++;
            }
            else
            {
                dvd_show_success($(this));
            } 
        })
        
        //check phone
        inputs = $(VALID_DIV_FORM + " " + VALID_TXT_PHONE);
        
        inputs.each(function(){
            
            var local_errors = 0;
            
            //check empty
            if($(this).attr(CONFIG_ATTR_NULL) != 1)
            {
                if(dvd_is_empty($(this).val()) == true) {
              
                    local_errors++;
                }
            }
            
            //check phone
            if(!local_errors && dvd_is_phone($(this).val()) == false) {
              
                local_errors++;
            }
               
            //check ajax
            if(!local_errors && $(this).attr(CONFIG_ATTR_AJAX))
            {
                //check sso
                var sso = $(this).attr(CONFIG_ATTR_SSO) == 1 ? true : false;
                var url = $(this).attr(CONFIG_ATTR_AJAX) + "/" + $(this).attr('name') + '/' + sso;       
                
                if(dvd_is_unique(url, $(this).val()) == 0)
                {
                    var error =  $(this).attr('name') + " đã tồn tại.<br/>";
                    error = dvd_upper_first_char(error);
                    $(VALID_DIV_FORM + " " + VALID_DIV_ERROR).html($(VALID_DIV_FORM + " " + VALID_DIV_ERROR).html() + error);
                    
                    local_errors++;
                }
                
            }
            
            //show error or success
            if(local_errors)
            {
                dvd_show_error($(this));
                    
                _errors++;
            }
            else
            {
                dvd_show_success($(this));
            } 
                              
        })
        
        //check date
        inputs = $(VALID_DIV_FORM + " " + VALID_TXT_DATE);
        
        inputs.each(function(){
            
            var local_errors = 0;
            
            //check empty
            if($(this).attr(CONFIG_ATTR_NULL) != 1)
            {
                if(dvd_is_empty($(this).val()) == true) {
              
                    local_errors++;
                }
            }
          
         
            //check date
            if(!local_errors && dvd_is_date($(this).val()) == false) {
              
                local_errors++;
            }
           
            //show error or success
            if(local_errors)
            {
                dvd_show_error($(this));
                    
                _errors++;
            }
            else
            {
                dvd_show_success($(this));
            } 
                    
        })
        
        //check image
        inputs = $(VALID_DIV_FORM + " " + VALID_FILE_IMAGE);
        
        inputs.each(function(){
            
            //check empty
            if(dvd_is_empty($(this).val()) == true) {
              
                var object = $(this).attr(CONFIG_ATTR_OBJECT);
                object = $("#" + object);
                    
                dvd_show_error($(this));
                    
                _errors++;
            }
            else {
                dvd_show_success($(this));
            }
                    
        })
        
        //check match
        inputs = $(VALID_DIV_FORM + " " + VALID_TXT_MATCH);
        
        inputs.each(function(){
            
            var local_errors = 0;
            
            //check empty
            if($(this).attr(CONFIG_ATTR_NULL) != 1)
            {
                var object_match = $(this).attr(CONFIG_ATTR_OBJECT);
                var obj_val = $("#" + object_match).val();
                
                if(dvd_is_empty($(this).val()) == true) {
              
                    local_errors++;
                }
            }
                 
            //check match
            if(!local_errors && ($(this).val()) != obj_val)
            {
                var error = $(this).attr('name') + " không trùng.<br/>";
                error = dvd_upper_first_char(error);
                    
                $(VALID_DIV_FORM + " " + VALID_DIV_ERROR).html($(VALID_DIV_FORM + " " + VALID_DIV_ERROR).html() + error);
                    
                local_errors++;
            }
              
            //show error or success
            if(local_errors)
            {
                dvd_show_error($(this));
                    
                _errors++;
            }
            else
            {
                dvd_show_success($(this));
            } 
        })
        
        //check errors
        if(_errors == 0)
        {
            dvd_can_submit = true;
            
            if($(VALID_DIV_FORM).attr(CONFIG_ATTR_SUBMIT) == 1)
            {
                $(VALID_DIV_FORM).submit();
            }
                
            return;
        }
        else
        {
            dvd_can_submit = false;
            
            return false;
        }
        
       
    });  

})

