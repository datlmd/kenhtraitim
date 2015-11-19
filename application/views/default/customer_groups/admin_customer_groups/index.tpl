{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Customer_groups
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Admin customer groups manager')}</h1>

    <div class=buttons>
         <a onclick="submit_action('{base_url()}customer_groups/admin_customer_groups/export/')" style="cursor: pointer;" class="button"><span>{lang('Export')}</span></a>     
        <a href="{base_url('customer_groups/admin_customer_groups/add')}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('customer_groups/admin_customer_groups/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">
    <form action="" method="get" id="FilterUser"></form>
    <form action="{base_url('customer_groups/admin_customer_groups/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
    </form>

</div>
