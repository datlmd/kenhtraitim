/* 
 * @namespace JS Framework
 * @author danhdvd <danhdvd@yahoo.com>
 * @copyright Đoàn Vũ Đình Danh 2012
 * 
 * @name Comment
 * @type Javascript
 * @description Get and add comments
 * @property Optional 3
 * 
 */


//config url
var COMMENT_URL_ADD = CONFIG_URL_BASE + "comments/add_comment";
var COMMENT_URL_GET = CONFIG_URL_BASE + "comments/get";

var COMMENT_BTN_SUBMIT = CONFIG_DVD_PREFIX + "comment_btn_submit";
var COMMENT_LAB_TITLE = CONFIG_DVD_PREFIX + "comment_lab_title";
var COMMENT_TXT_CONTENT = CONFIG_DVD_PREFIX + "comment_txt_content";
var COMMENT_TXT_NAME = CONFIG_DVD_PREFIX + "comment_txt_name";
var COMMENT_TXT_EMAIL = CONFIG_DVD_PREFIX + "comment_txt_email";
var COMMENT_DIV_LIST = CONFIG_DVD_PREFIX + "comment_lab_list";
var COMMENT_DIV_WRAPPER = CONFIG_DVD_PREFIX + "comment_lab_wrapper";
var COMMENT_LAB_TOTAL   = CONFIG_DVD_PREFIX + "comment_lab_total";

var COMMENT_TYPE_DROP =  "drop";
var COMMENT_TYPE_FADE =  "fade";

//set time to check delay
var comment_last_time = false;

$(document).ready(function(){


    $(COMMENT_BTN_SUBMIT).live("click", function(){
             
        //check login
        if(dvd_flag_login == false) {
            return false;
        }
        
        //check validate
        if(dvd_can_submit == false)
        {
            return false;
        }
        
        //check time delay
        if(comment_last_time && dvd_check_delay(comment_last_time, dvd_comments_delay) == false)
        {
            jAlert('error', 'Bạn hãy đợi ' + dvd_comments_delay + 's nữa tiếp tục bình luận nhé!', 'Thông báo');
            return false;
        }
        
        //check length
        var content = $(COMMENT_TXT_CONTENT).val();
        if(dvd_check_length(content, dvd_comment_content_min, dvd_comment_content_max) == false)
        {
            jAlert('error', 'Lời bình luận phải lớn hơn ' + dvd_comment_content_min + ' ký tự và ngắn hơn ' + dvd_comment_content_max + ' ký tự nhé!', 'Thông báo');            
            return false;
        }        
        
        //create comment
        var is_success = false;
        
        $.ajaxSetup({
            async:false
        });
        
        var comment_type = $(this).attr(CONFIG_ATTR_TYPE);
        var update = $(this).attr(CONFIG_ATTR_UPDATE);

        $.post(COMMENT_URL_ADD, {
            cparams: $(this).attr(CONFIG_ATTR_PARAM), 
            comment_content: content,
            comment_username: $(COMMENT_TXT_NAME).val(),
            comment_email: $(COMMENT_TXT_EMAIL).val(),
            comment_type: comment_type
        }, function(data){
            
            data = JSON.parse(data);
           
            
            //get response
            if(data.status != "success") {
                
                jAlert('error', data.message,  data.status);
            }
            else
            {
                is_success = true;
                
                                    
                //clear content
                var txt_comment = $(COMMENT_TXT_CONTENT);
                txt_comment.val("");
                txt_comment.css('border-color', 'black');
                    
                    
                //set last time
                comment_last_time = new Date();             
                
                //add comment to list if type is drop
                if(comment_type == 'drop')
                {
                    //increase total comment
                    $(COMMENT_LAB_TOTAL).html($(COMMENT_LAB_TOTAL).html() + 1);
                    
                    //insert new comment
                    $(COMMENT_DIV_LIST).html( data.record + $(COMMENT_DIV_LIST).html());
                    
                    //update comments
                    var is_update = $(this).attr(CONFIG_ATTR_UPDATE);
                    if(is_update == 1)
                    {
                        //get params
                        var params = $(this).attr(CONFIG_ATTR_PARAM);
                    
                        params = JSON.parse(params);
                    
                        var resource_id = params.resource_id;
                        var record_id = params.record_id;
                        
                        $.get(CONFIG_URL_BASE + "comments/ajax_update/" + resource_id + "/" + record_id, function(data){
                        
                            if(data != "" && data != 0)
                                $(COMMENT_DIV_LIST).html(event.data + $(COMMENT_DIV_LIST).html());
                        })
                    }

                    
                }
                else if(is_success == true && comment_type == "fade")
                {
                    //show list after create                 
                    
                    //get comments
                    $.post(COMMENT_URL_GET, {
                        cparams: $(this).attr(CONFIG_ATTR_PARAM), 
                        page_url: CONFIG_URL_REQUEST
                    }, function(data){
                        data = JSON.parse(data);
   
                        if(data.status != "success") {
                
                            jAlert('error', data.message,  data.status);
                        }
                        else
                        {
                            $(COMMENT_DIV_WRAPPER).fadeOut(1, function(){
                     
                            
                                $(this).html(data.data);
                                                  
                                $(this).fadeIn(1, function(){
                                    //jscrollpane
                                    //$('.scroll-pane').jScrollPane();
                                    } );
                        
                        
                            });


                        }
            
                    });
        
            
                }    
                
                //refresh flexcroll
                
                if(update)                 
                    fleXenv.fleXcrollMain(update);

            }
             
        });    
        
        //request GA
//        dvd_request_ga();
    })

    //update auto if turn live
    if(dvd_is_exist($(COMMENT_DIV_WRAPPER)))
    {
        $(COMMENT_DIV_WRAPPER).ready(function(){
            var is_live = $(COMMENT_DIV_WRAPPER).attr(CONFIG_ATTR_LIVE);
            if(is_live == 1)
            {
                //use the SSE of HTML5
                if(typeof(EventSource) !== "undefined")
                {
                    //get params
                    var params = $(COMMENT_DIV_WRAPPER).attr(CONFIG_ATTR_PARAM);
                    
                    params = JSON.parse(params);
                    
                    var resource_id = params.resource_id;
                    var record_id = params.record_id;
                    
                    var comment_update = new EventSource(CONFIG_URL_BASE + "service/chat.php?resource=" + resource_id + "&record=" + record_id);
                     
                    //                     var comment_update = new EventSource(CONFIG_URL_BASE + "comments/ajax_live/" + resource_id + "/" + record_id);
                         
    
                    comment_update.onmessage = function(event)
                    {            
                        if(event.data)
                        {       
                            //                            alert(data);
                            $(COMMENT_DIV_LIST).html(event.data + $(COMMENT_DIV_LIST).html());
                        }
                    }
                }
            }
            
            
        })
            
    }
})

