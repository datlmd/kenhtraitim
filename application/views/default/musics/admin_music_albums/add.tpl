
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
    <h1>{lang('Add music albums')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddMusics').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormAddMusics">        
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
                    <td class="left">{get_label('release_date')}</td>
                    <td class="left"><input type="text" name="release_date" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('release_year')}</td>
                    <td class="left"><input type="text" name="release_year" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea name="description"></textarea></td>
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
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="" /></td>
                </tr>                

                <tr>
                    <td class="left">{get_label('meta_keyword')}</td>
                    <td class="left"><textarea name="meta_keyword"></textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_description')}</td>
                    <td class="left"><textarea name="meta_description"></textarea></td>
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