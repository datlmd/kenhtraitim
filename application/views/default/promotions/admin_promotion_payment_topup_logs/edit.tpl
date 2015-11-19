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
    <h1>{lang('Edit Admin promotion payment topup logs')}</h1>

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
                    <td class="left">{get_label('trans_id')}</td>
                    <td class="left">
                        <select name="trans_id">
                            <option value="">{lang('All')}</option>
                            {foreach $trans_ids as $trans_id}
                                <option value="{$trans_id.id}" {if $data_edit->trans_id eq $trans_id.id}selected{/if}>{lang($trans_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('account_name')}</td>
                    <td class="left"><input type="text" name="account_name" value="{$data_edit->account_name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('total_amount')}</td>
                    <td class="left"><input type="text" name="total_amount" value="{$data_edit->total_amount}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('signature')}</td>
                    <td class="left"><input type="text" name="signature" value="{$data_edit->signature}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('result')}</td>
                    <td class="left"><input type="text" name="result" value="{$data_edit->result}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="{$data_edit->username}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip')}</td>
                    <td class="left"><input type="text" name="ip" value="{$data_edit->ip}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('id_verify')}</td>
                    <td class="left"><input type="text" name="id_verify" value="{$data_edit->id_verify}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
