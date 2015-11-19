{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Votes
 * 
 * @package PenguinFW
 * @subpackage votes
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin sms logs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditVotes').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditVotes">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('request_id')}</td>
                    <td class="left">
                        <select name="request_id">
                            <option value="">{lang('All')}</option>
                            {foreach $request_ids as $request_id}
                                <option value="{$request_id.id}" {if $data_edit->request_id eq $request_id.id}selected{/if}>{lang($request_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('service_id')}</td>
                    <td class="left">
                        <select name="service_id">
                            <option value="">{lang('All')}</option>
                            {foreach $service_ids as $service_id}
                                <option value="{$service_id.id}" {if $data_edit->service_id eq $service_id.id}selected{/if}>{lang($service_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('command_code')}</td>
                    <td class="left"><input type="text" name="command_code" value="{$data_edit->command_code}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('message')}</td>
                    <td class="left"><input type="text" name="message" value="{$data_edit->message}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('operator')}</td>
                    <td class="left"><input type="text" name="operator" value="{$data_edit->operator}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('request_time')}</td>
                    <td class="left"><input type="text" name="request_time" value="{$data_edit->request_time}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('status')}</td>
                    <td class="left"><input type="text" name="status" value="{$data_edit->status}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
