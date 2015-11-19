
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Router_configs
 * 
 * @package PenguinFW
 * @subpackage router_configs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add router')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddRouter_configs').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">    
    <form action="" method="post" id="FormAddRouter_configs">        
        <table class="list">
            <tbody>
                {if $module_name && $resource_name}                    
                    <tr>
                        <td class="left">{get_label('action')}</td>
                        <td class="left">
                            <input type="hidden" name="module" value="{$module_name}" />
                            <input type="hidden" name="resource" value="{$resource_name}" />
                            <input type="text" name="action" value="" />
                        </td>
                    </tr>
                {else}
                    {if $module_name}                        
                        <tr>
                            <td class="left">{get_label('resource')}</td>
                            <td class="left">
                                <input type="hidden" name="module" value="{$module_name}" />
                                <input type="text" name="resource" value="" />
                                <input type="hidden" name="action" value="" />
                            </td>
                        </tr>
                    {else}
                        <tr>
                            <td class="left">{get_label('module')}</td>
                            <td class="left">
                                <input type="text" name="module" value="" />
                                <input type="hidden" name="resource" value="" />
                                <input type="hidden" name="action" value="" />
                            </td>
                        </tr>
                    {/if}                    
                {/if}

                <tr>
                    <td class="left">{get_label('router')}</td>
                    <td class="left"><input type="text" name="router" value="" /></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>
