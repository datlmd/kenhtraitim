{* add by hungtd *}
<div class="heading">
    <h1>{lang('Login to admin page')}</h1>
</div>
    
<div class="content">
    {validation_errors()}
    <div style="width: 400px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;" class="box">
        <div class="heading">
            <h1><img alt="" src="{static_base()}images/admin/lockscreen.png">{lang('Please enter your login details')}.</h1>
        </div>
        <div style="min-height: 150px; overflow: hidden;" class="content">
            <form id="form" enctype="multipart/form-data" method="post" action="" class="vng_util_enter_div">
                <input type="hidden" name="rp" value="{$smarty.get.rp}" />
                <table style="width: 100%;">
                    <tbody><tr>
                            <td rowspan="4" style="text-align: center;"><img alt="Please enter your login details." src="{static_base()}images/admin/login.png"></td>
                        </tr>
                        <tr>
                            <td>
                                {lang('Username')}:<br />
                                <input type="text" style="margin-top: 4px;" value="" name="username" />
                                <br />
                                <br />
                                {lang('Password')}:<br />
                                <input type="password" style="margin-top: 4px;" value="" name="password" />
                                <br>
                                <br />
                                {lang('Captcha')}: <br />
                                <input type="text" style="margin-top: 4px;" value="" name="captcha" /><br/>
                                <br />
                                {print_captcha()}
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align: right;"><button style="background:none repeat scroll 0 0 #003A88;border-radius:10px 10px 10px 10px;display:inline-block;padding:5px 15px;color:#fff;font-weight:700;cursor:pointer;" type="submit">Login</button></td>
                        </tr>
                    </tbody></table>
            </form>
        </div>
    </div>
</div>