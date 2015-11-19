{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Tracking_shares
 * 
 * @package PenguinFW
 * @subpackage tracking_shares
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin tracking shares')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditTracking_shares').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditTracking_shares">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('share_name')}</td>
                    <td class="left"><input type="text" name="share_name" value="{$data_edit->share_name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('share_link_on_page')}</td>
                    <td class="left"><input type="text" name="share_link_on_page" value="{$data_edit->share_link_on_page}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip')}</td>
                    <td class="left"><input type="text" name="ip" value="{$data_edit->ip}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
