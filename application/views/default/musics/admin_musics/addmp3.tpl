
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Musics
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add musics')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddMusics').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormAddMusics">
        <input type="hidden" name="album_id" value="{$album_id}" />
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('slug')}</td>
                    <td class="left"><input type="text" name="slug" value="" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('file')}</td>
                    <td class="left">                        
                        <input type="hidden" name="file" value="" />
                        <input type="hidden" name="length" value="" />
                        <div id="btnMp3Upload" class="button-upload">{lang('Upload')}</div>
                        <div class="JsFileUpload"></div>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('avatar')}</td>
                    <td class="left">                        
                        <input type="hidden" name="avatar" value="" />
                        <div id="btnAvatarUpload" class="button-upload">{lang('Upload')}</div>
                        <div class="image-medium-thum"></div>                        
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('singer_id')}</td>
                    <td class="left">
                        <input type="text" name="singer_name" value="" id="JsPopup_singer_name" readonly="readonly" />
                        <input type="button" value="{lang('Choose')}" onclick="openPopupData('{base_url('musics/admin_music_singers/popup')}', 'JsPopup_singer_id', 'JsPopup_singer_name');" />
                        <input type="hidden" name="singer_id" id="JsPopup_singer_id" value="" />
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('author_id')}</td>
                    <td class="left">
                        <input type="text" name="author_name" value="" id="JsPopup_author_name" readonly="readonly" />
                        <input type="button" value="{lang('Choose')}" onclick="openPopupData('{base_url('musics/admin_music_authors/popup')}', 'JsPopup_author_id', 'JsPopup_author_name');" />
                        <input type="hidden" name="author_id" id="JsPopup_author_id" value="" />
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('category')}</td>
                    <td class="left">
                        <select name="category[]" multiple="multiple">
                            {$category_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                            {$indent_symbol = '-&nbsp;'}
                            {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, $smarty.post.category)}
                        </select>                        
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('hight_quality')}</td>
                    <td class="left"><input type="text" name="hight_quality" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_hit')}</td>
                    <td class="left"><input type="checkbox" name="is_hit" value="" /></td>
                </tr>                                              

                <tr>
                    <td class="left">{get_label('meta_keyword')}</td>
                    <td class="left"><textarea name="meta_keyword"></textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_description')}</td>
                    <td class="left"><textarea name="meta_description"></textarea></td>
                </tr>                

                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="" /></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>
