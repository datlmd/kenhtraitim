{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Admin view table list
 * 
 * @package PenguinFW
 * @subpackage articles
 * @version 1.0.0
 */

*}

{* draw tree category *}
{function name=list_view level=0}
    {foreach $category.items as $cat}
        <tr>
            <td class="left"><input type="checkbox" name="listViewId[]" value="{$cat.id}" class="listViewId" /></td>
            {foreach from=$fields key=field item=field_type}
                <td class="left">
	                {if $field == 'name'}
			            {for $i=0 to $level}
	                        - &nbsp;
	                    {/for}
	                {/if}
                    {pg_field_value($cat.$field, $field_type)}
                </td>
            {/foreach}
            <td class="left">
                {link_action($link_edit, $cat.id)}                        
            </td>
        </tr>
        {if isset($cat.items)}
            {list_view category=$cat level=$level+1}
        {/if}
    {/foreach}
{/function}

<table class="list">
    {if $fields eq false}
        <tbody>
            <tr><td class="left">{lang('No record')}</td></tr>
        </tbody>
    {else}
        <thead>
            <tr>
                <td class="left"><input type="checkbox" name="AllSelect" value="1" class="JsListViewId" /></td>
                {foreach from=$fields key=field item=field_type}
                    <td class="left">{get_label($field)}</td>
                {/foreach}
                <td class="left">{lang('Action')}</td>
            </tr>
        </thead>

        <tbody>
            {call name=list_view category=$list_views}
        </tbody>
    {/if}
</table>
{$pagination_link}