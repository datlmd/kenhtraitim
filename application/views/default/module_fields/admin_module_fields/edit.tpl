{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Module_fields
 * 
 * @package PenguinFW
 * @subpackage module_fields
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit module fields')} <span class="highlight">{lang('Module resource')}: {$resource_name}</span></h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditModule_fields').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditModule_fields">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}"{if $field.name|strpos:'pg_' === FALSE} readonly="readonly"{/if} /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('field_type')}</td>
                    <td class="left">
                        <select name="field_type">
                            <option value="{ConstFieldType::text}" {if ConstFieldType::text eq $data_edit->field_type}selected{/if}>{ConstFieldType::text}</option>
                            <option value="{ConstFieldType::area}" {if ConstFieldType::area eq $data_edit->field_type}selected{/if}>{ConstFieldType::area}</option>
                            <option value="{ConstFieldType::num}" {if ConstFieldType::num eq $data_edit->field_type}selected{/if}>{ConstFieldType::num}</option>
                            <option value="{ConstFieldType::date}" {if ConstFieldType::date eq $data_edit->field_type}selected{/if}>{ConstFieldType::date}</option>
                            <option value="{ConstFieldType::datetime}" {if ConstFieldType::datetime eq $data_edit->field_type}selected{/if}>{ConstFieldType::datetime}</option>
                            <option value="{ConstFieldType::image}" {if ConstFieldType::image eq $data_edit->field_type}selected{/if}>{ConstFieldType::image}</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="{$data_edit->weight}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{lang('Resource')}</td>
                    <td class="left">{$resource_name}</td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
