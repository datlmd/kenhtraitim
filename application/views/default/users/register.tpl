{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Đăng ký tài khoản
 * 
 * @package PenguinFW
 * @subpackage ...
 * @version 1.0.0
 */

*}

<div id="content">    
    <div class="post">
        <h2 class="title">{lang('Register')}</h2>
        
        <div class="entry">
            {validation_errors()}
            <form action="" method="post">
                <table style="color:#333333;">
                    <tbody>
                        <tr>
                            <td>{lang('Username')}</td>
                            <td><input type="text" name="username" value="" size="50" /></td>
                        </tr>

                        <tr>
                            <td>{lang('Password')}</td>
                            <td><input type="text" name="password" value="" size="50" /></td>
                        </tr>

                        <tr>
                            <td>{lang('Password confirm')}</td>
                            <td><input type="text" name="passconf" value="" size="50" /></td>
                        </tr>

                        <tr>
                            <td>{lang('Email Address')}</td>
                            <td><input type="text" name="email" value="" size="50" /></td>
                        </tr>

                        <tr>
                            <td>{lang('Captcha')}</td>
                            <td>{print_captcha()}</td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><input type="submit" value="{lang('Submit')}" /></td>
                        </tr>
                    </tbody>                                
                </table>                                                        
            </form>
        </div>
    </div>    
    <div style="clear: both;">&nbsp;</div>
</div>
<!-- end #content -->