{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Events
 * 
 * @package PenguinFW
 * @subpackage events
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin event logs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditEvents').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditEvents">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('view_count')}</td>
                    <td class="left"><input disabled="" type="text" name="view_count" value="{$data_edit->view_count}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('view_cheat')}</td>
                    <td class="left"><input type="text" name="view_cheat" value="{$data_edit->view_cheat}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('vote_count')}</td>
                    <td class="left"><input disabled="" type="text" name="vote_count" value="{$data_edit->vote_count}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('vote_cheat')}</td>
                    <td class="left"><input type="text" name="vote_cheat" value="{$data_edit->vote_cheat}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('sms_count')}</td>
                    <td class="left"><input disabled="" type="text" name="sms_count" value="{$data_edit->sms_count}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
