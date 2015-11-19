{*

/**
* PENGUIN FrameWork
* @author tungcn <cntung2187@gmail.com> 0909898592
* @copyright Chung Nhut Tung 2011
* 
* Admin Article Manager
* 
* @package PenguinFW
* @subpackage User
* @version 1.0.0
*/

*}

<div class="heading">
    <h1>{lang('Article manager')}</h1>
    <div class=buttons>                
        <a href="{base_url('articles/admin_articles/add')}" class="button"><span>{lang('Add')}</span></a>
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
                        <select name="is_publish">
                            {foreach $is_publish as $p_status}
                                <option value="{$p_status.id}" {if $smarty.get.is_publish != '' && $smarty.get.is_publish == $p_status.id}selected{/if}>{lang($p_status.name)}</option>
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
                        <label>{lang('category')}</label>
                        <select name="article_category_id">
                            {if isset($smarty.get.article_category_id)}
                                <option value="" selected>Tất cả</option>
                            {else}
                                <option value="">Tất cả</option>
                            {/if}
                            {$category_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                            {$indent_symbol = '-&nbsp;'}
                            {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, array($smarty.get.article_category_id))}                   
                        </select>
                    </td>

                    <td>
                        <label>{lang('lang')}</label>
                        <select name="lang_id">
                            {foreach $list_langs as $list_lang}
                                <option value="{$list_lang.id}" {if ($smarty.get.lang_id != '' && $smarty.get.lang_id == $list_lang.id) || $list_lang.id == $current_lang.id}selected{/if}>{lang($list_lang.name)}</option>
                            {/foreach}                            
                        </select>
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

    <form action="{base_url('articles/admin_articles/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
    </form>
</div>