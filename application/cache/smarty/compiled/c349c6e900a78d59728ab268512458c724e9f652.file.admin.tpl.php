<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 15:25:25
         compiled from "application/views/default\layouts\admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:104315523947546ebd1-72066338%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c349c6e900a78d59728ab268512458c724e9f652' => 
    array (
      0 => 'application/views/default\\layouts\\admin.tpl',
      1 => 1425626154,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '104315523947546ebd1-72066338',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MainTitle' => 0,
    'pgRel' => 0,
    'pgJavascript' => 0,
    'this' => 0,
    'MainContent' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_552394757e58b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552394757e58b')) {function content_552394757e58b($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $_smarty_tpl->tpl_vars['MainTitle']->value;?>
</title>        
        
        <!-- CSS -->
        <!-- GLOBAL -->
        <link href="<?php echo static_base();?>
css/admin-style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo static_base();?>
css/jquery.alerts.css" rel="stylesheet" type="text/css" />        
        <!-- MENU -->
        <link href="<?php echo static_base();?>
css/ddsmoothmenu.css" rel="stylesheet" type="text/css" />        
        <!-- MORE -->
        <?php if ($_smarty_tpl->tpl_vars['pgRel']->value){?><?php echo $_smarty_tpl->tpl_vars['pgRel']->value;?>
<?php }?>
        
        <!-- JS -->
        <!-- LIB -->
        <script type="text/javascript"><?php echo script_global();?>
</script>
        <script type="text/javascript" src="<?php echo static_base();?>
js/jquery-1.6.4.js"></script>
        <script type="text/javascript" src="<?php echo static_base();?>
js/jquery.livequery.js"></script>
        <script type="text/javascript" src="<?php echo static_base();?>
js/jquery.alerts.js"></script>    
        <script type="text/javascript" src="<?php echo static_base();?>
js/vng/config.js"></script>  
        <script type="text/javascript" src="<?php echo static_base();?>
js/vng/function.js"></script>
        <!-- MENU -->
        <script type="text/javascript" src="<?php echo static_base();?>
js/ddsmoothmenu.js"></script>        
        <!-- MORE -->
        <?php if ($_smarty_tpl->tpl_vars['pgJavascript']->value){?><?php echo $_smarty_tpl->tpl_vars['pgJavascript']->value;?>
<?php }?>        
        <!-- GLOBAL -->
        <script type="text/javascript" src="<?php echo static_base();?>
js/admin/function.js"></script>
        <script type="text/javascript" src="<?php echo static_base();?>
js/admin/common.js"></script>
        <script type="text/javascript" src="<?php echo static_base();?>
js/language/english.js"></script>
        <script type="text/javascript">
            //Hoanhk
            //Hàm dùng để write lại form phần filter danh sách
            $(document).ready(
                    function(){
                        $("#FilterUser").attr("action","<?php echo base_url();?>
<?php echo $_smarty_tpl->tpl_vars['this']->value->router->fetch_module();?>
/<?php echo $_smarty_tpl->tpl_vars['this']->value->router->fetch_class();?>
/<?php echo $_smarty_tpl->tpl_vars['this']->value->router->fetch_method();?>
");
                    }
            );
        </script>

        <script type="text/javascript" src="<?php echo static_base();?>
js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <!-- Add fancyBox -->
        <link rel="stylesheet" href="<?php echo static_base();?>
js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo static_base();?>
js/fancybox/jquery.fancybox-1.3.4.js"></script>
        <script type="text/javascript" src="<?php echo static_base();?>
js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="<?php echo static_base();?>
js/swfobject.js"></script>
        <script type="text/javascript" src="<?php echo static_base();?>
js/jwplayer/jwplayer.js"></script>
    </head>
    
    <body>
        <div id="MainWeb">
            <div id="MainHeader">
                <div class="site-logo"><?php echo config_item('penguin_site_name');?>
</div>
                <div class="user-login">
                    <?php if (is_admin()){?>
                        <?php echo lang('User Login');?>
: <?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('user_username');?>

                        ( <a href="<?php echo get_link('frontend');?>
"><?php echo lang('Home');?>
</a> | <?php echo anchor('users/admin_users/logout',lang('Logout'));?>
 )
                    <?php }else{ ?>
                        ( <a href="<?php echo get_link('frontend');?>
"><?php echo lang('Home');?>
</a> | <?php echo anchor('users/admin_users/login',lang('Login'));?>
 )
                    <?php }?>
                </div>
            </div>
            <!-- end #MainHeader -->
            
            <?php if (is_admin()){?>
                <div id="MainMenu" class="ddsmoothmenu">
                    <ul class="nav">                    
                        <?php echo $_smarty_tpl->getSubTemplate ((@FPENGUIN).('media/global_cache/html/admin_menu.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
                    
                    </ul>
                </div>
            <?php }?>
            <!-- end #MainMenu -->
            
            <div id="MainContent">
                <div class="noticMessage">                    
                    <?php if ($_smarty_tpl->tpl_vars['this']->value->session->flashdata('error_message')){?>                        
                        <div class="flash_message ferror"><?php echo $_smarty_tpl->tpl_vars['this']->value->session->flashdata('error_message');?>
</div>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['this']->value->session->flashdata('warning_message')){?>                        
                        <div class="flash_message fwarning"><?php echo $_smarty_tpl->tpl_vars['this']->value->session->flashdata('warning_message');?>
</div>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['this']->value->session->flashdata('success_message')){?>
                        <div class="flash_message fsuccess"><?php echo $_smarty_tpl->tpl_vars['this']->value->session->flashdata('success_message');?>
</div>
                    <?php }?>                    
                </div>
                
                <div class="breadcrumb"><?php echo set_breadcrumb();?>
</div>                
                
                <div class="boxContent">
                    
                    <?php if ($_smarty_tpl->tpl_vars['this']->value->router->class=='admin_statistics'){?>
                    <!--BUTTON BACK-->
                    <div class="data_div" style="margin-bottom: 5px;">
<!--                        <a  href="<?php echo base_url();?>
statistics/admin_statistic_campaigns"><image width="50" src="<?php echo static_base();?>
images/back_btn2.png"/></a>-->

                        <?php if (is_mod()){?>
                            <a title="Clear cache"  style="float: right; margin-right: 10px;"  href="<?php echo base_url('statistics/admin_statistics/clear_cache/');?>
/<?php echo $_GET['campaign_id'];?>
"><image height="38" src="<?php echo static_base();?>
images/clear_cache.jpg"/></a>
                        <?php }?>
                        <a title="Export pdf" onclick="export_to_pdf('/statistics/admin_statistics/export_to_pdf/', <?php echo $_GET['campaign_id'];?>
)" style="float: right; margin-right: 20px;"  href="javascript:void(0);"><image height="38" src="<?php echo static_base();?>
images/pdficon.jpg"/></a>
<!--                         <div class="img_loading" id="loading_export_pdf"><img src="<?php echo static_base();?>
images/loader.gif" /></div>-->

                    </div>
                    <div style="margin-top: 20px; width: 100%; clear: left;"></div>
                <?php }?>
                
                
                    <div class="left"></div>
                    <div class="right"></div>
                    <?php echo $_smarty_tpl->tpl_vars['MainContent']->value;?>

                </div>                
            </div>
            <!-- end #MainContent -->
            
            <div id="MainFooter">
                <p>Copyright (c) 2010 <?php echo config_item('penguin_site');?>
. All rights reserved. Design by <a href="<?php echo config_item('penguin_site');?>
"><?php echo config_item('penguin_site_name');?>
</a>.</p>                
            </div>
            <!-- end #MainFooter -->            
        </div>
        
        
            <script type="text/javascript">
                $(document).ready(function() {                    
                    $('#MainMenu .nav a').each(function() {
                        var ahref = $(this).attr('href');
                        if (ahref != '#') {
                            $(this).attr('href', base_url + ahref);
                        }
                        else {
                            $(this).attr('href', 'javascript:void(0);');
                        }
                    });
                });
            </script>
        
    </body>
</html><?php }} ?>