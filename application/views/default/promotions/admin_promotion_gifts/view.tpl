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
    <h1>{lang('View Admin promotion gifts')}</h1>

    <div class=buttons>
        <a href="{base_url()}users/admin_users/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
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
                <td class="left head">{get_label('name')}</td>
                <td class="left">{pg_field_value($data_view->name, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('image')}</td>
                <td class="left">{pg_field_value($data_view->image, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('total_item')}</td>
                <td class="left">{pg_field_value($data_view->total_item, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('used_item')}</td>
                <td class="left">{pg_field_value($data_view->used_item, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('ip')}</td>
                <td class="left">{pg_field_value($data_view->ip, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('description')}</td>
                <td class="left">{pg_field_value($data_view->description, 'TEXT')}</td>
            </tr>

        </tbody>
    </table>
</div>
