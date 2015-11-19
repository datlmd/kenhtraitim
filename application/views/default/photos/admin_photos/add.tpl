
{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * ADD Photo
 * 
 * @package PenguinFW
 * @subpackage photos
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add photo')}</h1>

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
                    <td class="left">{get_label('photo_status_id')}</td>
                    <td class="left">
                        <select name="photo_status_id">                            
                            {foreach $photo_status_ids as $photo_status_id}
                                <option value="{$photo_status_id.id}" {set_select('photo_status_id', $photo_status_id.id)}>{lang($photo_status_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>        
                <tr>
                    <td class="left"><span class="required">*</span> {get_label('photo_category_id')}</td>
                    <td class="left">
                        <select name="photo_category_id" id="photo_category_id">
                           <option value="0">{lang('Select category')}</option>
                           {$category_html = '<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
                           {$indent_symbol = '-&nbsp;'}
                           {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, $selected_category_id)}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left"><span class="required">*</span> {get_label('photo_album_id')}</td>
                    <td class="left">
                        <select name="photo_album_id" id="photo_album_id">                            
                            {foreach $albums as $album}
                                <option value="{$album.id}" {if $album.id==$selected_album_id}selected{/if}>{lang($album.name)}</option>
                            {foreachelse}
                                <option value="0">{lang('No Album')}</option>
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
                    <td class="left"><textarea rows="5" cols="33" name="description">{set_value('description')}</textarea></td>
                </tr>
                
                <tr>
                    <td class="left"><span class="required">*</span> {get_label('image_name')}</td>
                    <td class="left">
                        <input type="hidden" name="image_name" value="{set_value('image_name')}" />
                        {if $smarty.post.image_name == FALSE}
                        <div id="btnAvatarUpload" class="button-upload">{lang('Upload')}</div>
                        <div class="image-medium-thum"></div>
                        {else}
                            <div id="btnAvatarUpload" class="button-upload">{lang('Upload')}</div>
                        <div class="image-medium-thum"><img src="{image_url()|cat:set_value('image_name')}"/></div>
                        {/if}
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('image_link')}</td>
                    <td class="left"><input type="text" name="image_link" value="{set_value('image_link')}" /></td>
                </tr>
                         
            </tbody>
        </table>
    </form>

</div>

<script type="text/javascript">
$(document).ready(function() {
	$('select[name=photo_status_id]').val(1);
	$('#photo_category_id').change(function() {
		$.post('{base_url()}photos/admin_photos/getAlbumsForAddFunction/'+$('#photo_category_id').val()+'/1',
			    {
                            },
			    function(data) {
			    	var albums = jQuery.parseJSON(data);
			    	if (albums && albums.length > 0) {
			    		$('#photo_album_id').html('');
			    		
			    		for (x in albums) {
			    			$('#photo_album_id').append('<option value="'+albums[x]['id']+'">'+albums[x]['name']+'</option>');
			    		}
			    	}
			    	else {
			    		$('#photo_album_id').html('<option value="0">{lang('No Album')}</option>');
			    	}
			    });
		return false;
	});
});
</script>
