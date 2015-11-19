
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
    <h1>{lang('Add Survey Answer')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddUsers').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormAddUsers">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left head">{get_label('question')}</td>
                    <td class="left">
                        <select style="width:400px;" name="survey_question_id">                            
                            {foreach $questions as $question}
                                <option value="{$question.id}" {if $question.id == $current_question}selected{/if}>{lang($question.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                
                                       <tr>
                    <td class="left head">{get_label('name')}</td>
                    <td class="left"><textarea rows="5" cols="33" name="name"></textarea></td>
                </tr>

                <tr>
                    <td class="left head">{get_label('weight')}</td>
                    <td class="left"><input style="width: 70px;" type="text" name="weight" value="" /></td>
                </tr>

 
                
                 <tr>
                    <td class="left head">{get_label('is right?')}</td>
                    <input type="hidden" name="is_right" value="0"/>
                    <td class="left"><input type="checkbox" name="is_right" value="1" /></td>
                </tr>
                

                

            </tbody>
        </table>
                    
                   
    </form>

</div>
