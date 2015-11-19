<div class="wrap">
    <div class="main">
        <div class="content">
            <div class="wrapper content_news">
                <div class="title number" style="margin-bottom: 20px;">
                    <figure><span>Đăng nhập</span></figure>
                </div>
                <div class="section">
                    <center>
                        <form class="login" action="" method="post" id="login-popup-form">
                            <ul class="form-login">
                                <li><input class="username" type="text" id="username_popup" name="username" placeholder="Tên đăng nhập" value="{$post.username}">{form_error('username')}</li>
                                <li><input class="password" type="password" id="password_popup" name="password" placeholder="Mật khẩu">{form_error('password')}{$check_login}</li>
                                <li><input class="" type="submit" id="loginBtn" name="loginBtn" value="Đăng nhập" onclick="return check_login_popup()"></li>
                            </ul>
                            <p class="align-center cufon">Hoặc đăng nhập bằng</p>

                            <ul class="social-login">
                                <li><a href="{$fbURL}" title=""><img src="{static_base()}mobile/images/facebook.jpg" alt=""></a></li>
                                <li><a href="{$ggURL}" title=""><img src="{static_base()}mobile/images/google.jpg" alt=""></a></li>
                                <li><a href="{$zmURL}" title=""><img src="{static_base()}mobile/images/zingme.jpg" alt=""></a></li>
                                <li><a href="{$yhURL}" title=""><img src="{static_base()}mobile/images/yahoo.jpg" alt=""></a></li>
                            </ul>
                        </form>
                    </center>
                    {*<ul class="">
                    <li><a class="icon-1 cufon" href="http://www.f-idol.vn/dang-ky" title="">Đăng ký</a></li>
                    <li><a class="icon-2 cufon" href="http://www.f-idol.vn/quen-mat-khau" title="">Bạn quên mật khẩu</a></li>
                    </ul>*}

                </div>
            </div>
        </div>
    </div> 
</div>