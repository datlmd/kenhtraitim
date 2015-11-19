{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * View Survey Group
 * 
 * @package PenguinFW
 * @subpackage surveys
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Survey Group info')}: {$view_data->name}</h1>
    
    <div class=buttons>                
        <a href="{base_url()}surveys/admin_survey_groups/edit/{$view_data->id}" class="button"><span>{lang('Edit')}</span></a>
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
                <td class="left head">{get_label('group_status_id')}</td>
                <td class="left">
                    {foreach $group_status_ids as $group_status_id}
                        {if $view_data->group_status_id == $group_status_id.id}
                            {$group_status_id.name}
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
                <td class="left head">{get_label('is_random_question')}</td>
                <td class="left">{$value_is_ids[$view_data->is_random_question]}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('is_random_answer')}</td>
                <td class="left">{$value_is_ids[$view_data->is_random_answer]}</td>
            </tr>
        </tbody>
    </table>
</div>