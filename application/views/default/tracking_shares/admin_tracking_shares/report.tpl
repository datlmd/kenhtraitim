{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Tracking_shares
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Report')}</h1>
    <div class=buttons>               
        
        <a href="{base_url('tracking_shares/admin_tracking_shares/export_user')}?{get_extra_params_from_url()}" class="button"><span>{lang('Export Top User Active')}</span></a>      
    </div>
</div>

<div class="content">    
    <form action="" method="get" id="FilterUser">
        <table class="filter">
            <tbody>
                <tr>
                	<td>
                        <label>{lang('Username')}</label>
                        <input type="text" name="username" value="{$smarty.get.username}" />
                    </td>
                    
                    <td>
                        <label>{lang('From date')}</label>
                        <input type="text" name="from_date" class="pgDate" value="{$smarty.get.from_date}" />
                    </td>
                    
                    <td>
                        <label>{lang('To date')}</label>
                        <input type="text" name="to_date" class="pgDate" value="{$smarty.get.to_date}" />
                    </td>
                    
                    <td><a onclick="$('#FilterUser').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
    <p>Tổng user active: <b>{$count_user_act}</b></p><br/>
    <p>Tổng user active theo ip: <b>{$count_user_act_ip}</b></p><br/>
    <p>Tổng user login: <b>{$count_user}</b></p><br/>
    <p>Tổng lượt login: <b>{$count_log}</b></p><br/>    
    <p>Tổng vote: <b>{$count_vote}</b></p><br/>
    <p>Tổng chat: <b>{$count_chat}</b></p><br/>
    <p><b>Chia sẻ:</b></p>
    <p>Tổng share zing me: <b>{$count_share_zm}</b></p><br/>
    <p>Tổng share face book: <b>{$count_share_fb}</b></p><br/>
    <p><b>Teen ngữ:</b></p>
    <p>Tổng contest chưa active: <b>{$count_contests_notact}</b></p><br/>
    <p>Tổng consider: <b>{$count_contests_consider}</b></p><br/>
    <p>Tổng Hide: <b>{$count_contests_not}</b></p><br/>
    <p>Tổng contest đã active: <b>{$count_contests_act}</b></p><br/>
    <p>Tổng user contest: <b>{$count_contests_user}</b></p><br/> 
    <p><b>Comments:</b></p>
    <p>Tổng comment chưa active: <b>{$count_comment_notact}</b></p><br/>
    <p>Tổng comment đã active: <b>{$count_comment_act}</b></p><br/>
    <p><b>Click:</b></p>
    {foreach $count_clicks as $click}
    <p>{$click.click_name}: <b>{$click.count_name}</b></p><br/>
    {/foreach}
</div>
