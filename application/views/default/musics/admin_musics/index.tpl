
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
    <h1>{lang('Musics manager')}</h1>

    <div class=buttons>        
        <a href="{base_url('musics/admin_musics/addmp3')}/{$album_id}" class="button"><span>{lang('Add MP3')}</span></a>
        <a href="{base_url('musics/admin_musics/addvideo')}/{$album_id}" class="button"><span>{lang('Add Video')}</span></a>
        {if $album_id neq 0}
            <a href="{base_url('musics/admin_music_albums/view')}/{$album_id}" class="button"><span>{lang('Album')}</span></a>
        {/if}
        
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="javascript:void(0);" class="button JsActionPublish"><span>{lang('Publish')}</span></a>
        <a href="javascript:void(0);" class="button JsActionUnPublish"><span>{lang('Hide')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('musics/admin_musics/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
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
                        <label>{lang('Status')}</label>
                        <select name="status_id">
                            <option value="0">{lang('All')}</option>
                            <option value="1" {if $smarty.get.status_id eq 1}selected{/if}>{lang('Approved')}</option>
                            <option value="-1" {if $smarty.get.status_id eq -1}selected{/if}>{lang('No Approved')}</option>
                        </select>
                    </td>

                    <td>
                        <label>{lang('Name')}</label>
                        <input type="text" name="name" value="{$smarty.get.name}" />
                    </td>

                    <td>
                        <label>{lang('Type')}</label>
                        <select name="type_id">
                            <option value="">{lang('All')}</option>
                            {foreach $type_ids as $type_id}
                                <option value="{$type_id.id}" {if $smarty.get.type_id eq $type_id.id}selected{/if}>{lang($type_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>

                    <td>
                        <label>{lang('Quality')}</label>
                        <input type="text" name="hight_quality" value="{$smarty.get.hight_quality}" />
                    </td>

                    <td>
                        <label>{lang('Hit')}</label>
                        <select name="is_hit">
                            <option value="0">{lang('All')}</option>
                            <option value="1" {if $smarty.get.is_hit eq 1}selected{/if}>{lang('Hit')}</option>
                            <option value="-1" {if $smarty.get.is_hit eq -1}selected{/if}>{lang('No Hit')}</option>
                        </select>
                    </td>

                    <td>
                        <label>{lang('Singer')}</label>
                        <input type="text" name="singer_id" value="{$smarty.get.singer_id}" />
                    </td>

                    <td>
                        <label>{lang('Author')}</label>
                        <input type="text" name="author_id" value="{$smarty.get.author_id}" />
                    </td>
				
                    <td><a onclick="$('#MusicsSearch').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>

    <form action="{base_url('musics/admin_musics/delete')}" class="JsDeleteForm" method="post">
        <input type="hidden" name="publish_type" value="0" />
        {include file="../../elements/list_view.tpl"}
    </form>

</div>
