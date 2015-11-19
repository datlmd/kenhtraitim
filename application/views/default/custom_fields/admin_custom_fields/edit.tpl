{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin chỉnh sửa custom field theo resource
 * 
 * @package PenguinFW
 * @subpackage Custom fields
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit')} {lang('Custom field')}: {$cfn_obj->name}</h1>
    
    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditCustomField').submit();" class="button"><span>{lang('Edit')}</span></a>        
    </div>
</div>
    
<div class="content">
    <form action="{base_url()}custom_fields/admin_custom_fields/edit" method="post" id="FormEditCustomField">
        <input type="hidden" name="cfn_id" value="{$cfn_id}" />
        <input type="hidden" name="resource_id" value="{$cfn_obj->resource_id}" />
        
        <table class="form">
            <tbody>
                <tr>
                    <td>{lang('Custom field name')}</td>
                    <td><input type="text" name="cfn_name" value="{$cfn_obj->name}" /></td>
                    <td>{lang('Current')}</td>
                </tr>
                
                <tr>
                    <td>{lang('Field')}</td>
                    <td>
                        {foreach $module_fields as $module_field}
                            <div class="line">
                                <input type="checkbox" name="field_choose[]" value="{$module_field.id}" {if $this->is_check($module_field.name, $custom_fields)}checked{/if}/> {get_label($module_field.name)}
                            </div>
                        {/foreach}
                    </td>
                    <td>
                        {foreach $custom_fields as $custom_field}
                            <div class="line">{get_label($custom_field.name)}</div>
                        {/foreach}
                    </td>
                </tr>                
            </tbody>
        </table>
    </form>
</div>