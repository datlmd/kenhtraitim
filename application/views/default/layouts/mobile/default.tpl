<!DOCTYPE html>
<head>        
    {include file='default/layouts/mobile/_head.tpl'}
</head>
<script type="text/javascript">
    $(document).ready(function() {
        activeMenu("{$active}");
        $('.bxslider').bxSlider();
    });
</script>
<body class="wrapper">
    <div class="wrap">
        <div class="header">  	

            <div class="wrapper header_desc">
                <div class="logo" style="color: #F15922; float: left; height: 40px; width: 250px; margin-top: 5px;">
                    <a href="{base_url()}mobile" style="color: #FFF; font-size: 33px; "><h1>VNG Digital Ads</h1></a>
                </div>	
                <div style=" float: right; height: 30px; width: 150px; margin-top: 15px; text-align: right;">
                    {if $this->session->userdata('user_id')}
                        {if $this->session->userdata('user_fullname')==''}
                            {$this->session->userdata('user_username')}
                        {else}
                            {$this->session->userdata('user_fullname')}
                        {/if}

                        {if $this->session->userdata('zing_logout')==""}
                            <span>|</span>  <a href="{base_url()}open_login/logout" class="login-link" >Thoát</a>
                        {else}
                            <span>|</span>  <a href="{$this->session->userdata('zing_logout')}" class="login-link" >Thoát</a>
                        {/if}
                    {else}
                        <a href="{base_url()}mobile/login" class="login-link">Đăng Nhập</a>
                    {/if}
                </div>
            </div>
            {*            <div style="clear: both"></div>*}
            <!--- Slider --->
            <div class="bxslider">
                <img src="{static_base()}mobile/images/1.jpg" alt="" />
                <img src="{static_base()}mobile/images/4.jpg" alt="" />
                <img src="{static_base()}mobile/images/3.jpg" alt="" />
                <img src="{static_base()}mobile/images/2.jpg" alt="" />
            </div>
            <!--- End Slider --->
        </div>

        <div class="wrapper menu header-bottom">
            <nav class="nav">	        	
                <a href="#" id="w3-menu-trigger"> </a>
                <ul class="nav-list">
                    <li class="nav-item"><a id="trang-chu" href="{base_url()}mobile">Trang chủ</a></li>
                    <li class="nav-item"><a id="tin-tuc" href="{base_url()}mobile/tin-tuc/0">Tin tức</a></li>
                    <li class="nav-item"><a id="hinh-anh" href="{base_url()}mobile/hinh-anh/0">Hình ảnh</a></li>
                    <li class="nav-item"><a id="video" href="{base_url()}mobile/video/0">Videos & Musics</a></li>
                    <li class="nav-item"><a id="the-le" href="{base_url()}mobile/the-le">Thể lệ</a></li>
                    <li class="nav-item"><a id="dang-nhap" href="{base_url()}mobile/login">Đăng nhập</a></li>
                </ul>
            </nav>
            <div class="social-icons">						
                <ul>
                    <li><a class="facebook" href="{share_url('fb')}" target="_blank"> </a></li>
                    <li><a class="twitter" href="{share_url('tw')}" target="_blank"></a></li>
                    <li><a class="googleplus" href="{share_url('google')}" target="_blank"></a></li>
                    <li><a class="zing" href="{share_url('zm')}" target="_blank"></a></li>
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="clear"> </div>
            <script src="{static_base()}mobile/js/responsive.menu.js"></script>
        </div>

    </div>
</div>

{$MainContent}

<div class="wrap">
    <div class="wrapper footer">
        <div class="footer_grides">
            <center>
                <h3>Đơn vị tài trợ</h3>
                <p><a href="#">Copyright © 2013 by Zing</a></p>
            </center>
        </div>
    </div>
</div>
</body>
</html>