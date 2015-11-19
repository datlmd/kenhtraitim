{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Configs
 * 
 * @package PenguinFW
 * @subpackage configs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin configs')}</h1>

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
                <td class="left head">{get_label('value')}</td>
                <td class="left">{pg_field_value($data_view->value, 'TEXT')}</td>
            </tr>

        </tbody>
    </table>
</div>
