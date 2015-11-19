{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Module_fields
 * 
 * @package PenguinFW
 * @subpackage module_fields
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add module fields')} <span class="highlight">{lang('Module resource')}: {$resource_name}</span></h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddModule_fields').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}        
    
    <form action="" method="post" id="FormAddModule_fields">
        <input type="hidden" name="resource_id" value="{$resource_id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('field_type')}</td>
                    <td class="left">
                        <select name="field_type">
                            <option value="{ConstFieldType::text}">{ConstFieldType::text}</option>
                            <option value="{ConstFieldType::area}">{ConstFieldType::area}</option>
                            <option value="{ConstFieldType::num}">{ConstFieldType::num}</option>
                            <option value="{ConstFieldType::date}">{ConstFieldType::date}</option>
                            <option value="{ConstFieldType::datetime}">{ConstFieldType::datetime}</option>
                            <option value="{ConstFieldType::image}">{ConstFieldType::image}</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="" /></td>
                </tr>
                
                <tr>
                    <td class="left">{lang('Resource')}</td>
                    <td class="left">{$resource_name}</td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
