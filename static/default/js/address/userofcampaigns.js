/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    //add distrcit
    $("#sel_province").live('change', function(){
        
        var province_id = $(this).val();
        $.get('/address/admin_districts/aj_get/' + province_id, function(data){
            
            $("#sel_district").html(data).removeAttr('disabled');
            
            $("#sel_district").change();
        })                

    })
    
    
    $("#sel_district").live('change',function(){
        
        
        var district_id = $(this).val();
        $.get('/address/admin_wards/aj_get/' + district_id, function(data){
            
            $("#sel_ward").html(data).removeAttr('disabled');
        })            

    })
});