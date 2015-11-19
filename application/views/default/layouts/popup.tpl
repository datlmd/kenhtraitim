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
        <!-- MENU -->
        <script type="text/javascript" src="{static_base()}js/ddsmoothmenu.js"></script>        
        <!-- MORE -->
        {if $pgJavascript}{$pgJavascript}{/if}        
        <!-- GLOBAL -->        
        <script type="text/javascript" src="{static_base()}js/admin/function.js"></script>
        <script type="text/javascript" src="{static_base()}js/admin/common.js"></script>
        <script type="text/javascript" src="{static_base()}js/language/english.js"></script>
    </head>
    
    <body>
        <div id="MainWeb">
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
                
                <div class="boxContent">
                    <div class="left"></div>
                    <div class="right"></div>
                    {$MainContent}
                </div>                
            </div>
            <!-- end #MainContent -->
        </div>
    </body>
</html>