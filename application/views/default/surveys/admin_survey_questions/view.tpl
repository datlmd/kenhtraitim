{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * View Survey Question
 * 
 * @package PenguinFW
 * @subpackage surveys
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Survey Question info')}: {$view_data->name}</h1>
    
    <div class=buttons>                
        <a href="{base_url()}surveys/admin_survey_questions/edit/{$view_data->id}" class="button"><span>{lang('Edit')}</span></a>
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
                <td class="left head">{get_label('question_status_id')}</td>
                <td class="left">
                    {foreach $question_status_ids as $question_status_id}
                        {if $view_data->question_status_id == $question_status_id.id}
                            {$question_status_id.name}
                        {/if}
                    {/foreach}
                </td>
            </tr>
            <tr>
                <td class="left head">{get_label('survey_question_type_id')}</td>
                <td class="left">
                    {foreach $survey_question_types as $survey_question_type}
                        {if $survey_question_type.id == $view_data->survey_question_type_id}
                            {$survey_question_type.name}
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
                <td class="left head">{get_label('survey_group')}</td>
                <td class="left">
                    {foreach $survey_groups as $survey_group}
                        {if in_array($survey_group.id, $view_data->survey_group)}
                            {$survey_group.name}{if !$survey_group@last}, {/if}
                        {/if}
                    {/foreach}
                </td>
            </tr>
            <tr>
                <td class="left head">{get_label('is_other_answer')}</td>
                <td class="left">{$value_is_ids[$view_data->is_other_answer]}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('weight')}</td>
                <td class="left">{$view_data->weight}</td>
            </tr>
        </tbody>
    </table>
</div>