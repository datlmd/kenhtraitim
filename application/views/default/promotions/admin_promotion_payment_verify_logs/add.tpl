{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Promotions
 * 
 * @package PenguinFW
 * @subpackage promotions
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin promotion payment verify logs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddPromotions').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddPromotions">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('trans_id')}</td>
                    <td class="left">
                        <select name="trans_id">
                            <option value="">{lang('All')}</option>
                            {foreach $trans_ids as $trans_id}
                                <option value="{$trans_id.id}">{lang($trans_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('account_name')}</td>
                    <td class="left"><input type="text" name="account_name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('total_amount')}</td>
                    <td class="left"><input type="text" name="total_amount" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('signature')}</td>
                    <td class="left"><input type="text" name="signature" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('result')}</td>
                    <td class="left"><input type="text" name="result" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip')}</td>
                    <td class="left"><input type="text" name="ip" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
