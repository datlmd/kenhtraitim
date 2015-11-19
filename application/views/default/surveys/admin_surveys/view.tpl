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
    <h1>{lang('Survey Answer info')}: {$view_data->name}</h1>
    
    <div class=buttons>                
        <a href="{base_url()}surveys/admin_survey_answers/edit/{$view_data->id}" class="button"><span>{lang('Edit')}</span></a>
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
                <td class="left head">{get_label('question')}</td>
                <td class="left">{$view_data->survey_question_id}</td>
            </tr>
            
            <tr>
                <td class="left head">{get_label('name')}</td>
                <td class="left">{$view_data->name}</td>
            </tr>    
            
            <tr>
                <td class="left head">{get_label('is right')}</td>
                <td class="left">{$view_data->is_right}</td>
            </tr>
  
            <tr>
                <td class="left head">{get_label('weight')}</td>
                <td class="left">{$view_data->weight}</td>
            </tr>
        </tbody>
    </table>
</div>