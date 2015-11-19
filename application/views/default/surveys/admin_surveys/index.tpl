{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Admin Question Manager
 * 
 * @package PenguinFW
 * @subpackage surveys
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Surveys manager')}</h1>
    
    <div class=buttons>                
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
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
                        <label>{lang('Question')}</label>
                        <select style="width: 300px;" name="survey_question_id">
                            <option value="">{lang('All')}</option>
                            {foreach $questions as $question}
                                <option value="{$question.id}" {if $smarty.get.survey_question_id != '' && $smarty.get.survey_question_id == $question.id}selected{/if}>{lang($question.name)}</option>
                            {/foreach}                            
                        </select>
                    </td>
                    
                    <td id="answerss">
                        <label>{lang('Answer')}</label>
                        
                        <select id="answers_survey_" style="width: 250px; " name="survey_answer_id">
                            <option value="">{lang('All')}</option>                                 
                        </select>
                        
                        {foreach $answerss as $key => $answers}
                        <select id="answers_survey_{$key}" style="width: 250px; display: none;" name="survey_answer_id">
                            <option value="">{lang('All')}</option>
                            {foreach $answers as $answer}
                                <option value="{$answer.id}" {if $smarty.get.survey_answer_id != '' && $smarty.get.survey_answer_id == $answer.id}selected{/if}>{lang($answer.name)}</option>
                            {/foreach}                            
                        </select>
                         {/foreach}  
                    </td>
                    
                    <td>
                        <label>{lang('User')}</label>
                        <select style="width: 200px;" name="survey_user_id">
                            <option value="">{lang('All')}</option>
                            {foreach $users as $user}
                                <option value="{$user.user_id}" {if $smarty.get.survey_user_id != '' && $smarty.get.survey_user_id == $user.user_id}selected{/if}>{lang($user.username)}</option>
                            {/foreach}                            
                        </select>
                    </td>
                    
                    <td>
                        <label>{lang('Result')}</label>
                        <select name="survey_result">
                            <option value="">{lang('All')}</option>
                            {foreach $results as $result}
                                <option value="{$result.id}" {if $smarty.get.survey_result != '' && $smarty.get.survey_result == $result.id}selected{/if}>{lang($result.name)}</option>
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
                    
                    <td><a onclick="$('#FilterUser').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
    
    <form action="{base_url('surveys/admin_survey_answers/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
    </form>
</div>