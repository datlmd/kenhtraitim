/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var MENU_DIV_BODY = CONFIG_DVD_PREFIX + "menu_div_body";
var MENU_DIV_CONTENT = CONFIG_DVD_PREFIX + "menu_div_content";
var MENU_DIV_WRAPPER = CONFIG_DVD_PREFIX + "menu_div_wrapper";
var MENU_DIV_LOAD = CONFIG_DVD_PREFIX + "menu_div_load";
var MENU_DIV_ITEM = MENU_DIV_WRAPPER + " a";
var MENU_URL_GET = CONFIG_URL_BASE + "";
var MENU_IMG_LOAD = CONFIG_URL_STATIC + "img/loading.gif";

$(document).ready(function(){
    
    //set height
    //    $(MENU_DIV_BODY).css('min-height', $(MENU_DIV_BODY).height() + 10);
    
    $(MENU_DIV_ITEM).live('click', function(event){     
        
        var url = $(this).attr('href');        
        var li = $(this).children('li');
        var wrapper = $(this).parents(MENU_DIV_WRAPPER);
        var content = $(MENU_DIV_CONTENT);
        var loading = $(MENU_DIV_LOAD);
        var li_prev = wrapper.find('li.active');
          
        //show loading image
        var loading_img = '<img src="'+ MENU_IMG_LOAD +'" width="50" height="50"/>';
        loading.html(loading_img);
        
        //        content.html(loading_img + content.html());
        
        //        content.fadeOut(500, function(){
        //            content.html(loading_img);
        //            content.fadeIn(100).delay(2000);
        //        });
        
        $.post(url, {
            ajax_menu : 1
        }, function(data){
            data = JSON.parse(data);
           
            var output = data.output;               
            
            content.fadeOut(500, function(){
                $(this).html(output);
                $(this).fadeIn(500, function(){
                    loading.html('');
                });
                              
            })
            
            content.focus();

            /////change menu///////
            li_prev.removeClass('active');
            li.addClass('active');
        });
        
        event.preventDefault();
    })
})

