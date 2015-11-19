
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Comments
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>Admin comments bad word manager</h1>

    <div class=buttons>        
        <a href="javascript:void(0);" class="button JsActionPublish"><span>{lang('Publish')}</span></a>
        <a href="javascript:void(0);" class="button JsActionUnPublish"><span>{lang('Hide')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('comments/admin_comments/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">
    
    <form action="{base_url('comments/admin_comments/bad_word/delete')}" class="JsDeleteForm" method="post">
        <input type="hidden" name="publish_type" value="0" />
        <input type="hidden" name="p_redirect" value="/index/{$p_resource_name}" />
        <input type="hidden" name="update_field_name" value="{$update_field_name}" />
        {include file="../../elements/list_view.tpl"}
    </form>

</div>
