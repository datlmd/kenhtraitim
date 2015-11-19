<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 16:25:09
         compiled from "application/views/default\photos\admin_photos\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:227635523a2758a0590-03667845%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c61201dbfa4c43743e5fb5046f02994f26e3154' => 
    array (
      0 => 'application/views/default\\photos\\admin_photos\\index.tpl',
      1 => 1425626155,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '227635523a2758a0590-03667845',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'this_resource' => 0,
    'cf_names' => 0,
    'cfn' => 0,
    'cfn_id' => 0,
    'categories' => 0,
    'category_html' => 0,
    'indent_symbol' => 0,
    'photo_album_ids' => 0,
    'photo_album_id' => 0,
    'photo_status_ids' => 0,
    'photo_status_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_5523a2759d8d9',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5523a2759d8d9')) {function content_5523a2759d8d9($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Photo manager');?>
</h1>
    
    <div class=buttons>
        <a href="<?php echo base_url('photos/admin_photos/add');?>
" class="button"><span><?php echo lang('Add');?>
</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span><?php echo lang('Delete');?>
</span></a>
        <a href="javascript:void(0);" class="button JsActionPublish"><span><?php echo lang('Publish');?>
</span></a>
        <a href="javascript:void(0);" class="button JsActionUnPublish"><span><?php echo lang('Hide');?>
</span></a>
        
        <a href="<?php echo base_url();?>
custom_fields/admin_custom_field_names/index/<?php echo $_smarty_tpl->tpl_vars['this_resource']->value;?>
" class="button"><span><?php echo lang('Custom field');?>
</span></a>
        <?php if ($_smarty_tpl->tpl_vars['cf_names']->value!=false){?>
            <select class="JsCustomFieldChange">
                <?php  $_smarty_tpl->tpl_vars['cfn'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cfn']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cf_names']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cfn']->key => $_smarty_tpl->tpl_vars['cfn']->value){
$_smarty_tpl->tpl_vars['cfn']->_loop = true;
?>
                    <option value="<?php echo base_url('modules/admin_modules/index/');?>
/<?php echo $_smarty_tpl->tpl_vars['cfn']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['cfn_id']->value==$_smarty_tpl->tpl_vars['cfn']->value['id']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['cfn']->value['name'];?>
</option>
                <?php } ?>
            </select>
        <?php }?>
    </div>
</div>
<div class="content">
    <form action="" method="get" id="FilterUser">
        <table class="filter">
            <tbody>
                <tr>
                    <td>
                        <label><?php echo lang('Category');?>
</label>
                        <select name="photo_category_id" id="photo_category_id">
                            <option value=""><?php echo lang('All');?>
</option>
                            <?php $_smarty_tpl->tpl_vars['category_html'] = new Smarty_variable('<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>', null, 0);?>
                            <?php $_smarty_tpl->tpl_vars['indent_symbol'] = new Smarty_variable('-&nbsp;', null, 0);?>
                            <?php echo draw_tree_category_block($_smarty_tpl->tpl_vars['categories']->value,$_smarty_tpl->tpl_vars['category_html']->value,0,$_smarty_tpl->tpl_vars['indent_symbol']->value,array($_GET['photo_category_id']));?>

                        </select>
                    </td>
                    <td>
                        <label><?php echo lang('Album');?>
</label>
                        <select name="photo_album_id" id="photo_album_id">
                            <?php  $_smarty_tpl->tpl_vars['photo_album_id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['photo_album_id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['photo_album_ids']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['photo_album_id']->key => $_smarty_tpl->tpl_vars['photo_album_id']->value){
$_smarty_tpl->tpl_vars['photo_album_id']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['photo_album_id']->value['id'];?>
" <?php if ($_GET['photo_album_id']!=''&&$_GET['photo_album_id']==$_smarty_tpl->tpl_vars['photo_album_id']->value['id']){?>selected<?php }?>><?php echo lang($_smarty_tpl->tpl_vars['photo_album_id']->value['name']);?>
</option>
                            <?php } ?>                   
                        </select>
                    </td>
                    
                    <td>
                        <label><?php echo lang('Status');?>
</label>
                        <select name="photo_status_id">
                            <option value=""><?php echo lang('All');?>
</option>
                            <?php  $_smarty_tpl->tpl_vars['photo_status_id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['photo_status_id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['photo_status_ids']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['photo_status_id']->key => $_smarty_tpl->tpl_vars['photo_status_id']->value){
$_smarty_tpl->tpl_vars['photo_status_id']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['photo_status_id']->value['id'];?>
" <?php if ($_GET['photo_status_id']!=''&&$_GET['photo_status_id']==$_smarty_tpl->tpl_vars['photo_status_id']->value['id']){?>selected<?php }?>><?php echo lang($_smarty_tpl->tpl_vars['photo_status_id']->value['name']);?>
</option>
                            <?php } ?>
                        </select>
                    </td>
                    
                    <td>
                        <label><?php echo lang('From date');?>
</label>
                        <input type="text" name="from_date" class="pgDate" value="<?php echo $_GET['from_date'];?>
" />
                    </td>
                    
                    <td>
                        <label><?php echo lang('To date');?>
</label>
                        <input type="text" name="to_date" class="pgDate" value="<?php echo $_GET['to_date'];?>
" />
                    </td>
                    <td>
                        <label><?php echo lang('Name');?>
</label>
                        <input type="text" name="name" value="<?php echo $_GET['name'];?>
" />
                    </td>
                    
                    <td><a onclick="$('#FilterUser').submit();" href="javascript:void(0);" class="button"><span><?php echo lang('Filter');?>
</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
    <form action="<?php echo base_url('photos/admin_photos/delete');?>
" class="JsDeleteForm" method="post">
        <input type="hidden" name="publish_type" value="0" />
        <input type="hidden" name="p_redirect" value="0" />
        <?php echo $_smarty_tpl->getSubTemplate ("../../elements/list_view.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </form>
</div>


    <script type="text/javascript">
    $('document').ready(function() {
        $('input[name="p_redirect"]').val(document.location.href);
    });
    </script>


<script type="text/javascript">
    $(document).ready(function(){
        $('#photo_category_id').change(function() {
            var url_get_album = '';
            var photo_category_id = $('#photo_category_id').val();
            if(photo_category_id == '')
                photo_category_id = 'all';

            $.post('<?php echo base_url();?>
photos/admin_photos/getAlbums/' + photo_category_id +'/1',
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
        //Load lại trang  1 lần để lấy đúng loại
    });
</script><?php }} ?>