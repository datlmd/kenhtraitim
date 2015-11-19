{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin add role
 * 
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add')} {lang('User role')}</h1>
    
    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddUserRole').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    <div class="error warning_message">{validation_errors()}</div>
    
    <form action="{base_url('users/admin_roles/add')}" method="post" id="FormAddUserRole">
        <table class="form">
            <tbody>
                <tr>
                    <td><span class="required">*</span> {lang('Name')}</td>
                    <td><input type="text" name="name" value="" maxlength="200" /></td>
                </tr>                        
                
                <tr>
                    <td>{lang('Description')}</td>
                    <td><input type="text" name="description" value="" maxlength="200" /></td>
                </tr>                        

                <tr>
                    <td><span class="required">*</span> {lang('Role copy')}</td>
                    <td>
                        <select name="user_role_cp_id">
                            <option value=''></option>
                            {foreach $all_roles as $role_cp}
                                <option value={$role_cp.id}>{$role_cp.name}</option>    
                            {/foreach}
                        </select>
                    </td>
                </tr>                

                <tr>
                    <td>{lang('Weight')}</td>
                    <td><input type="text" name="weight" value="0" /></td>
                </tr>
            </tbody>
        </table>
    </form>    
</div>