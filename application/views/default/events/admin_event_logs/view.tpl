{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Events
 * 
 * @package PenguinFW
 * @subpackage events
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin event logs')}</h1>

    <div class=buttons>
        <a href="{base_url()}users/admin_users/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
            <tr>
                <td class="left head">{get_label('event_id')}</td>
                <td class="left">{pg_field_value($data_view->event_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('resource_id')}</td>
                <td class="left">{pg_field_value($data_view->resource_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('record_id')}</td>
                <td class="left">{pg_field_value($data_view->record_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('view_count')}</td>
                <td class="left">{pg_field_value($data_view->view_count, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('vote_count')}</td>
                <td class="left">{pg_field_value($data_view->vote_count, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('sms_count')}</td>
                <td class="left">{pg_field_value($data_view->sms_count, 'NUM')}</td>
            </tr>

        </tbody>
    </table>
</div>
