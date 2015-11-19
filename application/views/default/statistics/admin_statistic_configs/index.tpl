{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Statistics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Admin statistic configs manager')}</h1>

    <div class=buttons>
        <a href="javascript:void(0);" class="button JsClearCacheItem"><span>{lang('Clear Cache')}</span></a>
        <a href="{base_url('statistics/admin_statistic_configs/add')}/{$smarty.get.campaign_id}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('statistics/admin_statistic_configs/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">
    
     <form action="{current_url()}" method="get" id="FilterUser">
        <table class="filter">
            <tbody>
                <tr>
         
                    <td>
                        <label>{lang('Campaign')}</label>
                        <select  style="width: 200px;" name="campaign_id">
                            <option value="">{lang('All')}</option>
                            {foreach $campaign_ids as $campaign_id}
                                <option value="{$campaign_id.id}" {if $smarty.get.campaign_id eq $campaign_id.id}selected{/if}>{$campaign_id.name}</option>
                            {/foreach}

                        </select>
                    </td>
                    
                    <td><a onclick="submit_action('FilterUser' ,'/statistics/admin_statistic_configs/')" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
                
    <form action="{base_url('statistics/admin_statistic_configs/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
        <input type="hidden" name="campaign_id" value="{$smarty.get.campaign_id}" />
    </form>

</div>
