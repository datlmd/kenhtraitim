
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Votes
 * 
 * @package PenguinFW
 * @subpackage votes
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit vote types')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditVotes').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormEditVotes">
        <input type="hidden" name="id" value="{$edit_module->id}" />
        <table class="list">
            <tbody>
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$edit_module->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('point')}</td>
                    <td class="left"><input type="text" name="point" value="{$edit_module->point}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_subtract')}</td>
                    <td class="left"><input type="checkbox" name="is_subtract" value="1" {if $edit_module->is_subtract eq 1}checked="checked"{/if} /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('is_dislike')}</td>
                    <td class="left"><input type="checkbox" name="is_dislike" value="1" {if $edit_module->is_dislike eq 1}checked="checked"{/if} /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_multi')}</td>
                    <td class="left"><input type="checkbox" name="is_multi" value="1" {if $edit_module->is_multi eq 1}checked="checked"{/if} /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time_minutes')}</td>
                    <td class="left"><input type="text" name="time_minutes" value="{$edit_module->time_minutes}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time_second_user')}</td>
                    <td class="left"><input type="text" name="time_second_user" value="{$edit_module->time_second_user}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time_second_browser')}</td>
                    <td class="left"><input type="text" name="time_second_browser" value="{$edit_module->time_second_browser}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time_second_ip')}</td>
                    <td class="left"><input type="text" name="time_second_ip" value="{$edit_module->time_second_ip}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
