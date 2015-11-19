
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
    <h1>{lang('View Admin musics')}</h1>

    <div class=buttons>
        <a href="{base_url()}musics/admin_musics/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
        <a href="{base_url()}votes/admin_votes/add_vote/musics/{$data_view->id}" class="button JsPopupList"><span>{lang('Add vote')}</span></a>
    </div>
</div>

<div class="content">
    
    <form action="">        
        <input type="hidden" name="file_uri" value="{$music_type}/musics/{$data_view->file}" id="music_file_uri" />
    </form>
    
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
                <td class="left head">{get_label('file')}</td>
                <td class="left">
                    <a href="{video_url()}media/{$music_type}/{$data_view->file}" rel="shadowbox">
                        {pg_field_value($data_view->file, 'TEXT')}
                    </a>                    
                </td>
            </tr>

            <tr>
                <td class="left head">{get_label('length')}</td>
                <td class="left">{pg_field_value($data_view->length, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('slug')}</td>
                <td class="left">{pg_field_value($data_view->slug, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('singer_id')}</td>
                <td class="left">{pg_field_value($data_view->singer_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('avatar')}</td>
                <td class="left">
                    <div class="image-medium-thum">
                        <a href="{img_url()}media/images/{$data_view->avatar}" rel="shadowbox">
                            <img src="{img_url()}media/images/{get_image_thumb($data_view->avatar, 'small_thumb')}" />
                        </a>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="left head">{get_label('author_id')}</td>
                <td class="left">{pg_field_value($data_view->author_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('category')}</td>
                <td class="left">{$category}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('hight_quality')}</td>
                <td class="left">{pg_field_value($data_view->hight_quality, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('is_hit')}</td>
                <td class="left">{pg_field_value($data_view->is_hit, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('status_id')}</td>
                <td class="left">{pg_field_value($data_view->status_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('type_id')}</td>
                <td class="left">{pg_field_value($data_view->type_name, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('lyrics_count')}</td>
                <td class="left">{pg_field_value($data_view->lyrics_count, 'NUM')}</td>
            </tr>
            
            <tr>
                <td class="left head">{get_label('comment_count')}</td>
                <td class="left">{pg_field_value($data_view->comment_count, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('view_count')}</td>
                <td class="left">{pg_field_value($data_view->view_count, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('listen_count')}</td>
                <td class="left">{pg_field_value($data_view->listen_count, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('vote_count')}</td>
                <td class="left">{pg_field_value($data_view->vote_count, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('like_count')}</td>
                <td class="left">{pg_field_value($data_view->like_count, 'NUM')}</td>
            </tr>
            
            <tr>
                <td class="left head">{get_label('sms_vote_count')}</td>
                <td class="left">{pg_field_value($data_view->sms_vote_count, 'NUM')}</td>
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
