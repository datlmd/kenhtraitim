<?php /* Smarty version Smarty-3.1.1, created on 2015-04-16 12:07:13
         compiled from "application/views/default\custom_fields\admin_custom_field_names\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23451552f43818b2cf4-81093654%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed1c22679f852ef189abe0a880954a91e9d44525' => 
    array (
      0 => 'application/views/default\\custom_fields\\admin_custom_field_names\\index.tpl',
      1 => 1425626154,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23451552f43818b2cf4-81093654',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'resource' => 0,
    'this_resource' => 0,
    'cf_names' => 0,
    'cfn' => 0,
    'cfn_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_552f4381a6c42',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552f4381a6c42')) {function content_552f4381a6c42($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Custom field manager');?>
</h1>
    
    <div class=buttons>        
        <a href="<?php echo base_url('custom_fields/admin_custom_fields/add');?>
/<?php echo $_smarty_tpl->tpl_vars['resource']->value;?>
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
                    <option value="<?php echo base_url('custom_fields/admin_custom_fields/index/');?>
/<?php echo $_smarty_tpl->tpl_vars['cfn']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['cfn_id']->value==$_smarty_tpl->tpl_vars['cfn']->value['id']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['cfn']->value['name'];?>
</option>
                <?php } ?>
            </select>
        <?php }?>
    </div>
</div>
<div class="content">
    <form action="<?php echo base_url('custom_fields/admin_custom_field_names/delete');?>
" class="JsDeleteForm" method="post">
        <input type="hidden" name="cf_resource" value="<?php echo $_smarty_tpl->tpl_vars['resource']->value;?>
" />
        <?php echo $_smarty_tpl->getSubTemplate ("../../elements/list_view.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </form>    
</div><?php }} ?>