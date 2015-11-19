{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Votes
 * 
 * @package PenguinFW
 * @subpackage votes
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin sms logs')}</h1>

    <div class=buttons>
        <a href="{base_url()}users/admin_users/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
            <tr>
                <td class="left head">{get_label('request_id')}</td>
                <td class="left">{pg_field_value($data_view->request_id, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('service_id')}</td>
                <td class="left">{pg_field_value($data_view->service_id, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('command_code')}</td>
                <td class="left">{pg_field_value($data_view->command_code, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('message')}</td>
                <td class="left">{pg_field_value($data_view->message, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('operator')}</td>
                <td class="left">{pg_field_value($data_view->operator, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('request_time')}</td>
                <td class="left">{pg_field_value($data_view->request_time, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('status')}</td>
                <td class="left">{pg_field_value($data_view->status, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('created')}</td>
                <td class="left">{pg_field_value($data_view->created, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('modified')}</td>
                <td class="left">{pg_field_value($data_view->modified, 'DATETIME')}</td>
            </tr>

        </tbody>
    </table>
</div>
