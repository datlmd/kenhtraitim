jQuery(document).ready(function($) {
    // menu
    if ($('#MainMenu').length > 0)
    {
        ddsmoothmenu.init({
            mainmenuid: "MainMenu", //menu DIV id
            orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
            classname: 'ddsmoothmenu', //class added to menu's outer DIV
            //customtheme: ["#1c5a80", "#18374a"],
            contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
        });
    }
    
    // change custom field
    $('.JsCustomFieldChange').livequery('change', function() {
        window.location.href = $(this).val();
    });
    
    // check all box
    $('input.JsListViewId').livequery('click', function() {
        if ($('input.JsListViewId:checked').val())
        {            
            $('input.listViewId').attr('checked', true);
        } else
        {         
            $('input.listViewId').removeAttr('checked');
        }
    });
    
    // delete item in list view
    $('.JsDeleteItem').livequery('click', function () {
        var n = $('input.listViewId:checked').length;
        
        if (n >= 1)
        {
            $('form.JsDeleteForm').submit();
        }            
    });
    
    // clear cache item in list view
    $('.JsClearCacheItem').livequery('click', function () {
        var n = $('input.listViewId:checked').length;
        
        if (n >= 1)
        {
            var form = $('form.JsDeleteForm');
            form.attr('action', '/statistics/admin_statistic_configs/clear_cache');
            $('form.JsDeleteForm').submit();
        }            
    });
    
    //aprove faq
    $('.JsAproveItem').livequery('click', function () {
        var n = $('input.listViewId:checked').length;
        
        if (n >= 1)
        {
            $('form.JsDeleteForm').attr("action","/faqs/admin_faqs/approve");
            
            $('form.JsDeleteForm').submit();
        }            
    });
    
    //disaprove faq
    $('.JsDisaproveItem').livequery('click', function () {
        var n = $('input.listViewId:checked').length;
        
        if (n >= 1)
        {
            $('form.JsDeleteForm').attr("action","/faqs/admin_faqs/disapprove");
            
            $('form.JsDeleteForm').submit();
        }            
    });
    
    // publish
    $('.JsActionPublish').livequery('click', function () {
        var n = $('input.listViewId:checked').length;
        
        if (n >= 1)
        {
            $('input[name=publish_type]').val('1');
            $('form.JsDeleteForm').submit();
        }            
    });
    
    // unpublish
    $('.JsActionUnPublish').livequery('click', function () {
        var n = $('input.listViewId:checked').length;
        
        if (n >= 1)
        {
            $('input[name=publish_type]').val('-1');
            $('form.JsDeleteForm').submit();
        }            
    });
    
    // list date
    if ($('.pgDate').length > 0) 
    {
        $('.pgDate').livequery(function () {
            $(this).datepicker({dateFormat: 'dd-mm-yy'});
        });
    }
    
    // list time
    if ($('.pgTime').length > 0) 
    {
        $('.pgTime').livequery(function () {
            $(this).timepicker();
        });
    }
    
    // show ajax list
    $('.JsPopupList').livequery('click', function (e) {
        e.preventDefault();
        
        var aurl = $(this).attr('href');
        
        $.get(aurl, function(data) {            
            HtmlTinyBox($.trim(data));
        });
    });
    
    // alert
    $('a.JsAlertInfo').livequery('click', function (e) {
        e.preventDefault();
        
        var aurl = $(this).attr('href');
        
        $.get(aurl, function(json) {
            var data = $.parseJSON(json);
            jAlert(data.status, data.message, JsLang[data.status.toUpperCase()]);
        });
    });
    
    // get content ajax
    $('a.JsClickLoad').livequery('click', function (e) {
        $this = $(this);
        
        e.preventDefault();
        
        var aurl = $this.attr('href');
        var response = $this.attr('name');
        
        $.get(aurl, function(data) {     
            $('.' + response).html(data);
        });
        
    });
    
    // editor
    if ($('#JsHighlightEditor').length > 0)
    {
        CodeMirror.fromTextArea(document.getElementById("JsHighlightEditor"), {
            lineNumbers: true            
        });
    }
    
    // permission radio check
    //if ($('.AdminPermission tr td.colRadio').length > 0) {
        //$('.AdminPermission tr td.colRadio').buttonset();        
    //}
    
    //survey select
    var surveys = $(".survey_question");
    
    var id = "#answers_survey_" + surveys.val();
        
    $("#answerss select").hide(1, function(){
        $(this).removeAttr("name");
    });
 
        
    $(id).show(1, function(){
        $(this).attr("name", "survey_answer_id");
    });  
    
 
    
    $(".survey_question").change(function(){
        var id = "#answers_survey_" + $(this).val();
        
        $("#answerss select").hide(1, function(){
            $(this).removeAttr("name");
        });
 
        
        $(id).show(1, function(){
            $(this).attr("name", "survey_answer_id");
        });       
    });
});