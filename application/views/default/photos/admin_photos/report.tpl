{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Admin Photo Manager
 * 
 * @package PenguinFW
 * @subpackage photos
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Photo manager')}</h1>
    
    <div class=buttons>      
         <a onclick="submit_action('{base_url()}photos/admin_photos/export/')" style="cursor: pointer;" class="button"><span>{lang('Export')}</span></a>     
        <a href="{base_url('photos/admin_photos/add')}" class="button"><span>{lang('Add')}</span></a>
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
    
    <p><b>Thí sinh tham: </b></p>
  	<p>	- Đã duyệt: <b>{$count_singer_act}</b></p>
  	<p>	- Chờ duyệt: <b>{$count_singer_not}</b></p>
  	<p>	- Không duyệt: <b>{$count_singer_hide}</b></p><br/>
  	<p><b>Tổng vote: </b></p>
  	<p>	- Vote: <b>{$count_vote}</b></p>
  	<p>	- SMS: <b>{$count_vote_sms}</b></p><br/>
  	<p><b>Tổng user: {$count_user}</b></p><br/>
  	<p><b>Comments: </b></p>
  	<p>	- Đã duyệt: <b>{$count_comment_act}</b></p>
  	<p>	- Chờ duyệt: <b>{$count_comment_not}</b></p>
  	<p>	- Không duyệt: <b>{$count_comment_hide}</b></p><br/>
  	
</div>

{literal}
    <script type="text/javascript">
    $('document').ready(function() {
        $('input[name="p_redirect"]').val(document.location.href);
    });
    </script>
{/literal}