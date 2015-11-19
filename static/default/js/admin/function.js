// Submit form and change value
function SubmitChangeInput(class_input, value, class_form)
{
    $(class_input).val(value);
    $(class_form).submit();
}

// get image thumb
function getImageThumb(image_uri, thumb_maker)
{
    return image_uri.substr(0, image_uri.indexOf('.')) + '_' + thumb_maker + image_uri.substr(image_uri.indexOf('.'), image_uri.length);
}

/**
 * open popup
 */
function openPopupData(popup)
{
    if (popup.indexOf('?') > -1)
    {
        url_popup = popup;
    } else 
{
        url_popup = popup;
    }
    window.open(url_popup, '', 'width=1000px,height=500px');
}

/**
 * get data from popup
 */
function getPopupData(id, value_id, name, value_name)
{    
    window.opener.$('#'+id).val(value_id);
    window.opener.$('#'+name).val(value_name);
    window.close();
}

/**
 * function get ajax
 */
function loadAjax(aurl)
{
    $.get(aurl, function(json) {
        var data = $.parseJSON(json);
        jAlert(data.status, data.message, JsLang[data.status.toUpperCase()]);
    });
}

/**
 * popup tiny
 */
function HtmlTinyBox(msg)
{
    TINY.box.show({
        html: msg,       
        width:500,
        height:200,
        opacity:40,
        topsplit:3
    });
}

// get Ajax content
function getContentAjax(aurl, id_response, id_value)
{
    if (id_value)
    {
        aurl += '/' + $('#' + id_value).val();
    }
    
    $.get(aurl, function(data) {
        $('#' + id_response).html(data);
    });
}

// ajax submit
function ajaxSubmit(id_form)
{
    $this = $('#' + id_form);
    
    var aurl = $this.attr('action');

    $.post(aurl, $this.serialize(), function (json) {
        var data = $.parseJSON(json);
        if (data.status == 'tinybox')
        {
            HtmlTinyBox(data.message);
        } else 
{
            jAlert(data.status, data.message, JsLang[data.status.toUpperCase()]);
        }
    });
}

function submit_action(campaign_id, from_date , to_date, data_div , get_data_url, loading_div)
{
    //validate
    if(validate_filter_dates(from_date, to_date) == false)
    {
        return false;
    }
    
    var start_date = $("." + from_date).val();
    var end_date = $("." + to_date).val();
    
    get_data_url += '/' + campaign_id + '/' + start_date + '/' + end_date;
    
    var div = $('.' + data_div);     
      
    
    //div.fadeOut(200);
    
    //loader image
    $(loading_div).show(200);
     
    $.get(get_data_url, function(data){    
      
        
        div.slideUp(1000, function(){
            
            div.html(data);
            div.slideDown(1000, function(){
                
                //fade out the loading
                $(loading_div).hide(200, function(){
                    $(this).css('display', 'none');
                });

        
            //                if(data_div == 'db_result')
            //                {
            //                    $("#db_div").css('height', div.height());
            //                }
            });
                    
          
        });
                
    });
    

}

function turn_all_radio(radio_selector)
{
    var radios = $(radio_selector);
      
    radios.attr('checked', 'checked');
   
    var parent = radios.parent('.colRadio');
   
    parent.buttonset();
}

function test_value(type, value, url)
{
    //if type is ga, do nothing
    if(type == 'Ga')
        return 1;
    
    var result = 0;
    
    $.ajaxSetup({
        async: false
    });
    
    $.post(url, {
        value:value
    }, function(data){
        if(data == 1) 
            result = 1;
    });

    if(result == 1)
    {
        jAlert('error', 'Success!<br/>The value is ok.', 'Announce');
        return 1;
    }
    else
    {
        jAlert('error', 'Fail!<br/>The value is wrong.', 'Announce');
        return 0;
    }
}

function open_filter(field)
{
    //change icon
    $("#filter_icon_" + field).css('background', "url('"+static_url+"img/filter-add.png') 0 0 no-repeat").attr('onclick','close_filter("'+ field +'")');
    
    var td_width = $("#head_" + field).width() - 30;
    
    var filter_html = '&lbrack;<input name="'+ field +'" type="text" style="outline:none; width:50% ; border: none; background: none; text-align: center;"/>&rbrack;';
    
    if(field == 'created' || field == 'modified' || field == 'dob')
        filter_html = '&lbrack;<input class="pgDate" name="'+ field +'" type="text" style="outline:none; width:50% ; border: none; background: none; text-align: center;"/>&rbrack;';
    
    $("#filter_" + field).html(filter_html);
    var a = $("#filter_" + field + " input");
    $('.JsDeleteForm').attr('action', current_url).attr('method', 'get');

    $("#filter_" + field + " input").focus().keypress(function(){
        
        if(event.which == 13 && $(this).val()) {         
               
            $('.JsDeleteForm').submit();    
        }
    });
    
    
}

function close_filter(field)
{
    $("#filter_" + field).html('');
      
    //change icon
    $("#filter_icon_" + field).css('background', "url('"+static_url+"img/filter-icon.png') 0 0 no-repeat").attr('onclick','open_filter("'+field+'")');
}

function delete_filter(field)
{
    $("#filter_" + field).html('');
    
    $('.JsDeleteForm').attr('action', current_url).attr('method', 'get').submit();  
}

$(function(){
    $(".filter_field").keypress(function(){
        if(event.which == 13) {         
              
            $('.JsDeleteForm').attr('action', current_url).attr('method', 'get').submit();    
        }
    });
})

//Validate ngày tháng năm
function validate_filter_dates(start_date, end_date)
{
    var min_date = '01/01/1980'
    var max_date = '01/01/2200';

    var errors = 0;
    var alert = '';

    //compare
    var start_obj = new Date(start_date.substr(6, 4), start_date.substr(3, 2), start_date.substr(0, 2), 0, 0, 0, 0);
    var end_obj = new Date(end_date.substr(6, 4), end_date.substr(3, 2), end_date.substr(0, 2), 0, 0, 0, 0);
    var min_obj = new Date(min_date.substr(6, 4), min_date.substr(3, 2), min_date.substr(0, 2), 0, 0, 0, 0);
    var max_obj = new Date(max_date.substr(6, 4), max_date.substr(3, 2), max_date.substr(0, 2), 0, 0, 0, 0);

    if(start_date)
    {
        if(min_date && start_obj < min_obj)
        {
            errors++;
            alert += 'Start date must be great than or equal ' + min_date + '<br/>';
        }
    }

    if(end_date)
    {
        if (max_date && end_obj > max_obj)
        {
            errors++;
            alert += 'End date must be less than or equal ' + max_date + '<br/>';
        }
    }

    if(start_date && end_date)
    {
        if(start_obj >= end_obj)
        {
            errors++;
            alert += 'End date must be great than start date<br/>';
        }
    }

    if(errors)
    {
        jAlert('error', alert);

        return false;
    }
    else
    {
        return true;
    }

}