{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Mail_boxs
 * 
 * @package PenguinFW
 * @subpackage mail_boxs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin mail boxs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddMail_boxs').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddMail_boxs">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('email_from')}</td>
                    <td class="left"><input type="text" name="email_from" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('email_to')}</td>
                    <td class="left"><input type="text" name="email_to" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_ip')}</td>
                    <td class="left"><input type="text" name="user_ip" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('subject')}</td>
                    <td class="left"><input type="text" name="subject" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('content')}</td>
                    <td class="left"><input type="text" name="content" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_name')}</td>
                    <td class="left"><input type="text" name="user_name" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
