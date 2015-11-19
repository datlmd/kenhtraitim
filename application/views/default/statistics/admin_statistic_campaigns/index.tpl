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
    <h1>{lang('Admin statistic campaigns manager')}</h1>

    {if is_mod()}
    <div class=buttons>
        <a href="{base_url('statistics/admin_statistic_campaigns/add')}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('statistics/admin_statistic_campaigns/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
    {/if}
</div>

<div class="content">
    
    <form action="{base_url('statistics/admin_statistic_campaigns/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
    </form>

</div>