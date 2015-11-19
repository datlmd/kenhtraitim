{*
    HungTD
    
    Template
    
    INDEX - router_configs
*}

<div class="heading">
    <h1>{lang('Router manager')}</h1>

    <div class=buttons>
        {if $resource_name}
            <a href="{base_url('router_configs/admin_router_configs/add')}/{$module_name}/{$resource_name}" class="button"><span>{lang('Add')}</span></a>
        {else}
            <a href="{base_url('router_configs/admin_router_configs/add')}/{$module_name}" class="button"><span>{lang('Add')}</span></a>
        {/if}
        <a href="javascript:void(0)" onClick="$('#RouterConfigIndex').submit();" class="button"><span>{lang('Save')}</span></a>
        <a href="{$url_publish}" class="button"><span>{lang('Publish')}</span></a>
    </div>
</div>

<div class="content">    
    <form action="" method="post" id="RouterConfigIndex">
        <input type="hidden" name="module_name" value="{$module_name}" />
        <input type="hidden" name="resource_name" value="{$resource_name}" />
        <table class="list">
            <thead>
                <tr>
                    <td class="left">{lang('Module')}</td>
                    <td class="left">{lang('Resource')}</td>
                    <td class="left">{lang('Action')}</td>
                    <td class="left">{lang('Map to')}</td>
                    <td class="left">{lang('Action')}</td>
                </tr>
            </thead>

            <tbody>
                {foreach $routers as $router}
                    <tr>
                        <td class="left">{$router.module}</td>
                        <td class="left">{$router.resource}</td>
                        <td class="left">{$router.action}</td>
                        <td class="left"><input type="text" name="router[{$router.id}]" value="{$router.router}" /></td>
                        <td class="left">
                            {if $module_name eq '' || $resource_name eq ''}
                                {if $module_name eq ''}
                                    <a href="{base_url('router_configs/admin_router_configs/index')}/{$router.module}" class="action">{lang('Router resource')}</a>
                                {else}
                                    <a href="{base_url('router_configs/admin_router_configs/index')}/{$router.module}/{$router.resource}" class="action">{lang('Router resource')}</a>
                                {/if}
                            {else}
                                <a href="{base_url('router_configs/admin_router_configs/edit')}/{$router.id}" class="action">{lang('Edit')}</a>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </form>
</div>