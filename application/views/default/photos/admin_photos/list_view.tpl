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
                    <td class="left">{get_label($field)}</td>
                {/foreach}
                <td class="left">{lang('Action')}</td>
            </tr>
        </thead>

        <tbody>
            {foreach $list_views as $list_view}
                <tr>
                    <td class="left">
                        {if $list_view.id}
                            <input type="checkbox" name="listViewId[]" value="{$list_view.id}" class="listViewId" />
                        {else}                            
                            <input type="checkbox" name="listViewId[]" value="0" class="listViewId" disabled="disabled" />
                        {/if}                        
                    </td>
                    {foreach from=$fields key=field item=field_type}
                    	{if $field=='image_name'}
                    		<td class="left">
                                <a class="fancybox" rel="group" href="{img_url()}media/images/{$list_view.$field}"><img width="140" src="{img_url()}media/images/{$list_view.$field}" /></a>
	                        </td>
                    	{else}
	                        <td class="left">
	                            {$value = pg_field_value($list_view.$field, $field_type)}
	                            {$value|truncate:50}
	                        </td>
	                    {/if}
                    {/foreach}
                    <td class="left">
                        {if $list_view.id}
                            {link_action($link_edit, $list_view.id)}
                        {else}
                            {$params = array()}
                            {foreach $list_params as $param}
                                {$params[] = $list_view.$param}
                            {/foreach}                            
                            {link_action($link_edit, $params)}
                        {/if}
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
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox();
    });
</script>
{$pagination_link}