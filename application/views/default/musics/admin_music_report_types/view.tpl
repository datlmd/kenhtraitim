
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
    <h1>{lang('View music report types')}</h1>

    <div class=buttons>
        <a href="{base_url()}musics/admin_music_report_types/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
            <tr>
                <td class="left head">{get_label('id')}</td>
                <td class="left">{pg_field_value($data_view->id, 'NUM')}</td>
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
                <td class="left head">{get_label('name')}</td>
                <td class="left">{pg_field_value($data_view->name, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('slug')}</td>
                <td class="left">{pg_field_value($data_view->slug, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('weight')}</td>
                <td class="left">{pg_field_value($data_view->weight, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('meta_keyword')}</td>
                <td class="left">{pg_field_value($data_view->meta_keyword, 'AREA')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('meta_description')}</td>
                <td class="left">{pg_field_value($data_view->meta_description, 'AREA')}</td>
            </tr>           

        </tbody>
    </table>
</div>
