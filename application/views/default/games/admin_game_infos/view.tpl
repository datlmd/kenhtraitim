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
    <h1>{lang('View Admin game infos')}</h1>

    <div class=buttons>
        <a href="{base_url()}users/admin_users/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
            <tr>
                <td class="left head">{get_label('username')}</td>
                <td class="left">{pg_field_value($data_view->username, 'TEXT')}</td>
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
                <td class="left head">{get_label('map1_total_score')}</td>
                <td class="left">{pg_field_value($data_view->map1_total_score, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map1_lv1_score')}</td>
                <td class="left">{pg_field_value($data_view->map1_lv1_score, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map1_lv2_score')}</td>
                <td class="left">{pg_field_value($data_view->map1_lv2_score, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map1_top_lv')}</td>
                <td class="left">{pg_field_value($data_view->map1_top_lv, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map2_total_score')}</td>
                <td class="left">{pg_field_value($data_view->map2_total_score, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map2_lv1_score')}</td>
                <td class="left">{pg_field_value($data_view->map2_lv1_score, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map2_lv2_score')}</td>
                <td class="left">{pg_field_value($data_view->map2_lv2_score, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map2_top_lv')}</td>
                <td class="left">{pg_field_value($data_view->map2_top_lv, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map3_total_score')}</td>
                <td class="left">{pg_field_value($data_view->map3_total_score, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map3_lv1_score')}</td>
                <td class="left">{pg_field_value($data_view->map3_lv1_score, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map3_lv2_score')}</td>
                <td class="left">{pg_field_value($data_view->map3_lv2_score, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('map3_top_lv')}</td>
                <td class="left">{pg_field_value($data_view->map3_top_lv, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('lucky_prize')}</td>
                <td class="left">{pg_field_value($data_view->lucky_prize, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('total_score')}</td>
                <td class="left">{pg_field_value($data_view->total_score, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('ip_create')}</td>
                <td class="left">{pg_field_value($data_view->ip_create, 'TEXT')}</td>
            </tr>

        </tbody>
    </table>
</div>
