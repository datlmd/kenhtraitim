{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Admin Photo Manager
 * 
 * @package PenguinFW
 * @subpackage photos
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Photo manager')}</h1>
    
    <div class=buttons>      
         {*<a onclick="submit_action('{base_url()}photos/admin_photos/export/')" style="cursor: pointer;" class="button"><span>{lang('Export')}</span></a>     *}
        <a href="{base_url('photos/admin_photos/add')}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="javascript:void(0);" class="button JsActionPublish"><span>{lang('Publish')}</span></a>
        <a href="javascript:void(0);" class="button JsActionUnPublish"><span>{lang('Hide')}</span></a>
        
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('modules/admin_modules/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>
<div class="content">
    <form action="" method="get" id="FilterUser">
        <table class="filter">
            <tbody>
                <tr>
                    <td>
                        <label>{lang('Category')}</label>
                        <select name="photo_category_id" id="photo_category_id">
                            <option value="">{lang('All')}</option>
                            {$category_html = '<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
                            {$indent_symbol = '-&nbsp;'}
                            {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, array($smarty.get.photo_category_id))}
                        </select>
                    </td>
                    <td>
                        <label>{lang('Album')}</label>
                        <select name="photo_album_id" id="photo_album_id">
                            {foreach $photo_album_ids as $photo_album_id}
                                <option value="{$photo_album_id.id}" {if $smarty.get.photo_album_id != '' && $smarty.get.photo_album_id == $photo_album_id.id}selected{/if}>{lang($photo_album_id.name)}</option>
                            {/foreach}                   
                        </select>
                    </td>
                    
                    <td>
                        <label>{lang('Status')}</label>
                        <select name="photo_status_id">
                            <option value="">{lang('All')}</option>
                            {foreach $photo_status_ids as $photo_status_id}
                                <option value="{$photo_status_id.id}" {if $smarty.get.photo_status_id != '' && $smarty.get.photo_status_id == $photo_status_id.id}selected{/if}>{lang($photo_status_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                    
                    <td>
                        <label>{lang('From date')}</label>
                        <input type="text" name="from_date" class="pgDate" value="{$smarty.get.from_date}" />
                    </td>
                    
                    <td>
                        <label>{lang('To date')}</label>
                        <input type="text" name="to_date" class="pgDate" value="{$smarty.get.to_date}" />
                    </td>
                    <td>
                        <label>{lang('Name')}</label>
                        <input type="text" name="name" value="{$smarty.get.name}" />
                    </td>
                    
                    <td><a onclick="$('#FilterUser').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
    <form action="{base_url('photos/admin_photos/delete')}" class="JsDeleteForm" method="post">
        <input type="hidden" name="publish_type" value="0" />
        <input type="hidden" name="p_redirect" value="0" />
        {include file="../../elements/list_view.tpl"}
    </form>
</div>

{literal}
    <script type="text/javascript">
    $('document').ready(function() {
        $('input[name="p_redirect"]').val(document.location.href);
    });
    </script>
{/literal}

<script type="text/javascript">
    $(document).ready(function(){
        $('#photo_category_id').change(function() {
            var url_get_album = '';
            var photo_category_id = $('#photo_category_id').val();
            if(photo_category_id == '')
                photo_category_id = 'all';

            $.post('{base_url()}photos/admin_photos/getAlbums/' + photo_category_id +'/1',
            {
            },
                    function(data) {
                        var albums = jQuery.parseJSON(data);
                        if (albums && albums.length > 0) {
                            $('#photo_album_id').html('');

                            for (x in albums) {
                                $('#photo_album_id').append('<option value="'+albums[x]['id']+'">'+albums[x]['name']+'</option>');
                            }
                        }
                        else {
                            $('#photo_album_id').html('<option value="0">{lang('No Album')}</option>');
                        }
                    });
            return false;
        });
        //Load lại trang  1 lần để lấy đúng loại
    });
</script>