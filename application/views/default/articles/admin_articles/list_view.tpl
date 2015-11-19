{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin View table list
 * 
 * @package PenguinFW
 * @subpackage Element
 * @version 1.0.0
 */

*}

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
                    <td class="left" id="head_{$field}">
                        <div>
                        {get_label($field)}

                        {get_filter_img($field)}

                        {get_linked_sort_img($field)}
                        </div>
                        <div class="filter_field" id="filter_{$field}" style="clear:both; float: left; margin-top: 5px; margin-right: -100px; width: 100%">
                            {if $smarty.get.$field !== '' && $smarty.get.$field !== NULL}&lbrack;<input {if $field == 'created' || $field == 'modified' || $field == 'dob'}class="pgDate"{/if} value="{$smarty.get.$field}" name="{$field}" type="text" style="outline:none; width:50% ; border: none; background: none; text-align: center;"/>&rbrack;
                            {/if}
                        </div>
                    </td>
                {/foreach}
                <td class="left">{lang('Action')}</td>
            </tr>
        </thead>
        <tbody>
            {foreach $list_views as $list_view}
                <tr>
                    <td class="left"><input type="checkbox" name="listViewId[]" value="{$list_view.id}" class="listViewId" /></td>
                    {foreach from=$fields key=field item=field_type}
                        {if is_image_link($list_view.$field)}
                            <td class="left">
                                <img width="140" src="{img_url()}media/images/{$list_view.$field}" />
                            </td>
                        {else if $field == 'data_category'}
                            {$article_categories = unserialize(pg_field_value($list_view.$field, $field_type))}
                            <td class="left">
	                           {foreach $article_categories as $article_category}
	                               {lang($article_category.name)}
	                               {if ! $article_category@last}, {/if}
	                           {/foreach}
                            </td>
                        {else}
                            <td class="left">{pg_field_value($list_view.$field, $field_type)}</td>
                        {/if}
                    {/foreach}
                    <td class="left">
                        {link_action($link_edit, $list_view.id)}                        
                    </td>
                </tr>
            {foreachelse}
                <tr>
                    <td class="left" colspan="10">{lang('No record')}</td>
                </tr>
            {/foreach}            
        </tbody>
    {/if}
</table>
{$pagination_link}