<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 15:25:37
         compiled from "application/views/default\users\admin_users\dashboard.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17354552394817a7d27-96379748%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eb85144e556e30aafaf1b36e643f88d92e2954b5' => 
    array (
      0 => 'application/views/default\\users\\admin_users\\dashboard.tpl',
      1 => 1425626154,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17354552394817a7d27-96379748',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'icons' => 0,
    'icon' => 0,
    'users' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_552394818d0b9',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552394818d0b9')) {function content_552394818d0b9($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Dashboard');?>
</h1>
    
    <div class=buttons>
        <a href="#this" class="button"><span><?php echo lang('Refresh');?>
</span></a>        
    </div>
</div>
<div class="content">
    <div class="cpanel-left">
        <div class="cpanel">
            <?php  $_smarty_tpl->tpl_vars['icon'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['icon']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['icons']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['icon']->key => $_smarty_tpl->tpl_vars['icon']->value){
$_smarty_tpl->tpl_vars['icon']->_loop = true;
?>
                <div class="icon-wrapper">
                    <div class="icon">
                        <a href="<?php echo base_url();?>
<?php echo $_smarty_tpl->tpl_vars['icon']->value['link'];?>
">
                            <img src="<?php echo static_base();?>
images/admin/<?php echo $_smarty_tpl->tpl_vars['icon']->value['image'];?>
" alt="">
                            <span><?php echo $_smarty_tpl->tpl_vars['icon']->value['label'];?>
</span>
                        </a>
                    </div>
                </div>
            <?php } ?>            
        </div>
    </div>
        
    <div class="cpanel-right">
        <table class="list">
            <thead>
                <tr>
                    <td class="center" colspan="5">Top user login</td>
                </tr>
                
                <tr>
                    <td class="left"><?php echo lang('User name');?>
</td>
                    <td class="left"><?php echo lang('Full name');?>
</td>
                    <td class="left"><?php echo lang('Login date');?>
</td>
                    <td class="left"><?php echo lang('ID');?>
</td>
                    <td class="left"><?php echo lang('Role');?>
</td>
                </tr>
            </thead>
            <tbody>
                <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['users']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
                    <tr>
                        <td class="left"><?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
</td>
                        <td class="left"><?php echo $_smarty_tpl->tpl_vars['user']->value['full_name'];?>
</td>
                        <td class="left"><?php echo $_smarty_tpl->tpl_vars['user']->value['login_created'];?>
</td>
                        <td class="left"><?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
</td>
                        <td class="left"><?php echo $_smarty_tpl->tpl_vars['user']->value['role'];?>
</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <div class="clr"></div>
</div><?php }} ?>