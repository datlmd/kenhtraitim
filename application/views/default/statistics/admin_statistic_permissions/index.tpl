{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Statistics
 * @version 1.0.0
 */

*}

<!--<div class="heading">
    <h1>{lang('Admin statistic permissions manager')}</h1>

    <div class=buttons>
        <a href="{base_url('statistics/admin_statistic_permissions/add')}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
{if $cf_names neq false}
    <select class="JsCustomFieldChange">
    {foreach $cf_names as $cfn}
        <option value="{base_url('statistics/admin_statistic_permissions/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
    {/foreach}
</select>
{/if}
</div>
</div>-->

<div class="heading">
    <h1>{lang('Admin statistic permissions manager')}</h1>

    <div class=buttons>

        <a href="javascript:void(0)" onClick="$('.JsDeleteForm').submit();" class="button"><span>{lang('Update')}</span></a>
    </div>
</div>

<div class="content">

<!--    <form class="data_div" action="{current_url()}" method="get" id="FilterUser">
        <table class="filter">
            <tbody>


                <tr>  
                    <td>
                        <label>{lang('Campaign')}</label>
                        <select  style="width: 200px;" name="campaign_id">
                            <option value="">All</option>
    {foreach $campaign_ids as $campaign_id}
        <option value="{$campaign_id.id}" {if $smarty.get.campaign_id eq $campaign_id.id}selected{/if}>{$campaign_id.name}</option>
    {/foreach}
</select>
</td>

<td>
<label>{lang('User')}</label>
<select  style="width: 200px;" name="account_id">
    <option value="">All</option>
    {foreach $accounts as $account}
        <option value="{$account.id}" {if $smarty.get.account_id eq $account.id}selected{/if}>{$account.username}</option>
    {/foreach}
</select>
</td>

<td><a onclick="submit_action({$smarty.get.campaign_id} ,'from_date', 'to_date', 'db_result', '/statistics/admin_statistics/ajax_get_db_statistics')" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
</tr>
</tbody>
</table>
</form>-->

<!--    <div class="div_users flexcroll_div" >
        <table class="list" style="width: 99%;">
            {if $fields eq false}
                <tbody>
                    <tr><td class="left">{lang('No record')}</td></tr>
                </tbody>
            {else}
                <thead>
                    <tr>
                        <td class="left">User</td>              
                    </tr>
                </thead>

                <tbody>

                    {foreach $users as $user}

                        <tr>
                            <td class="left"><a {if $user.id eq $current_user_id}class="active"{/if} style="float: left; width: 100%;" href="{base_url()}statistics/admin_statistic_permissions/index/{$user.id}">
                                    {$user.username}
                                </a>
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
    </div>-->

    <div class="div_campaigns"> 
        <form action="" class="JsDeleteForm" method="post">
            {include file="./list_view.tpl"}
        </form>
    </div>
        
</div>

<!--        <script type="text/javascript">
    fleXenv.fleXcrollMain('flexcroll_1');    
    </script>-->