{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * View Category
 * 
 * @package PenguinFW
 * @subpackage photos
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Photo Album info')}: {$view_data->name}</h1>
    
    <div class=buttons>                
        <a href="{base_url()}photos/admin_photo_albums/edit/{$view_data->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
    
    <div class=buttons>                
        <a href="{base_url()}photos/admin_photos/add/{$view_data->photo_category_id}/{$view_data->id}" class="button"><span>{lang('Add Photo')}</span></a>
    </div>
</div>
<div class="content">
    <table class="list">
        <tbody>
            <tr>
                <td class="left head">{get_label('created')}</td>
                <td class="left">{pg_field_value($view_data->created, 'DATETIME')}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('modified')}</td>
                <td class="left">{pg_field_value($view_data->modified, 'DATETIME')}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('album_status_id')}</td>
                <td class="left">
                    {foreach $album_status_ids as $album_status_id}
                        {if $view_data->album_status_id == $album_status_id.id}
                            {$album_status_id.name}
                        {/if}
                    {/foreach}
                </td>
            </tr>
            <tr>
                <td class="left head">{get_label('name')}</td>
                <td class="left">{$view_data->name}</td>
            </tr>            
            <tr>
                <td class="left head">{get_label('description')}</td>
                <td class="left">{$view_data->description}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('slug')}</td>
                <td class="left">{$view_data->slug}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('photo_category_id')}</td>
                <td class="left">{$view_data->parent_name}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('counter_photo')}</td>
                <td class="left">{$view_data->counter_photo}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('weight')}</td>
                <td class="left">{$view_data->weight}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('is_allow_comment')}</td>
                <td class="left">{$comment_ids[$view_data->is_allow_comment]}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('username')}</td>
                <td class="left">{$view_data->username}</td>
            </tr>
        </tbody>
    </table>
</div>