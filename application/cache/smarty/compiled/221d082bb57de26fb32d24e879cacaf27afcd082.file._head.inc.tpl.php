<?php /* Smarty version Smarty-3.1.1, created on 2015-04-23 15:59:45
         compiled from "application/views/default\layouts\_head.inc.tpl" */ ?>
<?php /*%%SmartyHeaderCode:63235502a385267876-01110578%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '221d082bb57de26fb32d24e879cacaf27afcd082' => 
    array (
      0 => 'application/views/default\\layouts\\_head.inc.tpl',
      1 => 1429779194,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63235502a385267876-01110578',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_5502a3852b5a9',
  'variables' => 
  array (
    'MainTitle' => 0,
    'MainKeyword' => 0,
    'MainDescription' => 0,
    'MainImage' => 0,
    'pgRel' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5502a3852b5a9')) {function content_5502a3852b5a9($_smarty_tpl) {?><title><?php echo $_smarty_tpl->tpl_vars['MainTitle']->value;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['MainKeyword']->value;?>
" />
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['MainDescription']->value;?>
" />
<meta name="robots" content="index, follow" />
<meta name="revisit-after" content="7 days" />
<meta name="author" content="Kênh Trái Tim" />
<meta name="copyright" content="2015 kenhtraitim.com" />

<meta property="fb:admins" content="kenhtraitim.com">
<meta property="og:country-name" content="Vietnam" />
<meta property="og:type" content="Article" />
<meta property="og:title" content="<?php echo $_smarty_tpl->tpl_vars['MainTitle']->value;?>
" />
<meta property="og:description" content="<?php echo $_smarty_tpl->tpl_vars['MainDescription']->value;?>
" />
<meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['MainImage']->value;?>
"/>
<meta name="dcterms.description" content="<?php echo $_smarty_tpl->tpl_vars['MainDescription']->value;?>
" />

<meta name="revisit-after" content="1 day" />

<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<!--CORE CSS JS-->
<link rel="shortcut icon" href="<?php echo static_frontend();?>
images/favicon.ico" type="image/x-icon" />

<link href="<?php echo static_frontend();?>
css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo static_frontend();?>
css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo static_frontend();?>
css/nav.css" rel="stylesheet" type="text/css" media="all"/>

<!--fonts-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
<!--//fonts-->

<?php if ($_smarty_tpl->tpl_vars['pgRel']->value){?><?php echo $_smarty_tpl->tpl_vars['pgRel']->value;?>
<?php }?>
<script src="<?php echo static_frontend();?>
js/jquery.min.js"></script>
<script type="application/x-javascript">
	addEventListener("load", function() { 
		setTimeout(hideURLbar, 0); 
	}, false); function hideURLbar(){ 
		window.scrollTo(0,1); 
	} 
</script>
<script type="text/javascript" src="<?php echo static_frontend();?>
js/move-top.js"></script>
<script type="text/javascript" src="<?php echo static_frontend();?>
js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({
				scrollTop:$(this.hash).offset().top
				},1000);
		});
	});
</script>
<script src="<?php echo static_frontend();?>
js/easyResponsiveTabs.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#horizontalTab,#horizontalTab1,#horizontalTab2').easyResponsiveTabs({
			type: 'default', //Types: default, vertical, accordion           
			width: 'auto', //auto or any width like 600px
			fit: true   // 100% fit in a container
		});
	});
</script>


<script src="<?php echo static_frontend();?>
js/main.js"></script> <!-- Resource jQuery --><?php }} ?>