{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Events
 * 
 * @package PenguinFW
 * @subpackage events
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin event logs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddEvents').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddEvents">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('event_id')}</td>
                    <td class="left">
                        <select name="event_id">
                            <option value="">{lang('All')}</option>
                            {foreach $event_ids as $event_id}
                                <option value="{$event_id.id}">{lang($event_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('resource_id')}</td>
                    <td class="left">
                        <select name="resource_id">
                            <option value="">{lang('All')}</option>
                            {foreach $resource_ids as $resource_id}
                                <option value="{$resource_id.id}">{lang($resource_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('record_id')}</td>
                    <td class="left">
                        <select name="record_id">
                            <option value="">{lang('All')}</option>
                            {foreach $record_ids as $record_id}
                                <option value="{$record_id.id}">{lang($record_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('view_count')}</td>
                    <td class="left"><input type="text" name="view_count" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('vote_count')}</td>
                    <td class="left"><input type="text" name="vote_count" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('sms_count')}</td>
                    <td class="left"><input type="text" name="sms_count" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
