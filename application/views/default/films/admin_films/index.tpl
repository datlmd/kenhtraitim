{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Films
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Admin films manager')}</h1>

    <div class=buttons>
        <a href="{base_url('films/admin_films/add')}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('films/admin_films/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">
    
    <form action="" method="get" id="FilterForm">
        <table class="filter">
            <tbody>
                <tr>
                    <td>
                        <label>{lang('From date')}</label>
                        <input type="text" name="from_date" class="pgDate" value="{$smarty.get.from_date}" />
                    </td>
                    <td>
                        <label>{lang('To date')}</label>
                        <input type="text" name="to_date" class="pgDate" value="{$smarty.get.to_date}" />
                    </td>
                    
                    <td><a onclick="$('#FilterForm').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                    <td><a href="{base_url('films/admin_films/export')}?{$extra_params}" class="button"><span>{lang('Export')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
    <form action="{base_url('films/admin_films/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
    </form>

</div>
