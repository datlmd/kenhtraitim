  
                        
{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * ADD Survey Question
 * 
 * @package PenguinFW
 * @subpackage surveys
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Survey Question')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditUsers').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormEditUsers">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left head">{get_label('question_status_id')}</td>
                    <td class="left">
                        <select name="question_status_id">                            
                            {foreach $question_status_ids as $question_status_id}
                                <option value="{$question_status_id.id}" {if $question_status_id.id == $edit_module.question_status_id}selected{/if}>{lang($question_status_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left head">{get_label('survey_question_type_id')}</td>
                    <td class="left">
                        <select name="survey_question_type_id">
                            {foreach $survey_question_types as $survey_question_type}
                                <option value="{$survey_question_type.id}" {if $survey_question_type.id == $edit_module.survey_question_type_id}selected{/if}>{$survey_question_type.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>                            

                <tr>
                    <td class="left head">{get_label('name')}</td>
                    <td class="left"><input style="width: 300px;" type="text" name="name" value="{$edit_module.name}" /></td>
                </tr>

                <tr>
                    <td class="left head">{get_label('description')}</td>
                    <td class="left"><textarea rows="5" cols="33" name="description">{$edit_module.description}</textarea></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('survey_group')}</td>
                    <td class="left">
                        <select name="survey_group[]" multiple="multiple" size="4">
                            {foreach $survey_groups as $survey_group}
                                <option value="{$survey_group.id}" {if $survey_group.id == $edit_module.survey_group}selected{/if}>{$survey_group.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left head">{get_label('is_other_answer')}</td>
                    <td class="left">
                        <select name="is_other_answer">
                            {foreach $value_is_ids as $key => $value}
                                <option value="{$key}">{$value}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left head">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="{$edit_module.weight}" /></td>
                </tr>
            </tbody>
        </table>
    </form>

</div>
