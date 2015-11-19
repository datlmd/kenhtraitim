{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Tracking_logs
 * 
 * @package PenguinFW
 * @subpackage tracking_logs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin tracking logs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditTracking_logs').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditTracking_logs">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="{$data_edit->username}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip')}</td>
                    <td class="left"><input type="text" name="ip" value="{$data_edit->ip}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_agents')}</td>
                    <td class="left"><input type="text" name="user_agents" value="{$data_edit->user_agents}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('referal_or_page')}</td>
                    <td class="left"><input type="text" name="referal_or_page" value="{$data_edit->referal_or_page}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
