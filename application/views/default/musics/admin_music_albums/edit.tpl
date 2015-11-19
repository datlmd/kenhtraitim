
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
    <h1>{lang('Edit Admin music albums')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditMusics').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormEditMusics">
        <input type="hidden" name="id" value="{$data_edit->id}" />
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
                    <td class="left">{get_label('avatar')}</td>
                    <td class="left">                        
                        <input type="hidden" name="avatar" value="{$data_edit->avatar}" />
                        <div id="btnAvatarUpload" class="button-upload" {if $data_edit->avatar neq ''}style="display:none;"{/if}>{lang('Upload')}</div>                        
                        <div class="image-medium-thum" {if $data_edit->avatar eq ''}style="display:none;"{/if}>
                            <img src="{img_url()}media/images/{get_image_thumb($data_edit->avatar, 'small_thumb')}" />
                            <a href="javascript:void(0)" class="JsAuthorCancelAvatar">{lang('Remove')}</a>
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
                    <td class="left">{get_label('release_date')}</td>
                    <td class="left"><input type="text" name="release_date" value="{$data_edit->release_date}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('release_year')}</td>
                    <td class="left"><input type="text" name="release_year" value="{$data_edit->release_year}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea name="description">{$data_edit->description}</textarea></td>
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
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="{$data_edit->weight}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('view_count')}</td>
                    <td class="left"><input type="text" name="view_count" value="{$data_edit->view_count}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('music_count')}</td>
                    <td class="left"><input type="text" name="music_count" value="{$data_edit->music_count}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('video_count')}</td>
                    <td class="left"><input type="text" name="video_count" value="{$data_edit->video_count}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('like_count')}</td>
                    <td class="left"><input type="text" name="like_count" value="{$data_edit->like_count}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_keyword')}</td>
                    <td class="left"><textarea name="meta_keyword">{$data_edit->meta_keyword}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_description')}</td>
                    <td class="left"><textarea name="meta_description">{$data_edit->meta_description}</textarea></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>

<script tyle="text/javascript">
    CKEDITOR.replace('description', {
        customConfig : 'custom/musics_basic.js'
    });
</script>                 