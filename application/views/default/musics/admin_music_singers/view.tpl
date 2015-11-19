
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
    <h1>{lang('View music singers')}</h1>

    <div class=buttons>
        <a href="{base_url()}musics/admin_music_singers/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
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
                <td class="left head">{get_label('name')}</td>
                <td class="left">{pg_field_value($data_view->name, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('nickname')}</td>
                <td class="left">{pg_field_value($data_view->nickname, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('avatar')}</td>
                <td class="left">
                    <img src="{base_url()}media/images/{get_image_thumb($data_view->avatar, 'small_thumb')}" />
                </td>
            </tr>

            <tr>
                <td class="left head">{get_label('dob')}</td>
                <td class="left">{pg_field_value($data_view->dob, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('country')}</td>
                <td class="left">{pg_field_value($data_view->country, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('company')}</td>
                <td class="left">{pg_field_value($data_view->company, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('description')}</td>
                <td class="left">{pg_field_value($data_view->description, 'AREA')}</td>
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
