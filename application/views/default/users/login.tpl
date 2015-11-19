{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Đăng nhập vào hệ thống
 * 
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 */

*}

<div id="content">    
    <div class="post">
        <h2 class="title">{lang('Login')}</h2>
        
        <div class="entry">
            {validation_errors()}
            <form action="" method="post">
                <input type="hidden" name="rp" value="{$smarty.get.rp}" />
                <table style="color:#333333;">
                    <tbody>
                        <tr>
                            <td>{lang('Username')}</td>
                            <td><input type="text" name="username" value="" size="50" /></td>
                        </tr>

                        <tr>
                            <td>{lang('Password')}</td>
                            <td><input type="password" name="password" value="" size="50" /></td>
                        </tr>                                                                        

                        <tr>
                            <td></td>
                            <td><input type="submit" value="Submit" /></td>
                        </tr>
                    </tbody>                                
                </table>                                                        
            </form>
        </div>
    </div>    
    <div style="clear: both;">&nbsp;</div>
</div>
<!-- end #content -->