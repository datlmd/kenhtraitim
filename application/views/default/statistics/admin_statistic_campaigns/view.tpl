{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Statistics
 * 
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin statistic campaigns')}</h1>

    <div class=buttons>
        <a href="{base_url()}statistics/admin_statistic_campaigns/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
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
                <td class="left head">{get_label('avatar')}</td>
                <td class="left"><img width="100px" src="{image_url()}{pg_field_value($data_view->avatar, 'TEXT')}" /></td>
            </tr>

            <tr>
                <td class="left head">{get_label('start_date')}</td>
                <td class="left">{pg_field_value($data_view->start_date, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('end_date')}</td>
                <td class="left">{pg_field_value($data_view->end_date, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('created')}</td>
                <td class="left">{pg_field_value($data_view->created, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('description')}</td>
                <td class="left">{pg_field_value($data_view->description, 'TEXT')}</td>
            </tr>

<!--            <tr>
                <td class="left head">{get_label('db server')}</td>
                <td class="left">{pg_field_value($data_view->db_server, 'TEXT')}</td>
            </tr>
            
            <tr>
                <td class="left head">{get_label('db name')}</td>
                <td class="left">{pg_field_value($data_view->db_name, 'TEXT')}</td>
            </tr>
            
            <tr>
                <td class="left head">{get_label('db username')}</td>
                <td class="left">{pg_field_value($data_view->db_username, 'TEXT')}</td>
            </tr>-->

            <tr>
                <td class="left head">{get_label('ga_id')}</td>
                <td class="left">{pg_field_value($data_view->ga_id, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('ga_username')}</td>
                <td class="left">{pg_field_value($data_view->ga_username, 'TEXT')}</td>
            </tr>
          
        </tbody>
    </table>
</div>
