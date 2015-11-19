{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Html_templates
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Html templates manager')}: {if $resource_id eq 0}<span class="highlight">{lang('Global')}</span>{/if} <span class="highlight"> {lang('Module')}: {$resource_name}</span></h1>
    <div class=buttons>
        
    </div>
</div>

<div class="content">
    <table class="list">
        <thead>
            <tr>
                <td class="left">{lang('File name')}</td>
                <td class="left">{lang('Action')}</td>
            </tr>
        </thead>
        
        <tbody>
            {if $css neq FALSE}
                {foreach $css as $fcss}
                    <tr>
                        <td class="left"><b>{$fcss|replace:'__':'/'}.css</b> | {lang('Css')}</td>
                        <td class="left"><a href="{base_url('html_templates/admin_html_templates/edit')}/0/{$fcss}/css">{lang('Edit')}</a></td>
                    </tr>
                {/foreach}
            {/if}
            
            {if $js neq FALSE}
                {foreach $js as $fjs}
                    <tr>
                        <td class="left"><b>{$fjs|replace:'__':'/'}.js</b> | {lang('Javascript')}</td>
                        <td class="left"><a href="{base_url('html_templates/admin_html_templates/edit')}/0/{$fjs}/js">{lang('Edit')}</a></td>
                    </tr>
                {/foreach}
            {/if}
            
            {if $tpls neq FALSE}
                {foreach $tpls as $tpl}
                    <tr>
                        <td class="left"><b>{$tpl}.tpl</b> | {lang('Template')}</td>
                        <td class="left">
							<a href="{base_url('html_templates/admin_html_templates/edit')}/{$resource_id}/{$tpl}/tpl" class="action">{lang('Edit')}</a>							
						</td>
                    </tr>
                {/foreach}
            {/if}
        </tbody>
    </table>
</div>
