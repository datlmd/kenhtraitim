
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
    <h1>{lang('View music albums')}</h1>

    <div class=buttons>
        <a href="{base_url()}musics/admin_musics/addmp3/{$data_view->id}" class="button"><span>{lang('Add MP3')}</span></a>
        <a href="{base_url()}musics/admin_musics/addvideo/{$data_view->id}" class="button"><span>{lang('Add Video')}</span></a>
        
        <a href="{base_url()}musics/admin_music_albums/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
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
                <td class="left head">{get_label('slug')}</td>
                <td class="left">{pg_field_value($data_view->slug, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('avatar')}</td>
                <td class="left">
                    <img src="{img_url()}media/images/{get_image_thumb($data_view->avatar, 'small_thumb')}" />
                </td>
            </tr>

            <tr>
                <td class="left head">{get_label('singer_id')}</td>
                <td class="left">{$singer_name}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('release_date')}</td>
                <td class="left">{pg_field_value($data_view->release_date, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('release_year')}</td>
                <td class="left">{pg_field_value($data_view->release_year, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('description')}</td>
                <td class="left">{pg_field_value($data_view->description, 'AREA')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('category')}</td>
                <td class="left">{$category}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('weight')}</td>
                <td class="left">{pg_field_value($data_view->weight, 'NUM')}</td>
            </tr>
            
            <tr>
                <td class="left head">{get_label('view_count')}</td>
                <td class="left">{pg_field_value($data_view->view_count, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('music_count')}</td>
                <td class="left">{pg_field_value($data_view->music_count, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('video_count')}</td>
                <td class="left">{pg_field_value($data_view->video_count, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('like_count')}</td>
                <td class="left">{pg_field_value($data_view->like_count, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('meta_keyword')}</td>
                <td class="left">{pg_field_value($data_view->meta_keyword, 'AREA')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('meta_description')}</td>
                <td class="left">{pg_field_value($data_view->meta_description, 'AREA')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('username')}</td>
                <td class="left">{pg_field_value($data_view->username, 'TEXT')}</td>
            </tr>            

        </tbody>
    </table>
</div>
