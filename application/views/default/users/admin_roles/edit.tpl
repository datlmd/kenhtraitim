{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin Edit role
 * 
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit')} {lang('User role')}</h1>
    
    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditUserRole').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <div class="error warning_message">{validation_errors()}</div>
    
    <form action="{base_url('users/admin_roles/edit')}" method="post" id="FormEditUserRole">
        <input type="hidden" name="role_id" value="{$current_role->id}" />
        <table class="form">
            <tbody>
                <tr>
                    <td><span class="required">*</span> {lang('Name')}</td>
                    <td><input type="text" name="name" value="{$current_role->name}" maxlength="200" /></td>
                </tr>                        
                
                <tr>
                    <td>{lang('Description')}</td>
                    <td><input type="text" name="description" value="" maxlength="200" /></td>
                </tr>                              

                <tr>
                    <td>{lang('Weight')}</td>
                    <td><input type="text" name="weight" value="{$current_role->weight}" /></td>
                </tr>
            </tbody>
        </table>
    </form>    
</div>