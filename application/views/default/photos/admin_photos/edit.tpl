
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
    <h1>{lang('Edit Admin photo')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditUsers').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}    
    
    <form action="" method="post" id="FormEditUsers">
        <table class="list">
            <tbody>            
                <tr>
	                <td class="left head">{get_label('photo_status_id')}</td>
	                <td class="left">
	                   <select name="photo_status_id">                            
                            {foreach $photo_status_ids as $photo_status_id}
                                <option value="{$photo_status_id.id}" {if $photo_status_id.id == $edit_module.photo_status_id}selected{/if}>{lang($photo_status_id.name)}</option>
                            {/foreach}
                        </select></td>
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
	                <td class="left head"><span class="required">*</span> {get_label('image_name')}</td>
	                <td class="left">
	                    <input type="hidden" name="image_name" value="{set_value('image_name',$edit_module.image_name)}" />
	                    <div id="btnAvatarUpload" class="button-upload" {if $edit_module.image_name neq ''}style="display:none;"{/if}>{lang('Upload')}</div>                        
<!--	                    <div class="image-medium-thum" {if $edit_module.image_name eq ''}style="display:none;"{/if}>
	                       <a href="{img_url()}media/images/{$edit_module.image_name}" rel="shadowbox">
                                <img src="{base_url()}media/images/{get_image_thumb($edit_module.image_name, 'small_thumb')}" />
                            </a>
	                        <a href="javascript:void(0)" class="JsAuthorCancelAvatar">{lang('Remove')}</a>
	                        <input type="hidden" id="x" name="x" />
							<input type="hidden" id="y" name="y" />
							<input type="hidden" id="x2" name="x2" />
							<input type="hidden" id="y2" name="y2" />
							<input type="hidden" id="w" name="w" />
							<input type="hidden" id="h" name="h" />
                                                      
	                    </div>-->
                                
                          {if $smarty.post.image_name == TRUE}
                              <div class="image-medium-thum"><a href="{img_url()}media/images/{$edit_module.image_name}" rel="shadowbox"><img src="{image_url()|cat:set_value('image_name',$edit_module.image_name)}"/></a>
                        <input type="hidden" id="x" name="x" />
							<input type="hidden" id="y" name="y" />
							<input type="hidden" id="x2" name="x2" />
							<input type="hidden" id="y2" name="y2" />
							<input type="hidden" id="w" name="w" />
							<input type="hidden" id="h" name="h" />
                        </div>
                        {else}
                            <div class="image-medium-thum"><a href="{img_url()}media/images/{$edit_module.image_name}" rel="shadowbox"><img src="{image_url()|cat:set_value('image_name',$edit_module.image_name)}"/></a>
                        <a href="javascript:void(0)" class="JsAuthorCancelAvatar">{lang('Remove')}</a>
                        <input type="hidden" id="x" name="x" />
							<input type="hidden" id="y" name="y" />
							<input type="hidden" id="x2" name="x2" />
							<input type="hidden" id="y2" name="y2" />
							<input type="hidden" id="w" name="w" />
							<input type="hidden" id="h" name="h" />
                        </div>
                        
                        {/if}
	                </td>
	            </tr>
                
                <tr>
                    <td class="left">{get_label('image_link')}</td>
                    <td class="left"><input type="text" name="image_link" value="{set_value('image_link',$edit_module.image_link)}" /></td>
                </tr>
                
	            <tr>
                    <td class="left head"><span class="required">*</span> {get_label('photo_category_id')}</td>
                    <td class="left">
                       <select name="photo_category_id" id="photo_category_id">
                           <option value="0">{lang('Select parent')}</option>
                           {$category_html = '<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
                           {$indent_symbol = '-&nbsp;'}
                           {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, array($edit_module.photo_category_id))}
                        </select>
                    </td>
                </tr>
                
	            <tr>
                    <td class="left head"><span class="required">*</span> {get_label('photo_album_id')}</td>
                    <td class="left">
                        <select name="photo_album_id" id="photo_album_id">                            
                            {foreach $albums as $album}
                                <option value="{$album.id}" {if $album.id==$edit_module.photo_album_id}selected{/if}>{lang($album.name)}</option>
                            {foreachelse}
                                <option value="0">{lang('No Album')}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                
	            <tr>
	                <td class="left head"><span class="required">*</span> {get_label('name')}</td>
	                <td class="left"><input type="text" name="name" value="{set_value('name',$edit_module.name)}" /></td>
	            </tr> 
                
	            <tr>
	                <td class="left head">{get_label('description')}</td>
	                <td class="left"><textarea rows="5" cols="33" name="description">{set_value('description',$edit_module.description)}</textarea></td>
	            </tr>
                
	            <tr>
	                <td class="left head">{get_label('slug')}</td>
	                <td class="left"><input type="text" name="slug" value="{set_value('slug',$edit_module.slug)}" /></td>
	            </tr>
                
	            <tr>
                    <td class="left head">{get_label('username')}</td>
                    <td class="left"><input type="text" name="weight" value="{set_value('username',$edit_module.username)}" /></td>
                </tr>
                
                <tr>
                    <td class="left head"></td>
                    <td class="left">
                    <img src="{base_url()}media/images/{get_image_thumb($edit_module.image_name,'crop_crop')}" width="100" />
                    </td>
                </tr>
	            
            </tbody>
        </table>
    </form>
	<img src="{base_url()}media/images/{$edit_module.image_name}" id="cropbox" />
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#photo_category_id').change(function() {
        $.post('{base_url()}photos/admin_photos/getAlbums/'+$('#photo_category_id').val()+'/1',
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

    $(function(){

		$('#cropbox').Jcrop({
			aspectRatio: 1.5,
			onSelect: updateCoords
		});

	});
    function updateCoords(c)
	{
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#x2').val(c.x2);
		$('#y2').val(c.y2);
		$('#w').val(c.w);
		$('#h').val(c.h);
	};
});
</script>
