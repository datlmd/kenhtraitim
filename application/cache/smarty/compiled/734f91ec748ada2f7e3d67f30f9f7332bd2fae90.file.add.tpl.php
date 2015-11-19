<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 16:25:30
         compiled from "application/views/default\photos\admin_photos\add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:301085523a28a024798-94581947%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '734f91ec748ada2f7e3d67f30f9f7332bd2fae90' => 
    array (
      0 => 'application/views/default\\photos\\admin_photos\\add.tpl',
      1 => 1425626155,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '301085523a28a024798-94581947',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'photo_status_ids' => 0,
    'photo_status_id' => 0,
    'categories' => 0,
    'category_html' => 0,
    'indent_symbol' => 0,
    'selected_category_id' => 0,
    'albums' => 0,
    'album' => 0,
    'selected_album_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_5523a28a12649',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5523a28a12649')) {function content_5523a28a12649($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Add photo');?>
</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddUsers').submit();" class="button"><span><?php echo lang('Save');?>
</span></a>
    </div>
</div>

<div class="content">
    <?php echo validation_errors();?>

        
    <form action="" method="post" id="FormAddUsers">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left"><?php echo get_label('photo_status_id');?>
</td>
                    <td class="left">
                        <select name="photo_status_id">                            
                            <?php  $_smarty_tpl->tpl_vars['photo_status_id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['photo_status_id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['photo_status_ids']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['photo_status_id']->key => $_smarty_tpl->tpl_vars['photo_status_id']->value){
$_smarty_tpl->tpl_vars['photo_status_id']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['photo_status_id']->value['id'];?>
" <?php echo set_select('photo_status_id',$_smarty_tpl->tpl_vars['photo_status_id']->value['id']);?>
><?php echo lang($_smarty_tpl->tpl_vars['photo_status_id']->value['name']);?>
</option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>        
                <tr>
                    <td class="left"><span class="required">*</span> <?php echo get_label('photo_category_id');?>
</td>
                    <td class="left">
                        <select name="photo_category_id" id="photo_category_id">
                           <option value="0"><?php echo lang('Select category');?>
</option>
                           <?php $_smarty_tpl->tpl_vars['category_html'] = new Smarty_variable('<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>', null, 0);?>
                           <?php $_smarty_tpl->tpl_vars['indent_symbol'] = new Smarty_variable('-&nbsp;', null, 0);?>
                           <?php echo draw_tree_category_block($_smarty_tpl->tpl_vars['categories']->value,$_smarty_tpl->tpl_vars['category_html']->value,0,$_smarty_tpl->tpl_vars['indent_symbol']->value,$_smarty_tpl->tpl_vars['selected_category_id']->value);?>

                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left"><span class="required">*</span> <?php echo get_label('photo_album_id');?>
</td>
                    <td class="left">
                        <select name="photo_album_id" id="photo_album_id">                            
                            <?php  $_smarty_tpl->tpl_vars['album'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['album']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['albums']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['album']->key => $_smarty_tpl->tpl_vars['album']->value){
$_smarty_tpl->tpl_vars['album']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['album']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['album']->value['id']==$_smarty_tpl->tpl_vars['selected_album_id']->value){?>selected<?php }?>><?php echo lang($_smarty_tpl->tpl_vars['album']->value['name']);?>
</option>
                            <?php }
if (!$_smarty_tpl->tpl_vars['album']->_loop) {
?>
                                <option value="0"><?php echo lang('No Album');?>
</option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left"><span class="required">*</span> <?php echo get_label('name');?>
</td>
                    <td class="left"><input type="text" name="name" value="<?php echo set_value('name');?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('description');?>
</td>
                    <td class="left"><textarea rows="5" cols="33" name="description"><?php echo set_value('description');?>
</textarea></td>
                </tr>
                
                <tr>
                    <td class="left"><span class="required">*</span> <?php echo get_label('image_name');?>
</td>
                    <td class="left">
                        <input type="hidden" name="image_name" value="<?php echo set_value('image_name');?>
" />
                        <?php if ($_POST['image_name']==false){?>
                        <div id="btnAvatarUpload" class="button-upload"><?php echo lang('Upload');?>
</div>
                        <div class="image-medium-thum"></div>
                        <?php }else{ ?>
                            <div id="btnAvatarUpload" class="button-upload"><?php echo lang('Upload');?>
</div>
                        <div class="image-medium-thum"><img src="<?php echo (image_url()).(set_value('image_name'));?>
"/></div>
                        <?php }?>
                    </td>
                </tr>
                
                <tr>
                    <td class="left"><?php echo get_label('image_link');?>
</td>
                    <td class="left"><input type="text" name="image_link" value="<?php echo set_value('image_link');?>
" /></td>
                </tr>
                         
            </tbody>
        </table>
    </form>

</div>

<script type="text/javascript">
$(document).ready(function() {
	$('select[name=photo_status_id]').val(1);
	$('#photo_category_id').change(function() {
		$.post('<?php echo base_url();?>
photos/admin_photos/getAlbumsForAddFunction/'+$('#photo_category_id').val()+'/1',
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
			    		$('#photo_album_id').html('<option value="0"><?php echo lang('No Album');?>
</option>');
			    	}
			    });
		return false;
	});
});
</script>
<?php }} ?>