<?php /* Smarty version Smarty-3.1.1, created on 2015-06-19 16:40:51
         compiled from "application/views/default/frontend/chitiet.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2488776615583e3a3298167-78059440%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a0075a7ca4020405c78075cf290adec9c5b96622' => 
    array (
      0 => 'application/views/default/frontend/chitiet.tpl',
      1 => 1431511094,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2488776615583e3a3298167-78059440',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list_url' => 0,
    'url' => 0,
    'a' => 0,
    'title' => 0,
    'date_n' => 0,
    'url_root' => 0,
    'tomtat' => 0,
    'tags' => 0,
    'content' => 0,
    'url_cur' => 0,
    'focus' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_5583e3a338c75',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5583e3a338c75')) {function content_5583e3a338c75($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/Applications/XAMPP/xamppfiles/htdocs/product/film/application/third_party/Smarty/plugins/modifier.date_format.php';
?><span style="font-size: 11px;">Nội dung tin tức được Robot quét tự động trực tuyến không lưu dữ liệu với thao tác của người dùng từ các nguồn RSS trên mạng, chúng tôi không chịu trách nhiệm liên quan đến nội dung, chúng tôi sẽ loại bỏ toàn bộ các nội dụng không phù hợp với pháp luật của Việt Nam</span>

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
</div><br/><br/>
<!---->
<div class="content" id="content">
	<div class="col-md-8 content-top">
		<div class="content-news">
			<h3><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h3>	
			<span class="date"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['date_n']->value,"%d/%m/%Y %I:%M %p");?>
 - <b>Nguồn:</b> <a title="<?php echo $_smarty_tpl->tpl_vars['url_root']->value;?>
" target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['url_root']->value;?>
"><?php echo substr($_smarty_tpl->tpl_vars['url_root']->value,0,30);?>
...</a></span>					
			<p class="des"><?php echo $_smarty_tpl->tpl_vars['tomtat']->value;?>
</p>
			<div class="news-tag simply">
				<?php echo $_smarty_tpl->tpl_vars['tags']->value;?>

			</div>	
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

    	</div>
    	<div class="fb-google">				
				<!-- Place this tag in your head or just before your close body tag. -->
				<script src="https://apis.google.com/js/platform.js" async defer>
				  {
					  lang: 'vi'
				  }
				</script>			
				<!-- Place this tag where you want the +1 button to render. -->
				<div class="google" ><div class="g-plusone" data-annotation="none" data-size="medium" data-href="<?php echo $_smarty_tpl->tpl_vars['url_cur']->value;?>
"></div></div>
				<div class="fb-like" data-href="<?php echo $_smarty_tpl->tpl_vars['url_cur']->value;?>
" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
		</div>
    	<div class="clearfix"></div>
		<div class="comment-top">
<!--				<div class="story">-->
<!--					<h4 class="stories "><span>Bình luận</span></h4>-->
<!--				</div>-->
				<!---->
				
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.3&appId=1641296099425791";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<div class="fb-comments" data-href="<?php echo $_smarty_tpl->tpl_vars['url_cur']->value;?>
" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
			<!---->
		</div>	
		<!---->
		<div class="simply">
			<div class="story">
				<h4 class="stories stories-in"><span>Tin cùng chuyên mục</span></h4>
			</div>
			<?php echo $_smarty_tpl->tpl_vars['tags']->value;?>
				
			<div class="clearfix"></div>
		</div>		
	</div>
	<!---->
		<div class="col-md-4 sin-bottom">
			
			<div class="might">
				<h4>Tiêu điểm</h4>
				<div class="news-focus"><?php echo $_smarty_tpl->tpl_vars['focus']->value;?>
</div>
			</div>
			<div class="clearfix"></div>
			<!---->
<!--			<div class="grid-top">-->
<!--				<h4>Archives</h4>-->
<!--				<ul>-->
<!--					<li><a href="#">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </a></li>-->
<!--					<li><a href="#">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</a></li>-->
<!--					<li><a href="#">When an unknown printer took a galley of type and scrambled it to make a type specimen book. </a> </li>-->
<!--					<li><a href="#">It has survived not only five centuries, but also the leap into electronic typesetting</a> </li>-->
<!--					<li><a href="#">Remaining essentially unchanged. It was popularised in the 1960s with the release of </a> </li>-->
<!--					<li><a href="#">Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing </a> </li>-->
<!--					<li><a href="#">Software like Aldus PageMaker including versionsof Lorem Ipsum.</a> </li>-->
<!--				</ul>-->
<!--			</div>-->
			
			
		</div>
		<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
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
</div><?php }} ?>