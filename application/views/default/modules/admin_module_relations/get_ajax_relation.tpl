{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Modules
 * @version 1.0.0
 */

*}
{foreach $relations as $relation}
    <div class="line">
        <input type="checkbox" name="relation_ids[]" value="{$relation.module_relation_id}" /> {$relation.resource}
    </div>
{/foreach}