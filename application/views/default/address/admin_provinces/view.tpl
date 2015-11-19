{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Campaigns
 * 
 * @package PenguinFW
 * @subpackage campaigns
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin provinces')}</h1>

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
                <td class="left head">{get_label('created')}</td>
                <td class="left">{pg_field_value($data_view->created, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('create_user')}</td>
                <td class="left">{pg_field_value($data_view->create_user, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('modify_user')}</td>
                <td class="left">{pg_field_value($data_view->modify_user, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('modified')}</td>
                <td class="left">{pg_field_value($data_view->modified, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('	user_id')}</td>
                <td class="left">{pg_field_value($data_view->	user_id, 'NUM')}</td>
            </tr>

        </tbody>
    </table>
</div>
