{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Promotions
 * 
 * @package PenguinFW
 * @subpackage promotions
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin promotion payment checkbalance logs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditPromotions').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditPromotions">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('radom_string')}</td>
                    <td class="left"><input type="text" name="radom_string" value="{$data_edit->radom_string}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('result')}</td>
                    <td class="left"><input type="text" name="result" value="{$data_edit->result}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
