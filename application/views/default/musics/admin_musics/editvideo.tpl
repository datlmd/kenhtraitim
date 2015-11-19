
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Musics
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit video')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditMusics').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditMusics">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <input type="hidden" name="album_id" value="{$data_edit->album_id}" />
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('slug')}</td>
                    <td class="left"><input type="text" name="slug" value="{$data_edit->slug}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('file')}</td>
                    <td class="left">                        
                        <input type="hidden" name="file" value="{$data_edit->file}" />
                        <input type="hidden" name="length" value="{$data_edit->length}" />
                        <div id="btnVideoUpload" class="button-upload">{lang('Upload')}</div>
                        <div class="JsFileUpload">
                            <a href="{video_url()}media/videos/musics/{$data_edit->file}" rel="shadowbox">
                                {$data_edit->file}
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('avatar')}</td>
                    <td class="left">                        
                        <input type="hidden" name="avatar" value="{$data_edit->avatar}" />
                        <div id="btnAvatarUpload" class="button-upload" {if $data_edit->avatar neq ''}style="display:none;"{/if}>{lang('Upload')}</div>                        
                        <div class="image-medium-thum" {if $data_edit->avatar eq ''}style="display:none;"{/if}>
                            <a href="{img_url()}media/images/{$data_edit->avatar}" rel="shadowbox">
                                <img src="{img_url()}media/images/{get_image_thumb($data_edit->avatar, 'small_thumb')}" />
                            </a>                            
                        </div>                        
                    </td>
                </tr>                                

                <tr>
                    <td class="left">{get_label('singer_id')}</td>
                    <td class="left">
                        <input type="text" name="singer_name" value="{$singer_name}" id="JsPopup_singer_name" readonly="readonly" />
                        <input type="button" value="{lang('Choose')}" onclick="openPopupData('{base_url('musics/admin_music_singers/popup')}', 'JsPopup_singer_id', 'JsPopup_singer_name');" />
                        <input type="hidden" name="singer_id" id="JsPopup_singer_id" value="{$data_edit->singer_id}" />
                    </td>
                </tr>                

                <tr>
                    <td class="left">{get_label('author_id')}</td>
                    <td class="left">
                        <input type="text" name="author_name" value="{$author_name}" id="JsPopup_author_name" readonly="readonly" />
                        <input type="button" value="{lang('Choose')}" onclick="openPopupData('{base_url('musics/admin_music_authors/popup')}', 'JsPopup_author_id', 'JsPopup_author_name');" />
                        <input type="hidden" name="author_id" id="JsPopup_author_id" value="{$data_edit->author_id}" />
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('category')}</td>
                    <td class="left">
                        <select name="category[]" multiple="multiple">                            
                            {$category_html = '<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
                            {$indent_symbol = '-&nbsp;'}
                            {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, $category_ids)}
                        </select>                        
                    </td>
                </tr>                               

                <tr>
                    <td class="left">{get_label('hight_quality')}</td>
                    <td class="left"><input type="text" name="hight_quality" value="{$data_edit->hight_quality}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_hit')}</td>
                    <td class="left"><input type="checkbox" name="is_hit" value="{$data_edit->is_hit}" /></td>
                </tr>                

                <tr>
                    <td class="left">{get_label('type_id')}</td>
                    <td class="left">{lang('Video')}</td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('view_count')}</td>
                    <td class="left"><input type="text" name="view_count" value="{$data_edit->view_count}" /></td>
                </tr>
{*
                <tr>
                    <td class="left">{get_label('lyrics_count')}</td>
                    <td class="left"><input type="text" name="lyrics_count" value="{$data_edit->lyrics_count}" /></td>
                </tr>                

                <tr>
                    <td class="left">{get_label('listen_count')}</td>
                    <td class="left"><input type="text" name="listen_count" value="{$data_edit->listen_count}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('vote_count')}</td>
                    <td class="left"><input type="text" name="vote_count" value="{$data_edit->vote_count}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('like_count')}</td>
                    <td class="left"><input type="text" name="like_count" value="{$data_edit->like_count}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('sms_vote_count')}</td>
                    <td class="left"><input type="text" name="sms_vote_count" value="{$data_edit->sms_vote_count}" /></td>
                </tr>
*}
                <tr>
                    <td class="left">{get_label('meta_keyword')}</td>
                    <td class="left"><textarea name="meta_keyword">{$data_edit->meta_keyword}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_description')}</td>
                    <td class="left"><textarea name="meta_description">{$data_edit->meta_description}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="{$data_edit->username}" /></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>
