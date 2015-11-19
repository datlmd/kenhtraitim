{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin View table list
 * 
 * @package PenguinFW
 * @subpackage Element
 * @version 1.0.0
 */

*}
<div id="total_records" style="width: 30%; text-align: left ; color:blue; font-weight: bold; font-size: 18px;" >Total: {if $total_records}{$total_records}{else}0{/if} records</div>
<table class="list">
    {if $fields eq false}
        <tbody>
            <tr><td class="left">{lang('No record')}</td></tr>
        </tbody>
    {else}
        <thead>
            <tr>
                <td class="left"><input type="checkbox" name="AllSelect" value="1" class="JsListViewId" /></td>
                    {foreach from=$fields key=field item=field_type}
                    <td class="left" id="head_{$field}">
                        <div>
                        {get_label($field)}

                        {get_filter_img($field)}

                        {get_linked_sort_img($field)}
                        </div>
                        <div class="filter_field" id="filter_{$field}" style="clear:both; float: left; margin-top: 5px; margin-right: -100px; width: 100%">
                            {if $smarty.get.$field !== '' && $smarty.get.$field !== NULL}&lbrack;<input {if $field == 'created' || $field == 'modified' || $field == 'dob'}class="pgDate"{/if} value="{$smarty.get.$field}" name="{$field}" type="text" style="outline:none; width:50% ; border: none; background: none; text-align: center;"/>&rbrack;
                            {/if}
                        </div>
                    </td>
                {/foreach}
                <td class="left">{lang('Action')}</td>
            </tr>
        </thead>

        <tbody>
            {foreach $list_views as $list_view}
                <tr>
                    <td class="left">
                        {if $list_view.id}
                            <input type="checkbox" name="listViewId[]" value="{$list_view.id}" class="listViewId" />
                        {else}                            
                            <input type="checkbox" name="listViewId[]" value="0" class="listViewId" disabled="disabled" />
                        {/if}                        
                    </td>
                    {foreach from=$fields key=field item=field_type}
                        {if is_image_link($list_view.$field)}
                            <td class="left">
                                <a class="fancybox" title="{img_url()}media/images/{$list_view.$field}" rel="group" href="{img_url()}media/images/{$list_view.$field}"><img width="140" src="{img_url()}media/images/{$list_view.$field}" /></a>
                            </td>
                        {elseif is_audio_link($list_view.$field)}
                            <td class="left">
                                <div id="show_media_file_{$list_view.id}"></div>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        write_audio_jwplayer('show_media_file_{$list_view.id}', '{base_url()}media/musics/{$list_view.$field}');
                                    });
                                </script>
                            </td>
                        {elseif is_video_link($list_view.$field)}
                            <td class="left">
                                <div id="show_media_file_{$list_view.id}"></div>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        write_video_jwplayer('show_media_file_{$list_view.id}', '{base_url()}media/videos/{$list_view.$field}');
                                    });
                                </script>
                            </td>
                        {elseif is_file_link($list_view.$field)}
                            <td class="left">
                                <a href="{base_url()}media/filemanager/{$list_view.$field}" target="_blank">Download</a>
                            </td>
                        {elseif is_log_file_link($list_view.$field)}
                            <td class="left">
                                <a href="{base_url()}tracking_logs/admin_tracking_logs/view/{$list_view.id}" target="_blank">View logs</a>
                            </td>
                        {else}
                            <td class="left">
                                {$value = pg_field_value($list_view.$field, $field_type)}
                                {$value}
                            </td>
                        {/if}
                    {/foreach}
                    <td class="left">
                        {if $list_view.id}
                            {link_action($link_edit, $list_view.id)}
                        {else}
                            {$params = array()}
                            {foreach $list_params as $param}
                                {$params[] = $list_view.$param}
                            {/foreach}                            
                            {link_action($link_edit, $params)}
                        {/if}
                    </td>
                </tr>
            {foreachelse}
                <tr>
                    <td class="left" colspan="10">{lang('No record')}</td>
                </tr>
            {/foreach}            
        </tbody>
    {/if}
</table>

<div style="width: 100%; height: 20px;">
    <div style="width:60% ; margin-top: 7px; float: left;">{$pagination_link}</div>
    <div id="total_records" style="width: 30%; text-align: right ; color:blue; float:right; font-weight: bold; font-size: 18px;" >Total: {if $total_records}{$total_records}{else}0{/if} records</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox();
    });
</script>
<script type="text/javascript">
    function write_audio_jwplayer(id_tag, file_link){
        jwplayer(id_tag).setup({
            file: file_link,
            width: 200,
            height: 80,
            autostart: false,
            primary: 'flash',
            "player": {
                "modes": {
                    "linear": {
                        "controls": {
                            "visible" : false,
                            "enableFullscreen": true,
                            "enablePlay": true,
                            "enablePause": true,
                            "enableMute": true,
                            "enableVolume": true,
                            "height" : 30
                        }
                    }
                }
            }
        });
    }

    function write_video_jwplayer(id_tag, file_link){
        jwplayer(id_tag).setup({
            file: file_link,
            width: 200,
            height: 200,
            autostart: false,
            primary: 'flash',
            "player": {
                "modes": {
                    "linear": {
                        "controls": {
                            "visible" : false,
                            "enableFullscreen": true,
                            "enablePlay": true,
                            "enablePause": true,
                            "enableMute": true,
                            "enableVolume": true,
                            "height" : 30
                        }
                    }
                }
            }
        });
    }
</script>