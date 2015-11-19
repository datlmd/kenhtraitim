
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Comments
 * @version 1.0.0
 */

*}
<!--<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
<script type="text/javascript" src="{static_base()}js/google/jsapi.js"></script>

<script type="text/javascript">
    {literal}
            google.load("visualization", "1", {packages:["corechart"]});
    {/literal}
</script>


<div class="heading" onclick="toggle_report('cp_wrapper', 1000)" style="cursor: pointer;">
    <h1>Campaign Informations</h1> 
    <div class="open_flag" id="cp_wrapper_flag">-</div>
</div>

<div class="content"  id="cp_wrapper" style="width: 98%;"> 

    <form action="{base_url('comments/admin_comments/delete')}" id="cp_div" class="JsDeleteForm data_div" method="post">   
        {include file="./cp_list_view.tpl"}
    </form>

</div>


<div style="margin-top: 20px; width: 100%; clear: left;"></div>

<div class="left"></div>
<div class="right"></div>
<div class="heading" onclick="toggle_report('ga_wrapper', 1000)" style="cursor: pointer;">
    <h1>GA Reports</h1>
    <div class="open_flag" id="ga_wrapper_flag">-</div>
    <div class=buttons>        

    </div>
</div>

<div class="content"  id="ga_wrapper" style="width: 98%;">

    <div class="kpis">
        <form>
            <table class="filter">
                <tbody>
                    <tr>  
                        <td>
                            <h1>Current KPIs</h1>
                        </td>

                    </tr>
                </tbody>
            </table>
        </form>
        {foreach $ga_kpis as $key => $kpi}
            <div class="kpi"  >
                <div id="ga_chart_div_{$key}">
                    <script type="text/javascript">
                        google.setOnLoadCallback(draw_kpi_chart('ga_chart_div_{$key}', '{$kpi.name}', {$kpi.current_kpi}, {$kpi.total_kpi}));
                    </script>
                </div>
            </div>
        {/foreach}
    </div>

    <div class="data_div" style="margin-bottom: 15px;">
        <form>
            <table class="filter">
                <tbody>
                    <tr>  
                        <td>
                            <h1>Overview Comparison</h1>
                        </td>

                        <td class="img_loading" id="loading_ga_compare"><img src="{static_base()}images/loader.gif" /></td>

                    </tr>
                </tbody>
            </table>
        </form>

        <div id="ga_compare">

        </div>

    </div>

    <form  class="data_div" action="{current_url()}" method="get" id="GaFilterUser">
        <table class="filter">
            <tbody>
                <tr>  
                    <!--                    <td>
                                            <label>{lang('Campaign')}</label>
                                            <select  style="width: 200px;" name="campaign_id">
                    {foreach $campaign_ids as $campaign_id}
                        <option value="{$campaign_id.id}" {if $smarty.get.campaign_id eq $campaign_id.id}selected{/if}>{$campaign_id.name}</option>
                    {/foreach}

                </select>
            </td>-->

                    <td style="width: 60%;"><h1>Daily Filter</h1></td>

                    <td >
                        <label>{lang('From date')}</label>
                        <input type="text" name="from_date_ga" ddata="{$min_date}" style="width: 100px;" class="pgDate from_date_ga" value="{$smarty.get.from_date_ga}" />
                    </td>

                    <td>
                        <label>{lang('To date')}</label>
                        <input type="text" name="to_date_ga"  ddata="{$max_date}" style="width: 100px;" class="pgDate to_date_ga" value="{$smarty.get.to_date_ga}" />
                    </td>


                    <td class="img_loading" id="loading_ga_filter"><img src="{static_base()}images/loader.gif" /></td>

                    <td><a onclick="submit_action({$smarty.get.campaign_id} ,'from_date_ga', 'to_date_ga', 'ga_result', '/statistics/admin_statistics/ajax_get_ga_statistics', '#loading_ga_filter');" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>

    <form action="{base_url('comments/admin_comments/delete')}" id="ga_div" class="JsDeleteForm data_div" method="post">
        <input type="hidden" name="publish_type" value="0" />
        <input type="hidden" name="p_redirect" value="/index/{$p_resource_name}" />
        <input type="hidden" name="update_field_name" value="{$update_field_name}" />
        <div class="ga_result"></div>
    </form>

</div>


<div style="margin-top: 20px; width: 100%; clear: left;"></div>


<div class="left"></div>
<div class="right"></div>
<div class="heading" onclick="toggle_report('db_wrapper', 1000)" style="cursor: pointer;">
    <h1>Microsite Reports</h1>
    <div class="open_flag" id="db_wrapper_flag">-</div>
    <div class=buttons>        
    </div>
</div>

<div class="content" id="db_wrapper" style="width: 98%">

    <div class="kpis">
        <form>
            <table class="filter">
                <tbody>
                    <tr>  
                        <td>
                            <h1>Current KPIs</h1>
                        </td>

                    </tr>
                </tbody>
            </table>
        </form>

        {foreach $kpis as $key => $kpi}
            <div class="kpi"  >
                <div id="chart_div_{$key}">
                    <script type="text/javascript">
                        google.setOnLoadCallback(draw_kpi_chart('chart_div_{$key}', '{$kpi.name}', {$kpi.current_kpi}, {$kpi.total_kpi}));
                    </script>

                </div>
            </div>
        {/foreach}


    </div>

    <div class="data_div" style="margin-bottom: 15px;">
        <form>
            <table class="filter">
                <tbody>
                    <tr>  
                        <td>
                            <h1>Overview Comparison</h1>
                        </td>

                        <td class="img_loading" id="loading_db_compare"><img src="{static_base()}images/loader.gif" /></td>

                    </tr>
                </tbody>
            </table>
        </form>

        <div id="db_compare">

        </div>

    </div>

    <form class="data_div" action="{current_url()}" method="get" id="FilterUser">
        <table class="filter">
            <tbody>


                <tr>  
                    <!--                    <td>
                                            <label>{lang('Campaign')}</label>
                                            <select  style="width: 200px;" name="campaign_id">
                    {foreach $campaign_ids as $campaign_id}
                        <option value="{$campaign_id.id}" {if $smarty.get.campaign_id eq $campaign_id.id}selected{/if}>{$campaign_id.name}</option>
                    {/foreach}
                </select>
            </td>-->
                    <td style="width: 60%;"><h1>Daily Filter</h1></td>
                    <td >
                        <label>{lang('From date')}</label>
                        <input type="text" name="from_date" ddata="{$min_date}" style="width: 100px;" class="pgDate from_date" value="{$smarty.get.from_date}" />
                    </td>

                    <td>
                        <label>{lang('To date')}</label>
                        <input type="text" name="to_date" ddata="{$max_date}" style="width: 100px;" class="pgDate to_date" value="{$smarty.get.to_date}" />
                    </td>


                    <td class="img_loading" id="loading_db_filter"><img src="{static_base()}images/loader.gif" /></td>


                    <td><a onclick="submit_action({$smarty.get.campaign_id} ,'from_date', 'to_date', 'db_result', '/statistics/admin_statistics/ajax_get_db_statistics', '#loading_db_filter')" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>

    <form  action="{base_url('comments/admin_comments/delete')}" id="db_div" class="JsDeleteForm data_div" method="post">
        <input type="hidden" name="publish_type" value="0" />
        <input type="hidden" name="p_redirect" value="/index/{$p_resource_name}" />
        <input type="hidden" name="update_field_name" value="{$update_field_name}" />
        <div class="db_result"></div>

    </form>


</div>

<script type="text/javascript">
    
    toggle_report("ga_wrapper", 1);    
    toggle_report("db_wrapper", 1);  
     
    //submit_action({$smarty.get.campaign_id} ,'from_date', 'to_date', 'db_kpi_div', '/statistics/admin_statistics/ajax_get_db_kpis');
    $.ajaxSetup({
    async : false
    })
    
submit_action({$smarty.get.campaign_id} ,'from_date_ga', 'to_date_ga', 'ga_result', '/statistics/admin_statistics/ajax_get_ga_statistics', '#loading_ga_filter');
    
submit_action({$smarty.get.campaign_id} ,'from_date', 'to_date', 'db_result', '/statistics/admin_statistics/ajax_get_db_statistics', '#loading_db_filter');
             
draw_compare_chart({$smarty.get.campaign_id}, "ga_compare", "#loading_ga_compare", "/statistics/admin_statistics/ajax_get_ga_compare/");
  
draw_compare_chart({$smarty.get.campaign_id}, "db_compare", "#loading_db_compare", "/statistics/admin_statistics/ajax_get_db_compare/");
  
</script>
