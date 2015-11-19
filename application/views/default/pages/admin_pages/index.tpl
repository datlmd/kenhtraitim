
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Pages
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Admin pages manager')}</h1>

    <div class=buttons>
        <a href="{base_url('pages/admin_pages/add')}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('pages/admin_pages/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">
    
    <form action="" method="get" id="PagesSearch">
        <table class="filter">
            <tbody>
                <tr>
                    
                    <td>
                        <label>{lang('Status')}</label>
                        <select name="status">
                            <option value="">{lang('All')}</option>
                            <option value="-1" {if $smarty.get.status eq -1}selected{/if}>{lang('No active')}</option>
                            <option value="1" {if $smarty.get.status eq 1}selected{/if}>{lang('actived')}</option>
                        </select>
                    </td>

                    <td>
                        <label>{lang('Title')}</label>
                        <input type="text" name="title" value="{$smarty.get.title}" />
                    </td>
				
                    <td><a onclick="$('#PagesSearch').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>

    <form action="{base_url('pages/admin_pages/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
    </form>

</div>
