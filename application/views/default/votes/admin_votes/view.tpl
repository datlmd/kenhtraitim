
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
    <h1>{lang('View Admin votes')}</h1>

    <div class=buttons>
        
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
                <td class="left head">{get_label('record_id')}</td>
                <td class="left"><a href="{base_url($record_link)}">{$data_view->record_id}</a></td>
            </tr>

            <tr>
                <td class="left head">{get_label('point')}</td>
                <td class="left">{pg_field_value($data_view->point, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('type_id')}</td>
                <td class="left">{pg_field_value($data_view->type_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('resource_id')}</td>
                <td class="left">{pg_field_value($data_view->resource_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('user_ip')}</td>
                <td class="left">{pg_field_value($data_view->user_ip, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('username')}</td>
                <td class="left">{pg_field_value($data_view->username, 'TEXT')}</td>
            </tr>            

        </tbody>
    </table>
</div>
