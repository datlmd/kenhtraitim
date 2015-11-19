{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Html_templates
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Html templates manager')}: {$resource_name}/{$file_name}</h1>

    <div class=buttons>        
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>        
    </div>
</div>

<div class="content">
    <form action="" method="get" id="Html_templatesSearch">
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
				
                    <td><a onclick="$('#Html_templatesSearch').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>

    <form action="{base_url('')}" class="JsDeleteForm" method="post">
		<table class="list">
			<thead>
				<tr>
					<td class="left"><input type="checkbox" name="AllSelect" value="1" class="JsListViewId" /></td>
					<td class="left">{lang('Created')}</td>
                    <td class="left">{lang('User')}</td>
					<td class="left">{lang('Is default')}</td>
					<td class="left">{lang('Action')}</td>
				</tr>
			</thead>
			
			<tbody>
				{if $list_views neq FALSE}
					{foreach $list_views as $list_view}
						<tr>
							<td class="left"><input type="checkbox" name="listViewId[]" value="{$list_view.id}" class="listViewId" /></td>
							<td class="left">{pg_field_value($list_view.created)}</td>
                            <td class="left">{user_name($list_view.user_id)}</td>
							<td class="left">{pg_field_value($list_view.is_default)}</td>
							<td class="left">{link_action($link_edit, $list_view.id)}</td>
						</tr>
					{/foreach}
				{/if}
			</tbody>
		</table>
		
    </form>

</div>
