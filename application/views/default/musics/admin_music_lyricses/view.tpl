
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Musics
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View music lyricses')}</h1>

    <div class=buttons>
        <a href="{base_url()}musics/admin_music_lyricses/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
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
                <td class="left head">{get_label('music_id')}</td>
                <td class="left">{pg_field_value($data_view->music_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('content')}</td>
                <td class="left">{pg_field_value($data_view->content, 'AREA')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('status_id')}</td>
                <td class="left">{pg_field_value($data_view->status_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('weight')}</td>
                <td class="left">{pg_field_value($data_view->weight, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('username')}</td>
                <td class="left">{pg_field_value($data_view->username, 'TEXT')}</td>
            </tr>            

        </tbody>
    </table>
</div>
