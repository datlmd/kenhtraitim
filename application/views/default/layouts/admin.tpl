<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{$MainTitle}</title>        
        
        <!-- CSS -->
        <!-- GLOBAL -->
        <link href="{static_base()}css/admin-style.css" rel="stylesheet" type="text/css" />
        <link href="{static_base()}css/jquery.alerts.css" rel="stylesheet" type="text/css" />        
        <!-- MENU -->
        <link href="{static_base()}css/ddsmoothmenu.css" rel="stylesheet" type="text/css" />        
        <!-- MORE -->
        {if $pgRel}{$pgRel}{/if}
        
        <!-- JS -->
        <!-- LIB -->
        <script type="text/javascript">{script_global()}</script>
        <script type="text/javascript" src="{static_base()}js/jquery-1.6.4.js"></script>
        <script type="text/javascript" src="{static_base()}js/jquery.livequery.js"></script>
        <script type="text/javascript" src="{static_base()}js/jquery.alerts.js"></script>    
        <script type="text/javascript" src="{static_base()}js/vng/config.js"></script>  
        <script type="text/javascript" src="{static_base()}js/vng/function.js"></script>
        <!-- MENU -->
        <script type="text/javascript" src="{static_base()}js/ddsmoothmenu.js"></script>        
        <!-- MORE -->
        {if $pgJavascript}{$pgJavascript}{/if}        
        <!-- GLOBAL -->
        <script type="text/javascript" src="{static_base()}js/admin/function.js"></script>
        <script type="text/javascript" src="{static_base()}js/admin/common.js"></script>
        <script type="text/javascript" src="{static_base()}js/language/english.js"></script>
        <script type="text/javascript">
            //Hoanhk
            //Hàm dùng để write lại form phần filter danh sách
            $(document).ready(
                    function(){
                        $("#FilterUser").attr("action","{base_url()}{$this->router->fetch_module()}/{$this->router->fetch_class()}/{$this->router->fetch_method()}");
                    }
            );
        </script>

        <script type="text/javascript" src="{static_base()}js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <!-- Add fancyBox -->
        <link rel="stylesheet" href="{static_base()}js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        <script type="text/javascript" src="{static_base()}js/fancybox/jquery.fancybox-1.3.4.js"></script>
        <script type="text/javascript" src="{static_base()}js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="{static_base()}js/swfobject.js"></script>
        <script type="text/javascript" src="{static_base()}js/jwplayer/jwplayer.js"></script>
    </head>
    
    <body>
        <div id="MainWeb">
            <div id="MainHeader">
                <div class="site-logo">{config_item('penguin_site_name')}</div>
                <div class="user-login">
                    {if is_admin()}
                        {lang('User Login')}: {$this->session->userdata('user_username')}
                        ( <a href="{get_link('frontend')}">{lang('Home')}</a> | {anchor('users/admin_users/logout', lang('Logout'))} )
                    {else}
                        ( <a href="{get_link('frontend')}">{lang('Home')}</a> | {anchor('users/admin_users/login', lang('Login'))} )
                    {/if}
                </div>
            </div>
            <!-- end #MainHeader -->
            
            {if is_admin()}
                <div id="MainMenu" class="ddsmoothmenu">
                    <ul class="nav">                    
                        {include $smarty.const.FPENGUIN|cat:'media/global_cache/html/admin_menu.tpl'}                    
                    </ul>
                </div>
            {/if}
            <!-- end #MainMenu -->
            
            <div id="MainContent">
                <div class="noticMessage">                    
                    {if $this->session->flashdata('error_message')}                        
                        <div class="flash_message ferror">{$this->session->flashdata('error_message')}</div>
                    {/if}
                    {if $this->session->flashdata('warning_message')}                        
                        <div class="flash_message fwarning">{$this->session->flashdata('warning_message')}</div>
                    {/if}

                    {if $this->session->flashdata('success_message')}
                        <div class="flash_message fsuccess">{$this->session->flashdata('success_message')}</div>
                    {/if}                    
                </div>
                
                <div class="breadcrumb">{set_breadcrumb()}</div>                
                
                <div class="boxContent">
                    
                    {if $this->router->class == 'admin_statistics' }
                    <!--BUTTON BACK-->
                    <div class="data_div" style="margin-bottom: 5px;">
<!--                        <a  href="{base_url()}statistics/admin_statistic_campaigns"><image width="50" src="{static_base()}images/back_btn2.png"/></a>-->

                        {if is_mod()}
                            <a title="Clear cache"  style="float: right; margin-right: 10px;"  href="{base_url('statistics/admin_statistics/clear_cache/')}/{$smarty.get.campaign_id}"><image height="38" src="{static_base()}images/clear_cache.jpg"/></a>
                        {/if}
                        <a title="Export pdf" onclick="export_to_pdf('/statistics/admin_statistics/export_to_pdf/', {$smarty.get.campaign_id})" style="float: right; margin-right: 20px;"  href="javascript:void(0);"><image height="38" src="{static_base()}images/pdficon.jpg"/></a>
<!--                         <div class="img_loading" id="loading_export_pdf"><img src="{static_base()}images/loader.gif" /></div>-->

                    </div>
                    <div style="margin-top: 20px; width: 100%; clear: left;"></div>
                {/if}
                
                
                    <div class="left"></div>
                    <div class="right"></div>
                    {$MainContent}
                </div>                
            </div>
            <!-- end #MainContent -->
            
            <div id="MainFooter">
                <p>Copyright (c) 2010 {config_item('penguin_site')}. All rights reserved. Design by <a href="{config_item('penguin_site')}">{config_item('penguin_site_name')}</a>.</p>                
            </div>
            <!-- end #MainFooter -->            
        </div>
        
        {literal}
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
        {/literal}
    </body>
</html>