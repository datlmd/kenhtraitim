{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Events
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Admin event logs manager')}</h1>

    <div class=buttons>
        <a style="display: none" href="{base_url('events/admin_event_logs/add')}" class="button"><span>{lang('Add')}</span></a>
        <a style="display: none" href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('events/admin_event_logs/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">

    <form action="{current_url()}" method="get" id="FilterUser">
        <table class="filter">
            <tbody>
                <tr>


                    <td>
                        <label>{lang('Event')}</label>
                        <select  style="width: 200px;" name="event_id">
                            <option value="">{lang('All')}</option>
                            {foreach $events as $event}
                                <option value="{$event.id}" {if $smarty.get.event_id eq $event.id}selected{/if}>{$event.name}</option>
                            {/foreach}

                        </select>
                    </td>

                    <td>
                        <label>{lang('Resource')}</label>
                        <select style="width: 150px;" name="resource_id">
                            <option value="">{lang('All')}</option>
                             <option value="31" {if $smarty.get.resource_id eq '31'}selected{/if}>{lang('Music_singer')}</option>
                            
                        </select>
                    </td>
                    <td>
                        <label>{lang('Record')}</label>
                        <input type="text" name="record_id" value="{$smarty.get.record_id}" />
                    </td>
                    <td>
                        <label>{lang('Order')}</label>
                        <select  style="width: 200px;" name="order_id">
                            <option value="0">{lang('All')}</option>                            
                            <option value="1" {if $smarty.get.order_id == 1}selected{/if}>View count</option>                            
							<option value="2" {if $smarty.get.order_id == 2}selected{/if}>Vote count</option>
							<option value="3" {if $smarty.get.order_id == 3}selected{/if}>Sms count</option>
							<option value="4" {if $smarty.get.order_id == 4}selected{/if}>Total vote</option>
                        </select>
                    </td>
                    <!--                    <td>
                                            <label>{lang('From date')}</label>
                                            <input type="text" name="from_date" style="width: 80px;" class="pgDate" value="{$smarty.get.from_date}" />
                                        </td>
                    
                                        <td>
                                            <label>{lang('To date')}</label>
                                            <input type="text" name="to_date" style="width: 80px;" class="pgDate" value="{$smarty.get.to_date}" />
                                        </td>-->


                    <td><a onclick="submit_action('FilterUser' ,'/events/admin_event_logs/')" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>


    <form action="{base_url('events/admin_event_logs/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
    </form>

</div>
