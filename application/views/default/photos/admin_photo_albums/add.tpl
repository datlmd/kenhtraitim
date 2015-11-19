
{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * ADD Album
 * 
 * @package PenguinFW
 * @subpackage photos
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add album')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddUsers').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}

    <form action="" method="post" id="FormAddUsers">
        <table class="list">
            <tbody>            

                <tr>
                    <td class="left">{get_label('album_status_id')}</td>
                    <td class="left">
                        <select name="album_status_id">                            
                            {foreach $album_status_ids as $album_status_id}
                                <option value="{$album_status_id.id}" {set_select('album_status_id', $album_status_id.id)}>{lang($album_status_id.name)}</option>
                            {/foreach}
                        </select>
     
                    </td>
                </tr>                                

                <tr>
                    <td class="left"><span class="required">*</span> {get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{set_value('name')}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea rows="5" cols="33" id="description" name="description">{set_value('description')}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('slug')}</td>
                    <td class="left"><input type="text" name="slug" value="{set_value('slug')}" /></td>
                </tr>

                <tr>
                    <td class="left"><span class="required">*</span> {get_label('photo_category_id')}</td>
                    <td class="left">
                        <select name="photo_category_id">
                            <option value="0">{lang('Select category')}</option>
                            {$category_html = '<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
                            {$indent_symbol = '-&nbsp;'}
                            {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, $selected_category_id)}
                        </select>
                    </td>
                </tr>

<!--                <tr>
                    <td class="left">{get_label('singer_id')}</td>
                    <td class="left">
                        <select name="singer_id">
                            <option value="0">{lang('Select singer')}</option>
                            {foreach $singers as $singer}
                                <option value="{$singer.id}">{$singer.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>-->

                <tr>
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="0" /></td>
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