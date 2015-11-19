{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin tạo custom field theo resource
 * 
 * @package PenguinFW
 * @subpackage Custom fields
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit')} {lang('Custom field')}: {$resource}</h1>
    
    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddCustomField').submit();" class="button"><span>{lang('Save')}</span></a>        
    </div>
</div>
    
<div class="content">
    <form action="{base_url()}custom_fields/admin_custom_fields/add" method="post" id="FormAddCustomField">
        <input type="hidden" name="module_id" value="{$module_id}" />
        <input type="hidden" name="resource" value="{$resource}" />
        <table class="form">
            <tbody>
                <tr>
                    <td>{lang('Name')}</td>
                    <td><input type="text" name="name" value="" /></td>
                </tr>
                
                <tr>
                    <td>{lang('Field')}</td>
                    <td>
                        {foreach $module_fields as $module_field}
                            <div class="line">
                                <input type="checkbox" name="field_choose[]" value="{$module_field.id}" /> {get_label($module_field.name)}
                            </div>
                        {/foreach}
                    </td>
                </tr>                
            </tbody>
        </table>
    </form>
</div>    