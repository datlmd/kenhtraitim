<?php /* Smarty version Smarty-3.1.1, created on 2015-04-16 12:07:16
         compiled from "application/views/default\custom_fields\admin_custom_fields\edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5966552f4384e0b4e1-55710158%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c57740cfa2070c328fe3a806e660b238a944876' => 
    array (
      0 => 'application/views/default\\custom_fields\\admin_custom_fields\\edit.tpl',
      1 => 1425626154,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5966552f4384e0b4e1-55710158',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cfn_obj' => 0,
    'cfn_id' => 0,
    'module_fields' => 0,
    'module_field' => 0,
    'custom_fields' => 0,
    'this' => 0,
    'custom_field' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_552f4384f287d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552f4384f287d')) {function content_552f4384f287d($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Edit');?>
 <?php echo lang('Custom field');?>
: <?php echo $_smarty_tpl->tpl_vars['cfn_obj']->value->name;?>
</h1>
    
    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditCustomField').submit();" class="button"><span><?php echo lang('Edit');?>
</span></a>        
    </div>
</div>
    
<div class="content">
    <form action="<?php echo base_url();?>
custom_fields/admin_custom_fields/edit" method="post" id="FormEditCustomField">
        <input type="hidden" name="cfn_id" value="<?php echo $_smarty_tpl->tpl_vars['cfn_id']->value;?>
" />
        <input type="hidden" name="resource_id" value="<?php echo $_smarty_tpl->tpl_vars['cfn_obj']->value->resource_id;?>
" />
        
        <table class="form">
            <tbody>
                <tr>
                    <td><?php echo lang('Custom field name');?>
</td>
                    <td><input type="text" name="cfn_name" value="<?php echo $_smarty_tpl->tpl_vars['cfn_obj']->value->name;?>
" /></td>
                    <td><?php echo lang('Current');?>
</td>
                </tr>
                
                <tr>
                    <td><?php echo lang('Field');?>
</td>
                    <td>
                        <?php  $_smarty_tpl->tpl_vars['module_field'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module_field']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['module_fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module_field']->key => $_smarty_tpl->tpl_vars['module_field']->value){
$_smarty_tpl->tpl_vars['module_field']->_loop = true;
?>
                            <div class="line">
                                <input type="checkbox" name="field_choose[]" value="<?php echo $_smarty_tpl->tpl_vars['module_field']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['this']->value->is_check($_smarty_tpl->tpl_vars['module_field']->value['name'],$_smarty_tpl->tpl_vars['custom_fields']->value)){?>checked<?php }?>/> <?php echo get_label($_smarty_tpl->tpl_vars['module_field']->value['name']);?>

                            </div>
                        <?php } ?>
                    </td>
                    <td>
                        <?php  $_smarty_tpl->tpl_vars['custom_field'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['custom_field']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['custom_fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['custom_field']->key => $_smarty_tpl->tpl_vars['custom_field']->value){
$_smarty_tpl->tpl_vars['custom_field']->_loop = true;
?>
                            <div class="line"><?php echo get_label($_smarty_tpl->tpl_vars['custom_field']->value['name']);?>
</div>
                        <?php } ?>
                    </td>
                </tr>                
            </tbody>
        </table>
    </form>
</div><?php }} ?>