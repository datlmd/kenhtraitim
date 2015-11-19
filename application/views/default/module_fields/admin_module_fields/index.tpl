{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Module_fields
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Module fields manager')} <span class="highlight">{lang('Module resource')}: {$resource_name}</span></h1>

    <div class=buttons>
        <a href="{base_url('module_fields/admin_module_fields/add')}/{$resource_id}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button" onClick="$('#FormModuleField').submit();"><span>{lang('Update')}</span></a>        
    </div>
</div>

<div class="content">
    
    <form action="" id="FormModuleField" method="post">
        <input type="hidden" name="resource_id" value="{$resource_id}" />
        <table class="list">
            <thead>
                <tr>
                    <td class="left">{lang('Order')}</td>
                    <td class="left">{lang('Name')}</td>
                    <td class="left">{lang('Field type')}</td>
                    <td class="left">{lang('Weight')}</td>
                    <td class="left">{lang('Action')}</td>
                </tr>
            </thead>
            
            <tbody>
                {$i=0}
                {foreach $list_views as $field}                    
                    {$i = $i+1}
                    <tr>
                        <td class="left">{$i}</td>
                        <td class="left">{$field.name}</td>
                        <td class="left">{$field.field_type}</td>
                        <td class="left"><input type="text" name="weight[{$field.id}]" value="{$field.weight}" style="width:50px;" /></td>
                        <td class="left"><a href="{base_url('module_fields/admin_module_fields/edit')}/{$field.id}">{lang('Edit')}</a></td>
                    </tr>
                {foreachelse}
                    <tr>
                        <td colspan="4">{lang('No record')}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </form>

</div>
