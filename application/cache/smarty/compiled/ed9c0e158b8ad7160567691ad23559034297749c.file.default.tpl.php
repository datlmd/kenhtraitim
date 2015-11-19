<?php /* Smarty version Smarty-3.1.1, created on 2015-05-12 11:31:06
         compiled from "application/views/default\layouts\default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:138585502a38521d4d8-32163092%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed9c0e158b8ad7160567691ad23559034297749c' => 
    array (
      0 => 'application/views/default\\layouts\\default.tpl',
      1 => 1431405059,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '138585502a38521d4d8-32163092',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_5502a38524846',
  'variables' => 
  array (
    'cate_le' => 0,
    'cate' => 0,
    'cate_bo' => 0,
    'MainContent' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5502a38524846')) {function content_5502a38524846($_smarty_tpl) {?><!DOCTYPE html>
<head>        
    <?php echo $_smarty_tpl->getSubTemplate ((theme_web()).('/layouts/_head.inc.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>

<body>
    <!--header-->
	<div class="back">
		<img src="<?php echo static_frontend();?>
images/back.png" alt="">
	</div>	
	<div class="container">
		<div class="main-top">
			<div class="main">
				<div class="header">
					<div class="header-top">
						<div class="header-in">
							<div class="logo">
								<a href="<?php echo base_url();?>
"><img src="<?php echo static_frontend();?>
images/logo.png" alt="" ></a>
							</div>
							<div class="search">
								<form>
									<input type="text" value="" >
									<input type="submit" value="SEARCH">
								</form>
							</div>
							<div class="clearfix"> </div>
						</div>
<!--						<div class="header-top-on">-->
<!--							<ul class="social-in">-->
<!--								<li><a href="#"><i> </i></a></li>						-->
<!--								<li><a href="#"><i class="facebook"> </i></a></li>-->
<!--								<li><a href="#"><i class="tin"> </i></a></li>-->
<!--							</ul>-->
<!--						</div>-->
						<div class="clearfix"> </div>
					</div>
					<!---->
					<div class="header-bottom">
						<div class="navigation">	
							<div>
							  <label class="mobile_menu" for="mobile_menu">
							  <span>Menu</span>
							  </label>
							  <input id="mobile_menu" type="checkbox">
								<ul class="nav">
									<li><a class="color1" href="<?php echo base_url();?>
">Trang chủ</a></li>                  
									<li><a href="<?php echo base_url();?>
phim-le.html" class="color2">Phim lẻ</a>
										<ul>
										<?php  $_smarty_tpl->tpl_vars['cate'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cate']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cate_le']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cate']->key => $_smarty_tpl->tpl_vars['cate']->value){
$_smarty_tpl->tpl_vars['cate']->_loop = true;
?>	
											<li><a href="<?php echo base_url();?>
<?php echo $_smarty_tpl->tpl_vars['cate']->value['slug'];?>
.html"><?php echo $_smarty_tpl->tpl_vars['cate']->value['name'];?>
</a></li>
										<?php } ?>
										</ul>
									</li>            
									<li><a href="<?php echo base_url();?>
phim-bo.html" class="color3">phim bộ</a>
										<ul>
										<?php  $_smarty_tpl->tpl_vars['cate'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cate']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cate_bo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cate']->key => $_smarty_tpl->tpl_vars['cate']->value){
$_smarty_tpl->tpl_vars['cate']->_loop = true;
?>	
											<li><a href="<?php echo base_url();?>
<?php echo $_smarty_tpl->tpl_vars['cate']->value['slug'];?>
.html"><?php echo $_smarty_tpl->tpl_vars['cate']->value['name'];?>
</a></li>
										<?php } ?>
										</ul>
									</li>						  
									<li class="dropdown"><a href="<?php echo base_url();?>
phim-3d.html" class="color4">Phim 3D<span> </span></a></li>  
									<li><a href="<?php echo base_url();?>
tintuc" class="color5">Tin tức</a></li>
<!--									<li><a href="contact.html" class="color6">Liên hệ</a></li>-->
									<div class="clearfix"></div>
								</ul>
							</div>			
						</div>
					</div>
				</div>
				<?php echo $_smarty_tpl->tpl_vars['MainContent']->value;?>

				
			</div>
			<i class="line"> </i>
			<i class="line-in"> </i>
			<i class="line-in line-in1"> </i>
			<i class="line-in line-in2"> </i>
		</div>
		<p class="footer-class">Copyright © 2015 kenhtraitim.com<br/>
			 <span style="font-size: 10px;">Phim được tổng hợp từ các nguồn trên mạng, chúng tôi không chịu trách nhiệm liên quan đến nội dung, chúng tôi sẽ loại bỏ toàn bộ các nội dụng không phù hợp với pháp luật của Việt Nam</span>
		</p>
		<script type="text/javascript">
							$(document).ready(function() {
								/*
								var defaults = {
						  			containerID: 'toTop', // fading element id
									containerHoverID: 'toTopHover', // fading element hover id
									scrollSpeed: 1200,
									easingType: 'linear' 
						 		};
								*/
								
								$().UItoTop({ easingType: 'easeOutQuart' });
								
							});
						</script>
					<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	
	
	</div>
    
    <!--------------------CORE FOOTER - NO DELETE----------------------------------------->
    <?php if (is_access('admin_users','r')){?>
        <div style="display:inline-block;position:fixed;right:5px;bottom:0;padding:5px 10px;background:#333333;font-weight:700;z-index:9999">
            <a href="<?php echo base_url('users/admin_users/dashboard');?>
" style=""><?php echo lang('Admin');?>
</a> |
            <a href="<?php echo base_url('users/logout');?>
" style=""><?php echo lang('Logout');?>
</a>
        </div>
    <?php }?>

<!--------------------END CORE FOOTER - NO DELETE----------------------------------------->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61959385-1', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html><?php }} ?>