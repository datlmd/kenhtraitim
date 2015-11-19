{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Modules
 * 
 * @package PenguinFW
 * @subpackage modules
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin module relations')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditModules').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
       
    <form action="" method="post" id="FormEditModules">
        <input type="hidden" name="module_id" value="{$data_edit->module_id}" />
        <input type="hidden" name="module_relation_id" value="{$data_edit->module_relation_id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('module_id')}</td>
                    <td class="left">
                        <select name="module_id">
                            <option value=""></option>
                            {foreach $module_ids as $module_id}
                                <option value="{$module_id.id}" {if $data_edit->module_id eq $module_id.id}selected{/if}>{lang($module_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('module_relation_id')}</td>
                    <td class="left">
                        <select name="module_relation_id">
                            <option value=""></option>
                            {foreach $module_relation_ids as $module_relation_id}
                                <option value="{$module_relation_id.id}" {if $data_edit->module_relation_id eq $module_relation_id.id}selected{/if}>{lang($module_relation_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('primary_key')}</td>
                    <td class="left">
                        <select name="primary_key">                            
                            {foreach $pk_list_colums as $pk_list_colum}
                                <option value="{$pk_list_colum.name}" {if $data_edit->primary_key eq $pk_list_colum.name}selected{/if}>{$pk_list_colum.name}</option>
                            {/foreach}
                        </select>
                    </td> 
                </tr>

                <tr>
                    <td class="left">{get_label('foreign_key')}</td>
                    <td class="left">
                        <select name="foreign_key">                            
                            {foreach $fk_list_colums as $fk_list_colum}
                                <option value="{$fk_list_colum.name}" {if $data_edit->foreign_key eq $fk_list_colum.name}selected{/if}>{$fk_list_colum.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
