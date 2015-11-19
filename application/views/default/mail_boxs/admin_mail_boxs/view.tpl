{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Mail_boxs
 * 
 * @package PenguinFW
 * @subpackage mail_boxs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin mail boxs')}</h1>

    <div class=buttons>
        <a href="{base_url()}users/admin_users/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
            <tr>
                <td class="left head">{get_label('email_from')}</td>
                <td class="left">{pg_field_value($data_view->email_from, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('email_to')}</td>
                <td class="left">{pg_field_value($data_view->email_to, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('created')}</td>
                <td class="left">{pg_field_value($data_view->created, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('modified')}</td>
                <td class="left">{pg_field_value($data_view->modified, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('user_ip')}</td>
                <td class="left">{pg_field_value($data_view->user_ip, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('subject')}</td>
                <td class="left">{pg_field_value($data_view->subject, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('content')}</td>
                <td class="left">{pg_field_value($data_view->content, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('user_name')}</td>
                <td class="left">{pg_field_value($data_view->user_name, 'TEXT')}</td>
            </tr>

        </tbody>
    </table>
</div>
