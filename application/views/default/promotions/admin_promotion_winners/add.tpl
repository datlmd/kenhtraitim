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
    <h1>{lang('Add Admin promotion winners')}</h1>

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
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('id_gift')}</td>
                    <td class="left"><input type="text" name="id_gift" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('code')}</td>
                    <td class="left"><input type="text" name="code" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_received')}</td>
                    <td class="left"><input type="checkbox" name="is_received" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('received_date')}</td>
                    <td class="left"><input type="text" name="received_date" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_confirm')}</td>
                    <td class="left"><input type="checkbox" name="is_confirm" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('confirm_date')}</td>
                    <td class="left"><input type="text" name="confirm_date" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('modified_user')}</td>
                    <td class="left"><input type="text" name="modified_user" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip')}</td>
                    <td class="left"><input type="text" name="ip" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('token')}</td>
                    <td class="left"><input type="text" name="token" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('full_name')}</td>
                    <td class="left"><input type="text" name="full_name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('gender')}</td>
                    <td class="left"><input type="text" name="gender" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('dob')}</td>
                    <td class="left"><input type="text" name="dob" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('personal_id')}</td>
                    <td class="left">
                        <select name="personal_id">
                            <option value="">{lang('All')}</option>
                            {foreach $personal_ids as $personal_id}
                                <option value="{$personal_id.id}">{lang($personal_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('address')}</td>
                    <td class="left"><input type="text" name="address" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('region_id')}</td>
                    <td class="left">
                        <select name="region_id">
                            <option value="">{lang('All')}</option>
                            {foreach $region_ids as $region_id}
                                <option value="{$region_id.id}">{lang($region_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('phone')}</td>
                    <td class="left"><input type="text" name="phone" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('email')}</td>
                    <td class="left"><input type="text" name="email" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('zing_account')}</td>
                    <td class="left"><input type="text" name="zing_account" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
