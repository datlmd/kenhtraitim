{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Admin music singer categories manager')}</h1>

    <div class=buttons>
        <a onclick="submit_action( 'MusicsSearch', '/musics/admin_music_singer_categories/export/')" style="cursor: pointer;" class="button"><span>{lang('Export')}</span></a>
       
        <a href="{base_url('musics/admin_music_singer_categories/add')}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('musics/admin_music_singer_categories/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">
    
    <form action="" method="get" id="MusicsSearch">
        <table class="filter">
            <tbody>
                <tr>                  
                    <td>
                        <label>{lang('Name')}</label>
                        <input type="text" name="name" value="{$smarty.get.name}" />
                    </td>
                    
                    <td>
                        <label>{lang('Event')}</label>
                        <select name="event_id" style="width: 150px;">
                            <option value="">All</option>
                            {foreach $events as $event}
                                <option value="{$event.id}" {if $smarty.get.event_id eq $event.id}selected{/if}>{$event.name}</option>
                                {/foreach}
                        </select>
                    </td>
                    				
                    <td><a onclick="submit_action( 'MusicsSearch', '/musics/admin_music_singer_categories/')" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
                
    <form action="{base_url('musics/admin_music_singer_categories/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
    </form>

</div>
