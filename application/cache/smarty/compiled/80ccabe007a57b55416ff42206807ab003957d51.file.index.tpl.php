<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 15:31:45
         compiled from "application/views/default\films\admin_films\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3792552395f15a2b90-31459418%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '80ccabe007a57b55416ff42206807ab003957d51' => 
    array (
      0 => 'application/views/default\\films\\admin_films\\index.tpl',
      1 => 1428395490,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3792552395f15a2b90-31459418',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'this_resource' => 0,
    'cf_names' => 0,
    'cfn' => 0,
    'cfn_id' => 0,
    'extra_params' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_552395f166221',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552395f166221')) {function content_552395f166221($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Admin films manager');?>
</h1>

    <div class=buttons>
        <a href="<?php echo base_url('films/admin_films/add');?>
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
                    <option value="<?php echo base_url('films/admin_films/index/');?>
/<?php echo $_smarty_tpl->tpl_vars['cfn']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['cfn_id']->value==$_smarty_tpl->tpl_vars['cfn']->value['id']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['cfn']->value['name'];?>
</option>
                <?php } ?>
            </select>
        <?php }?>
    </div>
</div>

<div class="content">
    
    <form action="" method="get" id="FilterForm">
        <table class="filter">
            <tbody>
                <tr>
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
                    
                    <td><a onclick="$('#FilterForm').submit();" href="javascript:void(0);" class="button"><span><?php echo lang('Filter');?>
</span></a></td>
                    <td><a href="<?php echo base_url('films/admin_films/export');?>
?<?php echo $_smarty_tpl->tpl_vars['extra_params']->value;?>
" class="button"><span><?php echo lang('Export');?>
</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
    <form action="<?php echo base_url('films/admin_films/delete');?>
" class="JsDeleteForm" method="post">
        <?php echo $_smarty_tpl->getSubTemplate ("../../elements/list_view.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </form>

</div>
<?php }} ?>