<?php /* Smarty version Smarty-3.1.1, created on 2015-05-12 17:22:50
         compiled from "application/views/default\frontend\tintuc.tpl" */ ?>
<?php /*%%SmartyHeaderCode:285055539d82ba9d505-50630291%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '970258359cae2dc9b7276a0c1b04c19532875ad5' => 
    array (
      0 => 'application/views/default\\frontend\\tintuc.tpl',
      1 => 1431426001,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '285055539d82ba9d505-50630291',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_5539d82baf340',
  'variables' => 
  array (
    'list_url' => 0,
    'url' => 0,
    'a' => 0,
    'list_all' => 0,
    'i' => 0,
    'article' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5539d82baf340')) {function content_5539d82baf340($_smarty_tpl) {?><span style="font-size: 11px;">Nội dung tin tức được Robot quét tự động trực tuyến không lưu dữ liệu với thao tác của người dùng từ các nguồn RSS trên mạng, chúng tôi không chịu trách nhiệm liên quan đến nội dung, chúng tôi sẽ loại bỏ toàn bộ các nội dụng không phù hợp với pháp luật của Việt Nam</span>
<div class="cate_news">
	Bạn muốn quét tin tức từ:	
	<img src="<?php echo static_frontend();?>
images/kenh14.png" alt="">
	<img src="<?php echo static_frontend();?>
images/vnexpress.png" alt="">
	<img src="<?php echo static_frontend();?>
images/logo_NS.png" alt="">
	<img src="<?php echo static_frontend();?>
images/logo_zing_trithuc.png" alt="">
	<img src="<?php echo static_frontend();?>
images/logo2saohd2.png" alt="">
	<img src="<?php echo static_frontend();?>
images/ngoisaovn.png" alt="">
	<img src="<?php echo static_frontend();?>
images/dantri.png" alt="">
	<img src="<?php echo static_frontend();?>
images/tuoitre.png" alt="">
	<img src="<?php echo static_frontend();?>
images/phapluat.png" alt="">
</div>
<div class="grid-top-in">
	<?php $_smarty_tpl->tpl_vars['a'] = new Smarty_variable(array('jol','lop','bun','live','dan','eva'), null, 0);?>
	<p>
	<?php  $_smarty_tpl->tpl_vars['url'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['url']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_url']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['url']->key => $_smarty_tpl->tpl_vars['url']->value){
$_smarty_tpl->tpl_vars['url']->_loop = true;
?>
		<a href="<?php echo base_url();?>
chuyenmuc?url=<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['a']->value[array_rand($_smarty_tpl->tpl_vars['a']->value,1)];?>
"><?php echo $_smarty_tpl->tpl_vars['url']->value['name'];?>
</a>
	<?php } ?>	
	</p>									 	
</div><br/>
<div class="clearfix"></div>
<div class="magazine">	
	<div class="magazine-top">
	<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(1, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_all']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value){
$_smarty_tpl->tpl_vars['article']->_loop = true;
?>
			<?php if ($_smarty_tpl->tpl_vars['i']->value<3){?>
			<div class="col-md-3">
				<a href="<?php echo base_url();?>
chitiet?url=<?php echo $_smarty_tpl->tpl_vars['article']->value['href'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
"><img class="img-responsive chain" width="357" src="<?php echo $_smarty_tpl->tpl_vars['article']->value['img'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
">					
				</a>
				<div class="magazine-grid">
					<h3><a href="<?php echo base_url();?>
chitiet?url=<?php echo $_smarty_tpl->tpl_vars['article']->value['href'];?>
"><?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
</a></h3>
					<span class="date_n"><a href="<?php echo $_smarty_tpl->tpl_vars['article']->value['url_cate'];?>
"><?php echo $_smarty_tpl->tpl_vars['article']->value['cate'];?>
</a> | <?php echo $_smarty_tpl->tpl_vars['article']->value['date'];?>
 (Nguồn: <b><?php echo $_smarty_tpl->tpl_vars['article']->value['domain'];?>
</b>)</span>
					<p><?php echo $_smarty_tpl->tpl_vars['article']->value['note'];?>
</p>					
				</div>
			</div>
			<?php }else{ ?>
				<div class="news-list">
					<a href="<?php echo base_url();?>
chitiet?url=<?php echo $_smarty_tpl->tpl_vars['article']->value['href'];?>
"><img class="img-responsive chain" width="357" src="<?php echo $_smarty_tpl->tpl_vars['article']->value['img'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
">	
					<?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
</a><br/>
					<span class="date_n"><a href="<?php echo $_smarty_tpl->tpl_vars['article']->value['url_cate'];?>
"><?php echo $_smarty_tpl->tpl_vars['article']->value['cate'];?>
</a> | <?php echo $_smarty_tpl->tpl_vars['article']->value['date'];?>
 (Nguồn: <b><?php echo $_smarty_tpl->tpl_vars['article']->value['domain'];?>
</b>)</span>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['i']->value==7){?>
				<div class="clearfix"></div>
				</div>
				<div class="magazine-top">
				<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, 0);?>
			<?php }?>
			<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
		<?php } ?>			
		<div class="clearfix"></div>
	</div>
</div><?php }} ?>