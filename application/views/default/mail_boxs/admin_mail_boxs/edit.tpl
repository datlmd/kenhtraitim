{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Mail_boxs
 * 
 * @package PenguinFW
 * @subpackage mail_boxs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin mail boxs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditMail_boxs').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditMail_boxs">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('email_from')}</td>
                    <td class="left"><input type="text" name="email_from" value="{$data_edit->email_from}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('email_to')}</td>
                    <td class="left"><input type="text" name="email_to" value="{$data_edit->email_to}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_ip')}</td>
                    <td class="left"><input type="text" name="user_ip" value="{$data_edit->user_ip}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('subject')}</td>
                    <td class="left"><input type="text" name="subject" value="{$data_edit->subject}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('content')}</td>
                    <td class="left"><input type="text" name="content" value="{$data_edit->content}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_name')}</td>
                    <td class="left"><input type="text" name="user_name" value="{$data_edit->user_name}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
