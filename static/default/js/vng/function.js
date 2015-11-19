/* 
 * @namespace JS Framework
 * @author danhdvd <danhdvd@yahoo.com>
 * @copyright Đoàn Vũ Đình Danh 2012
 * 
 * @name Functions
 * @type Javascript
 * @description inlcude all core support functions
 * @property Core 2
 * 
 */

//check delay
function dvd_check_delay(last, delay)
{
    var now = new Date();
    
    var real_delay = now.getTime() - last.getTime();
    
    //get miliseconds
    delay = delay * 1000;
    
    if(delay <= real_delay)
        return true;
    else
        return false;
}

//check length
function dvd_check_length(txt, min_length, max_length)
{
    if(min_length)
    {
        if(txt.length < min_length)
        {
            return false;
        }
    }
    
    if(max_length)
    {
        if(txt.length > max_length)
        {
            return false;
        }
    }
        
    return true;
}

//show error
function dvd_show_error(obj)
{
    obj.css('border', '1px solid ' + dvd_error_color)
              
    obj.effect('highlight',{
        times:4
    },1000);
    
}

//show success
function dvd_show_success(obj)
{
    obj.css('border', '1px solid ' + dvd_success_color);
}

//check user login or not

function dvd_is_login()
{
    //config
    var url_check_login = CONFIG_URL_BASE + "users/is_login";
    var is_login = true;
        
    jQuery.ajaxSetup({
        async:false
    });
    $.get(url_check_login,function(data){
        if(data == 0)
        {
            is_login = false;
        }
    });
        
    if(is_login == false)
    {
        return false;
    }
    return true;
}

//check element exist or not
function dvd_is_exist(obj) {
    if(obj.length > 0)
        return true;
    return false;
}

function dvd_is_empty(input)
{
    if(input == "")
        return true;
    return false;
}

function dvd_is_number(input)
{
    if(dvd_is_empty(input))
    {
        return true;
    }
    
    if(isNaN(input) == false)
        return true;
    return false;
}

function dvd_is_email(input)
{
        
    if(dvd_is_empty(input))
    {
        return true;
    }
    
    //var pat = /^\w+@([a-zA-Z_]\.)+?(\.[a-zA-Z]{2,4})+$/; 
    var pat = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; 
   
    if(pat.test(input) == false)
    {
        return false;
    }
    else
    {
        return true;
    }
    
}

function dvd_is_phone(input) {
    
    if(dvd_is_empty(input))
    {
        return true;
    }
    
    var pat = /^[0-9]+[0-9\.\-\s]+[0-9]+$/; 
        
        
    if(pat.test(input) == false || input.length < 6 || input.legth > 15)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function dvd_is_unique(url_check_unique, input) {
    
    $.ajaxSetup({
        async: false
    });
    
    var result = 0;
    
    $.post(url_check_unique, {
        input: input
    } , function(data){
        result= data;
    //return data;
    });
    
    return (result);

}


// dd-mm-yyyy
//type: 1.dd-mm-yyyy; 2.mm-dd-yyyy; 3.yyyy-mm-dd; 4.dd/mm/yyyy; 5.mm/dd/yyyy;; 6.yyyy/mm/dd;  
function dvd_is_date(input) {
    
    if(dvd_is_type_date(input, 1) || 
        dvd_is_type_date(input, 2) || 
        dvd_is_type_date(input, 3) || 
        dvd_is_type_date(input, 4) || 
        dvd_is_type_date(input, 5) || 
        dvd_is_type_date(input, 6))
        return true;
    
    return false;
}

function dvd_is_type_date(input, type) {
    
    if(dvd_is_empty(true))
    {
        return false;
    }
    
    var pat = '';
    
    switch(type)
    {
        case 1:
            pat = /^([0-9]{1,2}\-{1}){2}[0-9]{2,4}$/ ;
            break;
        case 2:
            pat = /^([0-9]{1,2}\-{1}){2}[0-9]{2,4}$/ ;
            break;
        case 3:
            pat = /^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/ ;
            break;
        case 4:
            pat = /^([0-9]{1,2}\/{1}){2}[0-9]{2,4}$/ ;
            break;
        case 5:
            pat = /^([0-9]{1,2}\/{1}){2}[0-9]{2,4}$/ ;
            break;
        case 6:
            pat = /^[0-9]{2,4}\/[0-9]{1,2}\/[0-9]{1,2}$/ ;
            break;
    }
        
        
    if(pat.test(input) == false)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function dvd_upper_first_char(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
