{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Reports
 * 
 * @package PenguinFW
 * @subpackage reports
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin reports')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddReports').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
            
    <form action="{base_url('reports/admin_reports/gen_query')}" method="post" id="FormAddReports">
        <input type="hidden" name="report_id" value="{$report_id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">
                        <h3>{lang('Module')}</h3>
                        {foreach $modules as $module}
                            <div class="line">
                                <a href="{base_url('modules/admin_resources/get_ajax_resource')}/{$module.id}" class="JsClickLoad" name="JsReportResource">{$module.name}</a>
                            </div>
                        {/foreach}
                    </td>
                    
                    <td class="left">
                        <h3>{lang('Resource')}</h3>
                        <input type="hidden" name="main_resource_id" id="JsReportMainResource" value="" />
                        <div class="JsReportResource"></div>
                    </td>
                    
                    <td class="left">
                        <h3>{lang('Relation')}</h3>
                        <div class="JsReportRelation"></div>
                    </td>
                </tr>                                
            
            </tbody>
        </table>
    </form>

</div>

{literal}
    <script tyle="text/javascript">
        jQuery(document).ready(function($) {
            $('a.JsClickLoad').livequery('click', function () {                
                $('.JsReportRelation').html('');
            });
        });
    </script>
{/literal}