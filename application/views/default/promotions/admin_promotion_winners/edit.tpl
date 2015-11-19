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
    <h1>{lang('Edit Admin promotion winners')}</h1>

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
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="{$data_edit->username}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('id_gift')}</td>
                    <td class="left"><input type="text" name="id_gift" value="{$data_edit->id_gift}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('code')}</td>
                    <td class="left"><input type="text" name="code" value="{$data_edit->code}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_received')}</td>
                    <td class="left"><input type="checkbox" name="is_received" value="{$data_edit->is_received}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('received_date')}</td>
                    <td class="left"><input type="text" name="received_date" value="{$data_edit->received_date}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_confirm')}</td>
                    <td class="left"><input type="checkbox" name="is_confirm" value="{$data_edit->is_confirm}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('confirm_date')}</td>
                    <td class="left"><input type="text" name="confirm_date" value="{$data_edit->confirm_date}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('modified_user')}</td>
                    <td class="left"><input type="text" name="modified_user" value="{$data_edit->modified_user}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip')}</td>
                    <td class="left"><input type="text" name="ip" value="{$data_edit->ip}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('token')}</td>
                    <td class="left"><input type="text" name="token" value="{$data_edit->token}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('full_name')}</td>
                    <td class="left"><input type="text" name="full_name" value="{$data_edit->full_name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('gender')}</td>
                    <td class="left"><input type="text" name="gender" value="{$data_edit->gender}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('dob')}</td>
                    <td class="left"><input type="text" name="dob" value="{$data_edit->dob}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('personal_id')}</td>
                    <td class="left">
                        <select name="personal_id">
                            <option value="">{lang('All')}</option>
                            {foreach $personal_ids as $personal_id}
                                <option value="{$personal_id.id}" {if $data_edit->personal_id eq $personal_id.id}selected{/if}>{lang($personal_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('address')}</td>
                    <td class="left"><input type="text" name="address" value="{$data_edit->address}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('region_id')}</td>
                    <td class="left">
                        <select name="region_id">
                            <option value="">{lang('All')}</option>
                            {foreach $region_ids as $region_id}
                                <option value="{$region_id.id}" {if $data_edit->region_id eq $region_id.id}selected{/if}>{lang($region_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('phone')}</td>
                    <td class="left"><input type="text" name="phone" value="{$data_edit->phone}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('email')}</td>
                    <td class="left"><input type="text" name="email" value="{$data_edit->email}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('zing_account')}</td>
                    <td class="left"><input type="text" name="zing_account" value="{$data_edit->zing_account}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
