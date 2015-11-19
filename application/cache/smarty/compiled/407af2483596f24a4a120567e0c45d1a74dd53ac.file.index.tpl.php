<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 15:25:42
         compiled from "application/views/default\musics\admin_music_categories\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:164275523948694bc87-67746672%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '407af2483596f24a4a120567e0c45d1a74dd53ac' => 
    array (
      0 => 'application/views/default\\musics\\admin_music_categories\\index.tpl',
      1 => 1425626157,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '164275523948694bc87-67746672',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'this_resource' => 0,
    'cf_names' => 0,
    'cfn' => 0,
    'cfn_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_55239486a41e7',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55239486a41e7')) {function content_55239486a41e7($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Music categories manager');?>
</h1>

    <div class=buttons>
        <a href="<?php echo base_url('musics/admin_music_categories/add');?>
" class="button"><span><?php echo lang('Add');?>
</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span><?php echo lang('Delete');?>
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
                    <option value="<?php echo base_url('musics/admin_music_categories/index/');?>
/<?php echo $_smarty_tpl->tpl_vars['cfn']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['cfn_id']->value==$_smarty_tpl->tpl_vars['cfn']->value['id']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['cfn']->value['name'];?>
</option>
                <?php } ?>
            </select>
        <?php }?>
    </div>
</div>

<div class="content">
    
    <form action="" method="get" id="MusicsSearch">
        <table class="filter">
            <tbody>
                <tr>
                    
                    <td>
                        <label><?php echo lang('Name');?>
</label>
                        <input type="text" name="name" value="<?php echo $_GET['name'];?>
" />
                    </td>                    
				
                    <td><a onclick="$('#MusicsSearch').submit();" href="javascript:void(0);" class="button"><span><?php echo lang('Filter');?>
</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>

    <form action="<?php echo base_url('musics/admin_music_categories/delete');?>
" class="JsDeleteForm" method="post">
        <?php echo $_smarty_tpl->getSubTemplate ("../../elements/list_view_parent.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </form>

</div>
<?php }} ?>