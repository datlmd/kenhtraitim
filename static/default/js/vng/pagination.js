/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var PAGINATION_DIV_BODY = CONFIG_DVD_PREFIX + "page_div_body";
var PAGINATION_DIV_CONTENT = CONFIG_DVD_PREFIX + "page_div_content";
var PAGINATION_DIV_WRAPPER = CONFIG_DVD_PREFIX + "page_div_wrapper";
var PAGINATION_DIV_LOAD = CONFIG_DVD_PREFIX + "page_div_load";
var PAGINATION_DIV_PAGE = PAGINATION_DIV_WRAPPER + " ul li a";
var PAGINATION_URL_GET = CONFIG_URL_BASE + "";
var PAGINATION_IMG_LOAD = CONFIG_URL_STATIC + "img/loading.gif";

$(document).ready(function(){
    
    //set height
    //    $(PAGINATION_DIV_BODY).css('min-height', $(PAGINATION_DIV_BODY).height() + 10);

    var paging_loading = $(PAGINATION_DIV_LOAD);
    var paging_loading_img = '<img src="'+ PAGINATION_IMG_LOAD +'" width="50" height="50"/>';
            
    $(PAGINATION_DIV_PAGE).live('click', function(event){     
        
        var url = $(this).attr('href');
        
        //remove
   
        
        var wrapper = $(this).parents(PAGINATION_DIV_WRAPPER);
        
        var type = wrapper.attr(CONFIG_ATTR_TYPE);
        
        if(type)
            var content = $(PAGINATION_DIV_CONTENT + "." + type);
        else
            var content = $(PAGINATION_DIV_CONTENT);
             
        //show loading image
        paging_loading.html(paging_loading_img);
        
        $.post(url, {
            is_ajax : 1, 
            type : type
        }, function(data){
           
            data = JSON.parse(data);
           
            var records = data.records;
            var pages = data.pages;
           
            //change pages
            wrapper.fadeOut(500, function(){
                $(this).html(pages);
                $(this).fadeIn(500, function(){
                    paging_loading.html('');
                });
            })
            
            var more_wrapper = $("." + wrapper.attr(CONFIG_ATTR_OBJECT));
            if(more_wrapper)
            {
                more_wrapper.fadeOut(500, function(){
                    $(this).html(pages);
                    $(this).fadeIn(500);
                })
            }

            content.fadeOut(500, function(){
                $(this).html(records);
                $(this).fadeIn(500);
            })
            
            content.focus();
        });
        
        event.preventDefault();
    })
})

