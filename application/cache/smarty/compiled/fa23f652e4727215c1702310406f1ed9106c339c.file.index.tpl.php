<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 15:31:39
         compiled from "application/views/default\articles\admin_article_categories\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17218552395eb481a99-38549031%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa23f652e4727215c1702310406f1ed9106c339c' => 
    array (
      0 => 'application/views/default\\articles\\admin_article_categories\\index.tpl',
      1 => 1425626157,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17218552395eb481a99-38549031',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'this_resource' => 0,
    'cf_names' => 0,
    'cfn' => 0,
    'cfn_id' => 0,
    'category_status_ids' => 0,
    'category_status_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_552395eb63ef9',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552395eb63ef9')) {function content_552395eb63ef9($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Category manager');?>
</h1>
    
    <div class=buttons>                
        <a href="<?php echo base_url('articles/admin_article_categories/add');?>
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
                        <label><?php echo lang('Status');?>
</label>
                        <select name="category_status_id">
                            <option value=""><?php echo lang('All');?>
</option>
                            <?php  $_smarty_tpl->tpl_vars['category_status_id'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category_status_id']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category_status_ids']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category_status_id']->key => $_smarty_tpl->tpl_vars['category_status_id']->value){
$_smarty_tpl->tpl_vars['category_status_id']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['category_status_id']->value['id'];?>
" <?php if ($_GET['category_status_id']!=''&&$_GET['category_status_id']==$_smarty_tpl->tpl_vars['category_status_id']->value['id']){?>selected<?php }?>><?php echo lang($_smarty_tpl->tpl_vars['category_status_id']->value['name']);?>
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
                        <label><?php echo lang('name');?>
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
    
    <form action="<?php echo base_url('articles/admin_article_categories/delete');?>
" class="JsDeleteForm" method="post">
        <?php echo $_smarty_tpl->getSubTemplate ("./list_view.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </form>
</div><?php }} ?>