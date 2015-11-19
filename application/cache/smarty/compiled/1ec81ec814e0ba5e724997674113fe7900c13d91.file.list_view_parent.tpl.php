<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 15:25:42
         compiled from "D:\xampp\htdocs\2015\film\application\views\default\elements\list_view_parent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:730455239486aa7798-84045653%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ec81ec814e0ba5e724997674113fe7900c13d91' => 
    array (
      0 => 'D:\\xampp\\htdocs\\2015\\film\\application\\views\\default\\elements\\list_view_parent.tpl',
      1 => 1425626160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '730455239486aa7798-84045653',
  'function' => 
  array (
    'list_view_parent' => 
    array (
      'parameter' => 
      array (
        'level' => 0,
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'category' => 0,
    'cat' => 0,
    'fields' => 0,
    'field' => 0,
    'field_show' => 0,
    'level' => 0,
    'field_type' => 0,
    'link_edit' => 0,
    'list_views' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_55239486c591c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55239486c591c')) {function content_55239486c591c($_smarty_tpl) {?>
<?php if (!function_exists('smarty_template_function_list_view_parent')) {
    function smarty_template_function_list_view_parent($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['list_view_parent']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
    <?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value){
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
        <tr>
            <td class="left"><input type="checkbox" name="listViewId[]" value="<?php echo $_smarty_tpl->tpl_vars['cat']->value['id'];?>
" class="listViewId" /></td>
            <?php  $_smarty_tpl->tpl_vars['field_type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field_type']->_loop = false;
 $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field_type']->key => $_smarty_tpl->tpl_vars['field_type']->value){
$_smarty_tpl->tpl_vars['field_type']->_loop = true;
 $_smarty_tpl->tpl_vars['field']->value = $_smarty_tpl->tpl_vars['field_type']->key;
?>
                <td class="left">
	                <?php if ($_smarty_tpl->tpl_vars['field']->value==$_smarty_tpl->tpl_vars['field_show']->value){?>
			            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int)ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['level']->value+1 - (0) : 0-($_smarty_tpl->tpl_vars['level']->value)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0){
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++){
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
	                        - &nbsp;
	                    <?php }} ?>
	                <?php }?>
                    <?php echo pg_field_value($_smarty_tpl->tpl_vars['cat']->value[$_smarty_tpl->tpl_vars['field']->value],$_smarty_tpl->tpl_vars['field_type']->value);?>

                </td>
            <?php } ?>
            <td class="left">
                <?php echo link_action($_smarty_tpl->tpl_vars['link_edit']->value,$_smarty_tpl->tpl_vars['cat']->value['id']);?>
                        
            </td>
        </tr>
        <?php if (isset($_smarty_tpl->tpl_vars['cat']->value['items'])){?>
            <?php smarty_template_function_list_view_parent($_smarty_tpl,array('category'=>$_smarty_tpl->tpl_vars['cat']->value,'level'=>$_smarty_tpl->tpl_vars['level']->value+1));?>

        <?php }?>
    <?php } ?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<table class="list">
    <?php if ($_smarty_tpl->tpl_vars['fields']->value==false){?>
        <tbody>
            <tr><td class="left"><?php echo lang('No record');?>
</td></tr>
        </tbody>
    <?php }else{ ?>
        <thead>
            <tr>
                <td class="left"><input type="checkbox" name="AllSelect" value="1" class="JsListViewId" /></td>
                <?php  $_smarty_tpl->tpl_vars['field_type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field_type']->_loop = false;
 $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field_type']->key => $_smarty_tpl->tpl_vars['field_type']->value){
$_smarty_tpl->tpl_vars['field_type']->_loop = true;
 $_smarty_tpl->tpl_vars['field']->value = $_smarty_tpl->tpl_vars['field_type']->key;
?>
                    <td class="left"><?php echo get_label($_smarty_tpl->tpl_vars['field']->value);?>
</td>
                <?php } ?>
                <td class="left"><?php echo lang('Action');?>
</td>
            </tr>
        </thead>

        <tbody>
            <?php smarty_template_function_list_view_parent($_smarty_tpl,array('category'=>$_smarty_tpl->tpl_vars['list_views']->value));?>

        </tbody>
    <?php }?>
</table><?php }} ?>