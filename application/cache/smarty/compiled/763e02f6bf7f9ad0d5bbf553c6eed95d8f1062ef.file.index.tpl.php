<?php /* Smarty version Smarty-3.1.1, created on 2015-04-24 12:15:24
         compiled from "application/views/default\frontend\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:143175502a385188d91-85731367%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '763e02f6bf7f9ad0d5bbf553c6eed95d8f1062ef' => 
    array (
      0 => 'application/views/default\\frontend\\index.tpl',
      1 => 1429852522,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143175502a385188d91-85731367',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_5502a3851f254',
  'variables' => 
  array (
    'film_focus' => 0,
    'film' => 0,
    'film_hot' => 0,
    'film_le' => 0,
    'film_bo' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5502a3851f254')) {function content_5502a3851f254($_smarty_tpl) {?><div class="gallery">
	<!-- requried-jsfiles-for owl -->
	<link href="<?php echo static_frontend();?>
css/owl.carousel.css" rel="stylesheet">
	<script src="<?php echo static_frontend();?>
js/owl.carousel.js"></script>
	<script>
		$(document).ready(function() {
			$("#owl-demo").owlCarousel({
				singleItem:true,
				lazyLoad : true,
				autoPlay : true,
				pagination : true,
				navigation : true,
				navigationText :  true,			     
			});
//
//			$(".cinema_home #slide_cate").owlCarousel({
//				//items : 1,
//				lazyLoad : true,
//				autoPlay : false,
//				pagination : false,
//				navigation : false,
//				navigationText :  false,		     
//			});
		});
	</script>
	<!-- //requried-jsfiles-for owl -->
	<!-- start content_slider -->
	<div id="owl-demo" class="owl-carousel">
	<?php  $_smarty_tpl->tpl_vars['film'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['film']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['film_focus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['film']->key => $_smarty_tpl->tpl_vars['film']->value){
$_smarty_tpl->tpl_vars['film']->_loop = true;
?>
		<div class="item g1" title="<?php echo $_smarty_tpl->tpl_vars['film']->value['name'];?>
 - <?php echo $_smarty_tpl->tpl_vars['film']->value['name_en'];?>
 (<?php echo $_smarty_tpl->tpl_vars['film']->value['year'];?>
)">
			<a href="<?php echo base_url();?>
phim-<?php echo $_smarty_tpl->tpl_vars['film']->value['slug'];?>
-<?php echo $_smarty_tpl->tpl_vars['film']->value['id'];?>
.html"><img class="lazyOwl" data-src="<?php echo $_smarty_tpl->tpl_vars['film']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['film']->value['name'];?>
 - <?php echo $_smarty_tpl->tpl_vars['film']->value['name_en'];?>
 - kenhtraitim.com"></a>
			<h3 class="cinema-focus">	
				<a href="<?php echo base_url();?>
phim-<?php echo $_smarty_tpl->tpl_vars['film']->value['slug'];?>
-<?php echo $_smarty_tpl->tpl_vars['film']->value['id'];?>
.html"><?php echo $_smarty_tpl->tpl_vars['film']->value['name'];?>
 - <?php echo $_smarty_tpl->tpl_vars['film']->value['name_en'];?>
 (<?php echo $_smarty_tpl->tpl_vars['film']->value['year'];?>
)</a><br />
			</h3>				
		</div>
	<?php } ?>
	</div>
	<!--//sreen-gallery-cursual---->
</div>
			

				<!-- main -->
<div class="content">
	<div class="cinema cinema_home">
		<h1>Phim HOT</h1>
		<div class="cinema-top">
			<?php  $_smarty_tpl->tpl_vars['film'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['film']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['film_hot']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
	<div class="clearfix"></div>
	<div class="adHome">
		<img class="img-responsive"  border="0" src="<?php echo static_frontend();?>
images/bn1.jpg" id="cpm9981">
	</div>
	<div class="clearfix"></div>
	
	<div class="cinema cinema_home">		
		<h1>Phim lẻ mới cập nhật</h1>
		<div class="cinema-top">
			<?php  $_smarty_tpl->tpl_vars['film'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['film']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['film_le']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
	<div class="clearfix"></div>
	<div class="adHome">
<!--		<img class="img-responsive"  width="980" height="90" border="0" src="//adi.vcmedia.vn/adt/adn/2014/12/980x9-ad11417509878.jpg" id="cpm9981">-->
	</div>
	<div class="clearfix"></div>	
	<div class="cinema cinema_home">
		<h1>Phim bộ mới cập nhật</h1>
		<div class="cinema-top">
			<?php  $_smarty_tpl->tpl_vars['film'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['film']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['film_bo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
	<div class="clearfix"></div>
	<div class="adHome">
		<img class="img-responsive" border="0" src="<?php echo static_frontend();?>
images/bn2.jpg" id="cpm9981">
	</div>
	<div class="clearfix"></div>
</div><?php }} ?>