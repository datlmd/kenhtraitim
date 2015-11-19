{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Promotions
 * 
 * @package PenguinFW
 * @subpackage promotions
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin promotion details')}</h1>

    <div class=buttons>
        <a href="{base_url()}users/admin_users/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
            <tr>
                <td class="left head">{get_label('code')}</td>
                <td class="left">{pg_field_value($data_view->code, 'TEXT')}</td>
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
                <td class="left head">{get_label('username')}</td>
                <td class="left">{pg_field_value($data_view->username, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('ip')}</td>
                <td class="left">{pg_field_value($data_view->ip, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('token')}</td>
                <td class="left">{pg_field_value($data_view->token, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('full_name')}</td>
                <td class="left">{pg_field_value($data_view->full_name, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('gender')}</td>
                <td class="left">{pg_field_value($data_view->gender, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('dob')}</td>
                <td class="left">{pg_field_value($data_view->dob, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('personal_id')}</td>
                <td class="left">{pg_field_value($data_view->personal_id, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('address')}</td>
                <td class="left">{pg_field_value($data_view->address, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('region_id')}</td>
                <td class="left">{pg_field_value($data_view->region_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('phone')}</td>
                <td class="left">{pg_field_value($data_view->phone, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('email')}</td>
                <td class="left">{pg_field_value($data_view->email, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('zing_account')}</td>
                <td class="left">{pg_field_value($data_view->zing_account, 'TEXT')}</td>
            </tr>

        </tbody>
    </table>
</div>
