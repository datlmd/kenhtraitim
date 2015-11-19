
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Html_templates
 * 
 * @package PenguinFW
 * @subpackage html_templates
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Html templates')}</h1>
    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditHtml_templates').submit();" class="button"><span>{lang('Edit')}</span></a>
		<a href="{base_url('html_templates/admin_html_templates/history')}/{$resource_id}/{$file_name}/{$ext}" class="button"><span>{lang('History')}</span></a>
        <a href="{base_url('html_templates/admin_html_templates/publish')}/{$resource_id}/{$file_name}/{$ext}" class="button"><span>{lang('Publish')}</span></a>
        
        {if $old_templates neq false}
            <select class="JsCustomFieldChange">
                <option value="{base_url('html_templates/admin_html_templates/index/')}/{$resource_id}"></option>
                {foreach $old_templates as $old_template}
                    <option value="{base_url('html_templates/admin_html_templates/view/')}/{$old_template.id}" {if $template_id eq $old_template.id}selected{/if}>{$old_template.created}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">
            
    <form action="" method="post" id="FormEditHtml_templates">
        <input type="hidden" name="name" value="{$file_name}" />
        <input type="hidden" name="ext" value="{$ext}" />
        <input type="hidden" name="resource_id" value="{$resource_id}" />
        <div class=textarea>
            <textarea name="content" class="html_template" id="JsHighlightEditor">{$content_edit}</textarea>
        </div>
    </form>

</div>
