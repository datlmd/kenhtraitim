{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Vn_areas
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Admin regions manager')}</h1>

    <div class=buttons>
        <a href="{base_url('vn_areas/admin_regions/add')}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('vn_areas/admin_regions/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">
    
    <form action="{base_url('vn_areas/admin_regions/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
    </form>

</div>
