
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Old Html_templates
 * 
 * @package PenguinFW
 * @subpackage html_templates
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Html templates')}</h1>

    <div class=buttons>        
        <a href="{base_url('html_templates/admin_html_templates/publish_id')}/{$template_id}" class="button"><span>{lang('Publish')}</span></a>
        
        {if $old_templates neq false}
            <select class="JsCustomFieldChange">
                <option value="{base_url('html_templates/admin_html_templates/index/')}/{$template->resource_id}"></option>
                {foreach $old_templates as $old_template}
                    <option value="{base_url('html_templates/admin_html_templates/view/')}/{$old_template.id}" {if $template_id eq $old_template.id}selected{/if}>{pg_field_value($old_template.created, 'DATETIME')}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">
                
    <div class=textarea>
        <textarea name="content" class="html_template" id="JsHighlightEditor">{$template->content}</textarea>
    </div>    

</div>
