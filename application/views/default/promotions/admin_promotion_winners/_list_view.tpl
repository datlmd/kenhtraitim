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
                    	{if $field=='full_name'}
                    		<td class="left">
	                            <b>{$list_view.$field}</b><br />	                            
								<p><b>ĐC</b>: {$list_view.address}</p>
								<p><b>Phone</b>: {$list_view.phone}</p>
								<p><b>Email</b>: {$list_view.email}</p>
								<p><b>Zing</b>: {$list_view.zing_account}</p>
		                        <p><b>Created</b>: {$list_view.created}</p>	                        
	                        </td> 
	                    {elseif $field=='is_received'}  
	                         <td class="left">
	                         	{$gifts = $this->load_gift_id($list_view.id_gift)}
	                         	<b>Gift: {$gifts->name}</b> <br/><br/>
	                            {if $list_view.is_received == 1} 
	                            	<b></b>Đã nhận quà<br />
	                            	<b>Ngày nhận:</b> {$list_view.received_date}
	                            {elseif $list_view.is_confirm == 1}                           	
	                            	<input type="button" id="rece" value="Nhận quà" onclick="javascript:post_gift({$list_view.id},'{$list_view.zing_account}',{$gifts->description})" />
	                            {else}
	                            	Chờ confirm	                            	
	                            {/if}                        
	                        </td> 
	                    {elseif $field=='is_confirm'}  
	                         <td class="left">
	                            {if $list_view.is_confirm == 1} 
	                            	<b></b>Đã confirm<br />
	                            	<b>Ngày confirm:</b> {$list_view.confirm_date}
	                            {else}
	                            	<input type="button" id="confirm" onclick="javascript:is_confirm({$list_view.id})" value="Confirm" />	                            	
	                            {/if}                        
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

<div style="width: 100%; height: 20px;">
        <div style="width:60% ; margin-top: 7px; float: left;">{$pagination_link}</div>
        <div id="total_records" style="width: 30%; text-align: right ; color:blue; float:right; font-weight: bold; font-size: 19px;" >Total: {if $total_records}{$total_records}{else}0{/if} records</div>
</div>

<script type="text/javascript">
function is_confirm(id) {
	jConfirm('Bạn có chắc chắn muốn cập nhật trạng thái không?', 'Thông báo', function (r) {
        if (r) {   
	     var url = base_url + 'promotions/admin_promotion_winners/confirm';
	     $.post(url,
	        { id: id, is_confirm: 1 },
	        function(data){
	            if(data == '1')
	            {
	            	location.reload(true);
	            }
	        });
	       }
    });
    return false;
}
function post_gift(id, account, total) {
	jConfirm('Bạn có chắc chắn muốn nhận quà không?', 'Thông báo', function (r) {
        if (r) {   
	     var url = base_url + 'frontend/payment_service/action_payment';
	     $.getJSON(url,
	        { transID: id, accountName: account, totalAmount: total },
	        function(resultdata){
	            if(resultdata.result == 'success')
	            {
	                //alert(resultdata.message);
	                $.post(base_url + 'promotions/admin_promotion_winners/received',
		        	        { id: id, is_received: 1 });
	                location.reload(true);
	            }
	            else
	            	alert(resultdata.message);
	        });
	       }
    });
    return false;
}
//jQuery(document).ready(function($) {
//	 $('.JsActionPublish').livequery('click', function () {
//		 var slCity = $('#category_id').attr('value');
//	        var n = $('input.listViewId:checked').length;
//	        
//	        if (n >= 1)
//	        {
//	            $('input[name=publish_type]').val('1');
//	            $('form.JsDeleteForm').submit();
//	        }            
//	    });
//});

</script>