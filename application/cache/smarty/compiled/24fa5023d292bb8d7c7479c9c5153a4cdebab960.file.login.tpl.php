<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 15:25:24
         compiled from "application/views/default\users\admin_users\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1466455239474675ee1-79313639%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24fa5023d292bb8d7c7479c9c5153a4cdebab960' => 
    array (
      0 => 'application/views/default\\users\\admin_users\\login.tpl',
      1 => 1425626154,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1466455239474675ee1-79313639',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_55239474a1b9e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55239474a1b9e')) {function content_55239474a1b9e($_smarty_tpl) {?>
<div class="heading">
    <h1><?php echo lang('Login to admin page');?>
</h1>
</div>
    
<div class="content">
    <?php echo validation_errors();?>

    <div style="width: 400px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;" class="box">
        <div class="heading">
            <h1><img alt="" src="<?php echo static_base();?>
images/admin/lockscreen.png"><?php echo lang('Please enter your login details');?>
.</h1>
        </div>
        <div style="min-height: 150px; overflow: hidden;" class="content">
            <form id="form" enctype="multipart/form-data" method="post" action="" class="vng_util_enter_div">
                <input type="hidden" name="rp" value="<?php echo $_GET['rp'];?>
" />
                <table style="width: 100%;">
                    <tbody><tr>
                            <td rowspan="4" style="text-align: center;"><img alt="Please enter your login details." src="<?php echo static_base();?>
images/admin/login.png"></td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo lang('Username');?>
:<br />
                                <input type="text" style="margin-top: 4px;" value="" name="username" />
                                <br />
                                <br />
                                <?php echo lang('Password');?>
:<br />
                                <input type="password" style="margin-top: 4px;" value="" name="password" />
                                <br>
                                <br />
                                <?php echo lang('Captcha');?>
: <br />
                                <input type="text" style="margin-top: 4px;" value="" name="captcha" /><br/>
                                <br />
                                <?php echo print_captcha();?>

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
</div><?php }} ?>