
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * EDIT Router_configs
 * 
 * @package PenguinFW
 * @subpackage router_configs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit router')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditRouter_configs').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">    
    <form action="" method="post" id="FormEditRouter_configs">
        <input type="hidden" name="id" value="{$router->id}" />        
        <table class="list">
            <tbody>
                <tr>
                    <td class="left">{get_label('action')}</td>
                    <td class="left"><input type="text" name="action" value="{$router->action}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('router')}</td>
                    <td class="left"><input type="text" name="router" value="{$router->router}" /></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>
