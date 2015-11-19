/* 
 * @namespace JS Framework
 * @author danhdvd <danhdvd@yahoo.com>
 * @copyright Đoàn Vũ Đình Danh 2012
 * 
 * @name Vote
 * @type Javascript
 * @description Get and add votes
 * @property Optional 4
 * 
 */


//config url
var VOTE_URL_ADD = CONFIG_URL_BASE + "votes/add_vote_music";

var VOTE_FOM = "";

var VOTE_BTN_SUBMIT = CONFIG_DVD_PREFIX + "vote_btn_submit";
var VOTE_LAB_TOTAL = CONFIG_DVD_PREFIX + "vote_lab_total";
var VOTE_HID_PARAMS = CONFIG_DVD_PREFIX + "vote_hid_params";
var VOTE_HID_ID = CONFIG_DVD_PREFIX + "vote_hid_id";

$(document).ready(function(){
    
    $(VOTE_BTN_SUBMIT).click(function(){
        
        //get form name
        //btn submit have to has attribute CONFIG_ATTR_DIV is class of parrent form
        VOTE_FORM = "." + $(this).attr(CONFIG_ATTR_DIV);
        
        //check login
        if(dvd_flag_login == false) {
            return false;
        }
        
        var is_success = false;
        
        $.ajaxSetup({
            async:false
        });
        
        //check id 
        var id = false;
        
        if($(VOTE_FORM + " " +  VOTE_HID_ID).length > 0)
            {
                 id = $(VOTE_FORM + " " +  VOTE_HID_ID).val();
            }
 
        $.post(VOTE_URL_ADD, {
            vparams: $(VOTE_FORM + " " + VOTE_HID_PARAMS).val(),
            id: id
        }, function (data) {
            data = JSON.parse(data);
       
    
            if(data.status != "error")
            {
                $(VOTE_FORM + " " +  VOTE_BTN_SUBMIT).hide(1000);
                
                var total = (parseInt($(VOTE_FORM + " " +  VOTE_LAB_TOTAL).html())) + parseInt(data.point);
 
                    $(VOTE_FORM + " " +  VOTE_LAB_TOTAL).html(total);
                    
                //custome
                $(VOTE_FORM + " .simplemodal-close").click(function(){
                    
                    
                    $(VOTE_FORM + " " +  VOTE_LAB_TOTAL).html(total);
                    $(VOTE_FORM + " " +  VOTE_BTN_SUBMIT).html("");
                })
            }
            else
            {
                jAlert('error', data.message, "Thông báo");
            }
 
        
        }); 
    })
})
