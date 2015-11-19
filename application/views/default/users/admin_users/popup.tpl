
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('User manager')}</h1>    
</div>

<div class="content">
    
    <form action="" method="get" id="FilterUser">
        <table class="filter">
            <tbody>
                <tr>
                    <td>
                        <label>{lang('Status')}</label>
                        <select name="user_status_id">
                            <option value="">{lang('All')}</option>
                            {foreach $user_statuses as $user_status}
                                <option value="{$user_status.id}" {if $smarty.get.user_status_id eq $user_status.id}selected{/if}>{lang($user_status.name)}</option>
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
                        <label>{lang('Username')}</label>
                        <input type="text" name="username" value="{$smarty.get.username}" />
                    </td>
                    
                    <td><a onclick="$('#FilterUser').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>

    <table class="list">
        <thead>
            <tr>
                <td class="left">{lang('Username')}</td>                
            </tr>
        </thead>
        
        <tbody>
            {foreach $list_views as $list_view}
                <tr>
                    <td class="left">
                        <a href="#this" onClick="getPopupData('{$smarty.get.insert_id}', '{$list_view.id}', '{$smarty.get.insert_name}', '{$list_view.username}')">
                            {$list_view.username}
                        </a>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>

</div>
