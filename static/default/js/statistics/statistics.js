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

function draw_kpi_chart(id_chart_div, title, current_kpi, target_kpi)
{
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Status');
    data.addColumn('number', 'Units');
    var remain = (target_kpi > current_kpi ? (target_kpi - current_kpi) : 0);
    data.addRows([
        ['Kpi : ' + number_format(target_kpi), 0],
        ['Achieve : ' + number_format(current_kpi), current_kpi],
        ['Remain : ' + number_format(remain),  remain],    
        ]);
     

    var options = {
        title: title,
        height: 200,
        sliceVisibilityThreshold:0,
        chartArea:{
            width:"90%"
        //            height:"90%"
        },
        width: 380,
        colors:['#003A88' ,'#058dc7','lightblue']
    //        is3D: true,
    //        legend: 'bottom'
        
    };
   
   var formatter = new google.visualization.NumberFormat(
    {
        fractionDigits: 0
    });
    formatter.format(data, 1); // Apply formatter to second column

    var chart = new google.visualization.PieChart(document.getElementById(id_chart_div));
    chart.draw(data, options);
    
}

function draw_process_chart(id_chart_div, json_data)
{
    //get data
    if(!json_data)
        return false;
    
    try
    {
        var datas = JSON.parse(json_data);
    }
    catch(err)
    {
        return false;
    }
  
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn('string', 'Date');
    dataTable.addColumn('number', 'Records');
  
    dataTable.addRows(datas);
    
    //check points
    var points = Math.ceil(datas.length / 5);

    var options = {
        //        title: title,
        width: 940,
        backgroundColor: 'none',
        legend: 'none',
        pointSize: 6,
        lineWidth: 4,
        focusTarget: 'category',
        chartArea:{
            left:60,
            top:10,
            width:"93%",
            height:"87%"
        },
        hAxis: {
            //            textPosition: 'in',
            showTextEvery: points,
            slantedText: false,
            textStyle: {
                color: '#058dc7', 
                fontSize: 10
            }
        } ,
        areaOpacity: 0.1,
        colors:['#058dc7','#e6f4fa']
    };
    
    var formatter = new google.visualization.NumberFormat(
    {
        fractionDigits: 0
    });
    formatter.format(dataTable, 1); // Apply formatter to second column

    var chart = new google.visualization.AreaChart(document.getElementById(id_chart_div));
    chart.draw(dataTable, options);
    
    return true;
}

function draw_compare_chart(campaign_id, id_chart_div, loading_div, data_url)
{
   
    //loader image
    $(loading_div).show(200);
    
    var get_data_url = data_url + campaign_id;
     
    $.get(get_data_url, function(json_data){    
             
        //get data
        if(!json_data)
            return false;
                
        try
        {
            var datas = JSON.parse(json_data);
        }
        catch(err)
        {
            return false;
        }
        
        if(datas['error'])
            return false;
        
        var dataTable = google.visualization.arrayToDataTable(datas);
        
        //check points
        var points = Math.ceil(datas.length / 5);

        var options = {
            width: 1170,
            height: 350,
            backgroundColor: 'none',
            pointSize: 5,
            lineWidth: 3,
            focusTarget: 'category',
            chartArea:{
                left:60,
                top:10,
                width:"78%",
                height:"90%"
            },
            hAxis: {
                //                                textPosition: 'in',
                showTextEvery: points,
                //                slantedText: false,
                textStyle: {
                    color: '#058dc7', 
                    fontSize: 10
                }
            } ,
            areaOpacity: 0.1
        //            colors:['#058dc7','#e6f4fa']
        };
             
        var div = $("#" + id_chart_div);
        div.slideUp(1000, function(){       
            
            //format number
            var formatter = new google.visualization.NumberFormat(
            {
                fractionDigits: 0
            });
            var configs = datas[0].length - 1;
            for(var i = 1; i <= configs; i++)
            {
                formatter.format(dataTable, i);
            }
                 
    
            var chart = new google.visualization.LineChart(document.getElementById(id_chart_div));
            chart.draw(dataTable, options);
        
            div.slideDown(1000, function(){
                
                //fade out the loading
                $(loading_div).hide(200, function(){
                    $(this).css('display', 'none');
                });
            });
                    
          
        });
                
    });
  
}

function validate_filter_dates(start_class, end_class)
{
    //dates
    var start_date = $("." + start_class).val();
    var end_date = $("." + end_class).val();
    
    var min_date = $("." + start_class).attr(CONFIG_ATTR_DATA);
    var max_date = $("." + end_class).attr(CONFIG_ATTR_DATA);
    
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

function toggle_report(div_id, speed)
{
    var flag = $("#" + div_id + "_flag");
    
    $("#" + div_id).slideToggle(speed, function(){
        if(flag.text() == '-')
            flag.text('+');
        else
            flag.text('-');
    });
      
}

function export_to_pdf(server_url, campaign_id)
{
    
    //load image
    var loading_div = '#loading_export_pdf';
        
        
    //loader image
    //    $(loading_div).show(200);                                            
    
    //    var output = escape("<html>" + document.getElementsByTagName('html')[0].innerHTML + "</html>");

    //dates
    var start_date = $('.from_date').val();
    var end_date = $(".to_date" ).val();
    var start_date_ga = $('.from_date_ga').val();
    var end_date_ga = $('.to_date_ga').val();
    
    var form = $('<form action="' + server_url + campaign_id + '/' + start_date + '/' + end_date + '/' + start_date_ga + '/' + end_date_ga + '" method="get">' +
        //        '<input type="text" name="output" value="' + output + '" />' +
        '</form>');
    
    $('body').append(form);
    $(form).submit();   
    
     
     
    //send to server
    //    var url = server_url + campaign_id + '/' + start_date + '/' + end_date + '/' + start_date_ga + '/' + end_date_ga;
    //    $.get(url, function(data){
    //               
    //        $(loading_div).hide(200);
    //               
    //    });
    
    return false;
}

function number_format (number, decimals, dec_point, thousands_sep) {

    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}