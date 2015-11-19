{include file=theme_web()|cat:'/frontend/open_login/header.tpl'}
<div id="container">
    <div class=""><a href="#" id="login-popup">Login</a></div>
    <div id="dialog" title="Login with social account">
        <h2>Login with social account</h2>
        <form name="frm-login" action="http://sso2.zing.vn/index.php?method=login" method="post">
            <input type="hidden" name="u1" value="http://demoproduct.ad.zing.vn/open_login/zing" />
            <input type="hidden" name="fp" value="http://demoproduct.ad.zing.vn/open_login/zing_fail" />
            <input type="hidden" name="pid" value="69" />
            <div class="form-item"><label>Zing ID: </label><input type="text" class="textfield" name="u" id="txt-username" /></div>
            <div class="form-item"><label>Password: </label><input type="password" class="textfield" name="p" id="txt-password" /></div>
            <div class="form-submit"><input type="submit" value="Login" /></div>
        </form>
        <div class="social-login-list">
            <span><a href="{$fbURL}"><img src="{static_url()}static/default/frontend/images/fb-login-button.png" alt="Facebook login" /></a></span>
            <span><a href="{$ggURL}"><img src="{static_url()}static/default/frontend/images/goog-login-button.png" alt="Google login" /></a></span>
            <span><a href="{$yhURL}"><img src="{static_url()}static/default/frontend/images/yahoo-oauth-connect.png" alt="Yahoo login" /></a></span>
        </div>
     </div>
</div>
<script>
    $(function() {
        $( "#dialog" ).dialog({
            autoOpen: false,
            show: {
                effect: "blind",
                duration: 200
            },
            hide: {
                effect: "blind",
                duration: 200
            }
        });
        $( "#login-popup" ).click(function() {
            $( "#dialog" ).dialog( "open" );
        });
    });
</script>
{include file=theme_web()|cat:'/frontend/open_login/footer.tpl'}
