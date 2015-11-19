{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Faqs
 * 
 * @package PenguinFW
 * @subpackage faqs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin faqs')}</h1>

    <div class=buttons>
        <a href="{base_url()}users/admin_users/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
            <tr>
                <td class="left head">{get_label('name')}</td>
                <td class="left">{pg_field_value($data_view->name, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('email')}</td>
                <td class="left">{pg_field_value($data_view->email, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('question')}</td>
                <td class="left">{pg_field_value($data_view->question, 'TEXT')}</td>
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
                <td class="left head">{get_label('status')}</td>
                <td class="left">{pg_field_value($data_view->status, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('is_deleted')}</td>
                <td class="left">{pg_field_value($data_view->is_deleted, 'NUM')}</td>
            </tr>

        </tbody>
    </table>
</div>
