{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Customers
 * 
 * @package PenguinFW
 * @subpackage customers
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin customers')}</h1>

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
                <td class="left head">{get_label('gender')}</td>
                <td class="left">{pg_field_value($data_view->gender, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('email')}</td>
                <td class="left">{pg_field_value($data_view->email, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('region')}</td>
                <td class="left">{pg_field_value($data_view->region, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('province')}</td>
                <td class="left">{pg_field_value($data_view->province, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('phone')}</td>
                <td class="left">{pg_field_value($data_view->phone, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('dob')}</td>
                <td class="left">{pg_field_value($data_view->dob, 'DATE')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('ip_address')}</td>
                <td class="left">{pg_field_value($data_view->ip_address, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('created')}</td>
                <td class="left">{pg_field_value($data_view->created, 'DATETIME')}</td>
            </tr>

        </tbody>
    </table>
</div>
