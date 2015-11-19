{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Admin Category Manager
 * 
 * @package PenguinFW
 * @subpackage articles
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Category manager')}</h1>
    
    <div class=buttons>                
        <a href="{base_url('articles/admin_article_categories/add')}" class="button"><span>{lang('Add')}</span></a>
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
    <form action="" method="get" id="FilterUser">
        <table class="filter">
            <tbody>
                <tr>
                    <td>
                        <label>{lang('Status')}</label>
                        <select name="category_status_id">
                            <option value="">{lang('All')}</option>
                            {foreach $category_status_ids as $category_status_id}
                                <option value="{$category_status_id.id}" {if $smarty.get.category_status_id != '' && $smarty.get.category_status_id == $category_status_id.id}selected{/if}>{lang($category_status_id.name)}</option>
                            {/foreach}                            
                        </select>
                    </td>
                    
                    <td>
                        <label>{lang('From date')}</label>
                        <input type="text" name="from_date" class="pgDate" value="{$smarty.get.from_date}" />
                    </td>
                    
                    <td>
                        <label>{lang('To date')}</label>
                        <input type="text" name="to_date" class="pgDate" value="{$smarty.get.to_date}" />
                    </td>
                    
                    <td>
                        <label>{lang('name')}</label>
                        <input type="text" name="name" value="{$smarty.get.name}" />
                    </td>
                    
                    <td><a onclick="$('#FilterUser').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
    
    <form action="{base_url('articles/admin_article_categories/delete')}" class="JsDeleteForm" method="post">
        {include file="./list_view.tpl"}
    </form>
</div>