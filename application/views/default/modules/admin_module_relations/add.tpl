{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Modules
 * 
 * @package PenguinFW
 * @subpackage modules
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add module relations')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddModules').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormAddModules">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('module_id')}</td>
                    <td class="left">
                        <select name="module_id" id="SelectModuleId" onChange="getContentAjax('{base_url('modules/admin_module_relations/data_field')}', 'SelectForeignKey', 'SelectModuleId');">
                            <option></option>
                            {foreach $module_ids as $module_id}
                                <option value="{$module_id.id}">{lang($module_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('module_relation_id')}</td>
                    <td class="left">
                        <select name="module_relation_id" id="SelectModuleRelationId" onChange="getContentAjax('{base_url('modules/admin_module_relations/data_field')}', 'SelectPrimaryKey', 'SelectModuleRelationId');">                            
                            <option></option>
                            {foreach $module_relation_ids as $module_relation_id}
                                <option value="{$module_relation_id.id}">{lang($module_relation_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('primary_key')}</td>
                    <td class="left">
                        <select name="primary_key" id="SelectPrimaryKey">                            
                            
                        </select>
                    </td>                    
                </tr>

                <tr>
                    <td class="left">{get_label('foreign_key')}</td>
                    <td class="left">
                        <select name="foreign_key" id="SelectForeignKey">                            
                            
                        </select>
                    </td>                    
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
