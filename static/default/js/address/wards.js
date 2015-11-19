/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    var flag_change_province_first = false;
    
    //add distrcit
    $("#sel_province").change(function(){
        
        flag_change_province_first = true;
        
        var province_id = $(this).val();
        $.get('/address/admin_districts/aj_get/' + province_id, function(data){
            
            $("#sel_district").html(data);
        })            

    })
    
//    
//    $("#sel_district").change(function(){
//        
//        if(flag_change_province_first == true)
//            return false;
//        
//        var district_id = $(this).val();
//        $.get('/campaigns/admin_provinces/aj_get/' + province_id, function(data){
//            
//            $("#sel_province").html(data);
//        })            
//
//    })
});