{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST FIELD
 * 
 * @package PenguinFW
 * @subpackage Modules
 * @version 1.0.0
 */

*}
{foreach $module_fields as $field}
    <option value="{$field.name}">{$field.name}</option>
{/foreach}