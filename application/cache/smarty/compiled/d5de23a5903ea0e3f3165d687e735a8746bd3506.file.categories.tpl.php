<?php /* Smarty version Smarty-3.1.1, created on 2015-10-20 14:30:42
         compiled from "application/views/default/frontend/categories.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5875520655625eda2183388-23666481%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd5de23a5903ea0e3f3165d687e735a8746bd3506' => 
    array (
      0 => 'application/views/default/frontend/categories.tpl',
      1 => 1429791726,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5875520655625eda2183388-23666481',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cate_name' => 0,
    'films' => 0,
    'film' => 0,
    'i' => 0,
    'pagination_link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_5625eda225964',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5625eda225964')) {function content_5625eda225964($_smarty_tpl) {?><div class="category">
	<ul class="detail_list">
		<li><a href="<?php echo base_url();?>
">Trang chủ</a> ></li>
		<li><?php echo $_smarty_tpl->tpl_vars['cate_name']->value;?>
</li>
	</ul><br/>
	<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(1, null, 0);?>
	<?php  $_smarty_tpl->tpl_vars['film'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['film']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['films']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['film']->key => $_smarty_tpl->tpl_vars['film']->value){
$_smarty_tpl->tpl_vars['film']->_loop = true;
?>			
		<div class="col-md-2 category-item" title="<?php echo $_smarty_tpl->tpl_vars['film']->value['name'];?>
 - <?php echo $_smarty_tpl->tpl_vars['film']->value['name_en'];?>
 (<?php echo $_smarty_tpl->tpl_vars['film']->value['year'];?>
)">			
			<a href="<?php echo base_url();?>
phim-<?php echo $_smarty_tpl->tpl_vars['film']->value['slug'];?>
-<?php echo $_smarty_tpl->tpl_vars['film']->value['id'];?>
.html"><img class="img-responsive" src="<?php echo $_smarty_tpl->tpl_vars['film']->value['image_small'];?>
" width="100%" alt="<?php echo $_smarty_tpl->tpl_vars['film']->value['name'];?>
 - <?php echo $_smarty_tpl->tpl_vars['film']->value['name_en'];?>
 - kenhtraitim.com">
				<span class="labelchap2"><?php echo $_smarty_tpl->tpl_vars['film']->value['quality'];?>
 | <?php echo $_smarty_tpl->tpl_vars['film']->value['subtitle'];?>
</span>
			</a>									
			<div class="caption">							
				<h3 class="cinema">	
					<a href="<?php echo base_url();?>
phim-<?php echo $_smarty_tpl->tpl_vars['film']->value['slug'];?>
-<?php echo $_smarty_tpl->tpl_vars['film']->value['id'];?>
.html"><?php echo $_smarty_tpl->tpl_vars['film']->value['name'];?>
 (<?php echo $_smarty_tpl->tpl_vars['film']->value['year'];?>
)</a><br />
					<a class="title_en" href="<?php echo base_url();?>
phim-<?php echo $_smarty_tpl->tpl_vars['film']->value['slug'];?>
-<?php echo $_smarty_tpl->tpl_vars['film']->value['id'];?>
.html"><?php echo $_smarty_tpl->tpl_vars['film']->value['name_en'];?>
</a>
				</h3>	
			</div>									
		</div>	
		<?php if ($_smarty_tpl->tpl_vars['i']->value==14){?>
			<div class="clearfix"></div>
			<div class="adHome">
				<img class="img-responsive"  border="0" src="<?php echo static_frontend();?>
images/bn1.jpg" id="cpm9981">
			</div>
			<div class="clearfix"></div>
		<?php }?>
		<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>							
	<?php } ?>  
	<div class="clearfix"></div>
	<?php echo $_smarty_tpl->tpl_vars['pagination_link']->value;?>
		
</div>
<div class="clearfix"></div>
<!----><?php }} ?>