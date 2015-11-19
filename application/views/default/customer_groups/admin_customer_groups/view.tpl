{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Customer_groups
 * 
 * @package PenguinFW
 * @subpackage customer_groups
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin customer groups')}</h1>

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
                <td class="left head">{get_label('slogan')}</td>
                <td class="left">{pg_field_value($data_view->slogan, 'TEXT')}</td>
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
                <td class="left head">{get_label('votes')}</td>
                <td class="left">{pg_field_value($data_view->votes, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('introduce')}</td>
                <td class="left">{pg_field_value($data_view->introduce, 'TEXT')}</td>
            </tr>

        </tbody>
    </table>
</div>
