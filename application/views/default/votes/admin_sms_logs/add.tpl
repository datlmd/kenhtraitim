{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Votes
 * 
 * @package PenguinFW
 * @subpackage votes
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin sms logs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddVotes').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddVotes">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('request_id')}</td>
                    <td class="left">
                        <select name="request_id">
                            <option value="">{lang('All')}</option>
                            {foreach $request_ids as $request_id}
                                <option value="{$request_id.id}">{lang($request_id.name)}</option>
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
                                <option value="{$service_id.id}">{lang($service_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('command_code')}</td>
                    <td class="left"><input type="text" name="command_code" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('message')}</td>
                    <td class="left"><input type="text" name="message" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('operator')}</td>
                    <td class="left"><input type="text" name="operator" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('request_time')}</td>
                    <td class="left"><input type="text" name="request_time" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('status')}</td>
                    <td class="left"><input type="text" name="status" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
