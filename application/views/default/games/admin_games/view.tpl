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
    <h1>{lang('View Admin games')}</h1>

    <div class=buttons>
        <a href="{base_url()}users/admin_users/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
            <tr>
                <td class="left head">{get_label('piattos_code')}</td>
                <td class="left">{pg_field_value($data_view->piattos_code, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map')}</td>
                <td class="left">{pg_field_value($data_view->map, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('level')}</td>
                <td class="left">{pg_field_value($data_view->level, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('result')}</td>
                <td class="left">{pg_field_value($data_view->result, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('points')}</td>
                <td class="left">{pg_field_value($data_view->points, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('time')}</td>
                <td class="left">{pg_field_value($data_view->time, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('piattos_pack')}</td>
                <td class="left">{pg_field_value($data_view->piattos_pack, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('lucky_stars')}</td>
                <td class="left">{pg_field_value($data_view->lucky_stars, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('piattos_character')}</td>
                <td class="left">{pg_field_value($data_view->piattos_character, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('lucky_prize')}</td>
                <td class="left">{pg_field_value($data_view->lucky_prize, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('car')}</td>
                <td class="left">{pg_field_value($data_view->car, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('start_time')}</td>
                <td class="left">{pg_field_value($data_view->start_time, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('end_time')}</td>
                <td class="left">{pg_field_value($data_view->end_time, 'DATETIME')}</td>
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
                <td class="left head">{get_label('ip')}</td>
                <td class="left">{pg_field_value($data_view->ip, 'TEXT')}</td>
            </tr>

        </tbody>
    </table>
</div>
