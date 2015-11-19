<?php /* Smarty version Smarty-3.1.1, created on 2015-04-23 18:54:57
         compiled from "application/views/default\frontend\detail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31228552ba04215f8a2-20288388%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '01f5ef40f881fdc4af5aeffb0e70538a79aa934e' => 
    array (
      0 => 'application/views/default\\frontend\\detail.tpl',
      1 => 1429790094,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31228552ba04215f8a2-20288388',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_552ba0421f3fe',
  'variables' => 
  array (
    'category_url' => 0,
    'url_cur' => 0,
    'film' => 0,
    'string_category' => 0,
    'film_tag' => 0,
    'film_cate' => 0,
    'film_view' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552ba0421f3fe')) {function content_552ba0421f3fe($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\xampp\htdocs\2015\film\application\third_party\Smarty\plugins\modifier.date_format.php';
?><div class="content">
	<div class=" content-top">
		<div class="number ">
			<ul class="detail_list">
				<li><a href="<?php echo base_url();?>
">Trang chủ</a> ></li>
				<li><?php echo $_smarty_tpl->tpl_vars['category_url']->value;?>
 ></li>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['url_cur']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['film']->value->name;?>
 - <?php echo $_smarty_tpl->tpl_vars['film']->value->name_en;?>
 <?php echo $_smarty_tpl->tpl_vars['film']->value->year;?>
</a></li>
			</ul>
			<img class="img-responsive detail-img" src="<?php echo $_smarty_tpl->tpl_vars['film']->value->image;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['film']->value->name;?>
">
			<h3 class="page-in"><?php echo $_smarty_tpl->tpl_vars['film']->value->name;?>
 <?php echo $_smarty_tpl->tpl_vars['film']->value->year;?>

				<span><b>Lượt xem:</b> <?php echo $_smarty_tpl->tpl_vars['film']->value->counter_view;?>
 - <b>Ngày đăng:</b> <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['film']->value->created,"%d/%m/%Y");?>
 - <b>Đóng góp:</b> <?php echo $_smarty_tpl->tpl_vars['film']->value->username;?>
</span>
			</h3>
			<h4 class="page-in"><?php echo $_smarty_tpl->tpl_vars['film']->value->name_en;?>
</h4>
			
			<div class="clearfix"></div>
			<div class="left-film">
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
				<p class="title">Nội dung phim</p>
				<p class="page-top"><?php echo $_smarty_tpl->tpl_vars['film']->value->description;?>
</p><br/>
				<div class="left">
					<p class="title">Thể loại: <span><?php echo $_smarty_tpl->tpl_vars['string_category']->value;?>
</span></p>
					<p class="title">Diễn viên: <span><?php echo $_smarty_tpl->tpl_vars['film']->value->actor;?>
</span></p>					
					
					<p class="title">Đạo diễn: <span><?php echo $_smarty_tpl->tpl_vars['film']->value->director;?>
</span></p>
				</div>
				<div class="right">
					<p class="title">Năm: <span><?php echo $_smarty_tpl->tpl_vars['film']->value->year;?>
</span></p>					
					<p class="title">Quốc gia: <span><?php echo $_smarty_tpl->tpl_vars['film']->value->country;?>
</span></p>					
					<p class="title">IMDB: <span><?php echo $_smarty_tpl->tpl_vars['film']->value->point_imdb;?>
</span></p>					
				</div>
			</div>	
			<div class="left-film">
				<p class="title">Trailer</p>	
				<div class="js-video [vimeo, widescreen]">		 
					<iframe width="560" height="315" src="<?php echo str_replace('&controls=0','',$_smarty_tpl->tpl_vars['film']->value->trailer);?>
" frameborder="0" allowfullscreen></iframe>
				</div>				
			</div>		
			<div class="clearfix"></div>
			<div class="link-download">
				<?php echo $_smarty_tpl->tpl_vars['film']->value->link_download;?>

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

		</div>
	</div>
	<!---->
	<?php if ($_smarty_tpl->tpl_vars['film_tag']->value){?>
			<div class="clearfix"></div>	
			<div class="cinema cinema_home">		
				<h1>Phim liên quan</h1>
				<div class="cinema-top">
					<?php  $_smarty_tpl->tpl_vars['film'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['film']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['film_tag']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['film']->key => $_smarty_tpl->tpl_vars['film']->value){
$_smarty_tpl->tpl_vars['film']->_loop = true;
?>			
						<div  class="col-md-2 top-cinema" title="<?php echo $_smarty_tpl->tpl_vars['film']->value['name'];?>
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
					<?php } ?>  
				</div>
			</div>
			<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['film_cate']->value){?>
	<div class="clearfix"></div>	
	<div class="cinema cinema_home">		
		<h1>Phim cùng thể loại</h1>
		<div class="cinema-top">
			<?php  $_smarty_tpl->tpl_vars['film'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['film']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['film_cate']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['film']->key => $_smarty_tpl->tpl_vars['film']->value){
$_smarty_tpl->tpl_vars['film']->_loop = true;
?>			
				<div  class="col-md-2 top-cinema" title="<?php echo $_smarty_tpl->tpl_vars['film']->value['name'];?>
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
			<?php } ?>  
		</div>
	</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['film_view']->value){?>
	<div class="clearfix"></div>	
	<div class="cinema cinema_home">		
		<h1>Phim xem nhiều nhất</h1>
		<div class="cinema-top">
			<?php  $_smarty_tpl->tpl_vars['film'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['film']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['film_view']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['film']->key => $_smarty_tpl->tpl_vars['film']->value){
$_smarty_tpl->tpl_vars['film']->_loop = true;
?>			
				<div  class="col-md-2 top-cinema" title="<?php echo $_smarty_tpl->tpl_vars['film']->value['name'];?>
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
			<?php } ?>  
		</div>
	</div>
	<?php }?>
	<div class="clearfix"></div>
</div><?php }} ?>