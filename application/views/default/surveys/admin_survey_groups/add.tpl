
{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * ADD Survey Group
 * 
 * @package PenguinFW
 * @subpackage surveys
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Survey Group')}</h1>

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
                    <td class="left head">{get_label('group_status_id')}</td>
                    <td class="left">
                        <select name="group_status_id">                            
                            {foreach $group_status_ids as $group_status_id}
                                <option value="{$group_status_id.id}">{lang($group_status_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>                                

                <tr>
                    <td class="left head">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left head">{get_label('description')}</td>
                    <td class="left"><textarea rows="5" cols="33" name="description"></textarea></td>
                </tr>

                <tr>
                    <td class="left head">{get_label('is_random_question')}</td>
                    <td class="left">
                        <select name="is_random_question">
                            {foreach $value_is_ids as $key => $value}
                                <option value="{$key}">{$value}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left head">{get_label('is_random_answer')}</td>
                    <td class="left">
                        <select name="is_random_answer">
                            {foreach $value_is_ids as $key => $value}
                                <option value="{$key}">{$value}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>                         
            </tbody>
        </table>
    </form>

</div>
