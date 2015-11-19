
{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * EDIT Survey Group
 * 
 * @package PenguinFW
 * @subpackage surveys
 * @version 1.0.0
 */

*}


<div class="heading">
    <h1>{lang('Edit Admin group')}</h1>

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
	                <td class="left head">{get_label('group_status_id')}</td>
	                <td class="left">
	                   <select name="group_status_id">                            
                             {foreach $group_status_ids as $group_status_id}
                                <option value="{$group_status_id.id}" {if $group_status_id.id == $edit_module.group_status_id}selected{/if}>{lang($group_status_id.name)}</option>
                            {/foreach}
                        </select></td>
	            </tr>            
	            <tr>
	                <td class="left head">{get_label('name')}</td>
	                <td class="left"><input type="text" name="name" value="{$edit_module.name}" /></td>
	            </tr>            
	            <tr>
	                <td class="left head">{get_label('description')}</td>
	                <td class="left"><textarea rows="5" cols="33" name="description">{$edit_module.description}</textarea></td>
	            </tr>
	            <tr>
                    <td class="left head">{get_label('is_random_question')}</td>
                    <td class="left">
                        <select name="is_random_question">
                            {foreach $value_is_ids as $key => $value}
                                <option value="{$key}" {if $key==$edit_module.is_random_question}selected{/if}>{$value}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="left head">{get_label('is_random_answer')}</td>
                    <td class="left">
                        <select name="is_random_answer">
                            {foreach $value_is_ids as $key => $value}
                                <option value="{$key}" {if $key==$edit_module.is_random_answer}selected{/if}>{$value}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
	            
            </tbody>
        </table>
    </form>

</div>
