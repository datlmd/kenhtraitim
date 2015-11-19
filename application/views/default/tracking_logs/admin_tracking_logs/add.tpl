{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Tracking_logs
 * 
 * @package PenguinFW
 * @subpackage tracking_logs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin tracking logs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddTracking_logs').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddTracking_logs">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip')}</td>
                    <td class="left"><input type="text" name="ip" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_agents')}</td>
                    <td class="left"><input type="text" name="user_agents" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('referal_or_page')}</td>
                    <td class="left"><input type="text" name="referal_or_page" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
