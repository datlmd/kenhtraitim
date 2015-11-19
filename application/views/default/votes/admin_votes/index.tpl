
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Votes
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>Admin votes manager</h1>

    <div class=buttons>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('modules/admin_modules/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">
    
    <form action="" method="get" id="VotesSearch">
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
                    <td>
                        <label>{lang('Type')}</label>
                        <select name="type_id">
                            <option value="">{lang('All')}</option>
                            {foreach $type_ids as $type_id}
                                <option value="{$type_id.id}" {if $smarty.get.type_id eq $type_id.id}selected{/if}>{lang($type_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>

                    <td>
                        <label>{lang('Username')}</label>
                        <input type="text" name="username" value="{$smarty.get.username}" />
                    </td>
                    
                    <td>
                        <label>{lang('Record')}</label>
                        <input type="text" name="record_id" value="{$smarty.get.record_id}" />
                    </td>
				
                    <td><a onclick="$('#VotesSearch').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>

    <form action="{base_url('votes/admin_votes/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
    </form>

</div>
