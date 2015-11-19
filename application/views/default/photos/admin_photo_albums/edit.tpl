
{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * EDIT Photo
 * 
 * @package PenguinFW
 * @subpackage photos
 * @version 1.0.0
 */

*}


<div class="heading">
    <h1>{lang('Edit Admin album')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditUsers').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>

    <div class=buttons>                
        <a href="{base_url()}photos/admin_photos/add/{$edit_module.photo_category_id}/{$edit_module.id}" class="button"><span>{lang('Add Photo')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}


    <form action="" method="post" id="FormEditUsers">
        <table class="list">
            <tbody>            
                <tr>
                    <td class="left head">{get_label('album_status_id')}</td>
                    <td class="left">
                        <select name="album_status_id">                            
                            {foreach $album_status_ids as $album_status_id}
                                <option value="{$album_status_id.id}" {set_select('album_status_id', $album_status_id.id, ($album_status_id.id == $edit_module.album_status_id) ? TRUE : FALSE)}>{lang($album_status_id.name)}</option>
                            {/foreach}
                        </select></td>
                </tr>            
                <tr>
                    <td class="left head"><span class="required">*</span> {get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{set_value('name', $edit_module.name)}" /></td>
                </tr>            
                <tr>
                    <td class="left head">{get_label('description')}</td>
                    <td class="left"><textarea id="description" rows="5" cols="33" name="description">{set_value('description', $edit_module.description)}</textarea></td>
                </tr>
                <tr>
                    <td class="left head">{get_label('slug')}</td>
                    <td class="left"><input type="text" name="slug" value="{set_value('slug', $edit_module.slug)}" /></td>
                </tr>
                <tr>
                    <td class="left head"><span class="required">*</span> {get_label('photo_category_id')}</td>
                    <td class="left">
                        <select name="photo_category_id">
                            <option value="0">{lang('Select parent')}</option>
                            {$category_html = '<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
                            {$indent_symbol = '-&nbsp;'}
                            {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, array($edit_module.photo_category_id))}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('singer_id')}</td>
                    <td class="left">
                        <select name="singer_id">
                            <option value="0">{lang('Select singer')}</option>
                            {foreach $singers as $singer}
                                <option value="{$singer.id}" {if $edit_module.singer_id = $singer.id}selected{/if}>{$singer.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left head">{get_label('is_allow_comment')}</td>
                    <td class="left">
                        <select name="is_allow_comment">
                            {foreach $comment_ids as $key => $value}
                                <option value="{$key}" {if $key==$edit_module.is_allow_comment}selected{/if}>{$value}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="left head">{get_label('counter_photo')}</td>
                    <td class="left"><input type="text" name="counter_photo" value="{$edit_module.counter_photo}" /></td>
                </tr>
                <tr>
                    <td class="left head">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="{$edit_module.weight}" /></td>
                </tr>
                <tr>
                    <td class="left head">{get_label('username')}</td>
                    <td class="left"><input type="text" name="weight" value="{$edit_module.username }" /></td>
                </tr>

            </tbody>
        </table>
    </form>

</div>

<script type="text/javascript">
    $(document).ready(function() {
    CKEDITOR.replace('description', {
                    customConfig : 'custom/config_admin.js',
                    filebrowserBrowseUrl: '{base_url()}articles/admin_article_filemanager',
    filebrowserImageBrowseUrl: '{base_url()}articles/admin_article_filemanager',
    height: '600px'
});

});
</script>