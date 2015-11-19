{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Games
 * 
 * @package PenguinFW
 * @subpackage games
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin game prizes')}</h1>

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
                <td class="left head">{get_label('image')}</td>
                <td class="left">{pg_field_value($data_view->image, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('total')}</td>
                <td class="left">{pg_field_value($data_view->total, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('balance')}</td>
                <td class="left">{pg_field_value($data_view->balance, 'NUM')}</td>
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
                <td class="left head">{get_label('is_using')}</td>
                <td class="left">{pg_field_value($data_view->is_using, 'TEXT')}</td>
            </tr>

        </tbody>
    </table>
</div>
