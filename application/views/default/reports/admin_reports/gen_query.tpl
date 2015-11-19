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
    <h1>{lang('Add reports')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddReports').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    
    <form action="{base_url('reports/admin_reports/generate')}" method="post" id="FormAddReports">
        <input type="hidden" name="report_id" value="{$report_id}" />
        <input type="hidden" name="main_resource_id" value="{$main_resource_id}" />
        {foreach $resource_ids as $resource_id}
            <input type="hidden" name="resource_ids[]" value="{$resource_id}" />
        {/foreach}
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left" id="ms-optgroup">
                        <select multiple="multiple" id="JsReportAllField" name="choose_fields[]" class="multiselect">
                            {foreach $fields as $all}
                                <optgroup label="{$all.resource}">
                                    {foreach $all.fields as $field}
                                        <option value="{$all.resource}.{$field.name}" style="padding-left:10px;">{$field.name}</option>
                                    {/foreach}
                                </optgroup>
                            {/foreach}
                        </select>
                    </td>                    
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>

{literal}
    <script tyle="text/javascript">
        jQuery(document).ready(function($) {
            $("#JsReportAllField").multiSelect({});
            $('#ms-optgroup .ms-selectable').find('li.ms-elem-selectable').hide();
            $('.ms-optgroup-label').click(function(){
              if ($(this).hasClass('collapse')){
                $(this).nextAll('li').hide();
                $(this).removeClass('collapse'); 
              } else {
                $(this).nextAll('li').show();
                $(this).addClass('collapse');
              }
            });
        });
    </script>
{/literal}