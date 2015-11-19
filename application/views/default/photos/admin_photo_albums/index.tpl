{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Admin Album Manager
 * 
 * @package PenguinFW
 * @subpackage photos
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Album manager')}</h1>
    
    <div class=buttons>                
        <a href="{base_url('photos/admin_photo_albums/add')}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="javascript:void(0);" class="button JsActionPublish"><span>{lang('Publish')}</span></a>
        <a href="javascript:void(0);" class="button JsActionUnPublish"><span>{lang('Hide')}</span></a>
        
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
                        <select name="album_status_id">
                            <option value="">{lang('All')}</option>
                            {foreach $album_status_ids as $album_status_id}
                                <option value="{$album_status_id.id}" {if $smarty.get.album_status_id != '' && $smarty.get.album_status_id == $album_status_id.id}selected{/if}>{lang($album_status_id.name)}</option>
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
                        <label>{lang('Category')}</label>
                        <select name="photo_category_id">
                            <option value="">{lang('All')}</option>
                            {$category_html = '<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
	                        {$indent_symbol = '-&nbsp;'}
	                        {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, array($smarty.get.photo_category_id))}
                        </select>
                    </td>
                    
                    <td>
                        <label>{lang('Name')}</label>
                        <input type="text" name="name" value="{$smarty.get.name}" />
                    </td>
                    
                    <td><a onclick="$('#FilterUser').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
    
    <form action="{base_url('photos/admin_photo_albums/delete')}" class="JsDeleteForm" method="post">
        <input type="hidden" name="publish_type" value="0" />
        {include file="../../elements/list_view.tpl"}
    </form>
</div>