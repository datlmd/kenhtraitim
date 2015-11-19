{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Add Votes by admin
 * 
 * @package PenguinFW
 * @subpackage votes
 * @version 1.0.0
 */

*}

<h1 style="padding: 10px 0;">{lang('Add vote')}</h1>

<form action="{base_url('votes/admin_votes/add_vote')}" method="post" id="FormEditVotes" onSubmit="ajaxSubmit('FormEditVotes');return false;">
    <input type="hidden" name="resource_name" value="{$resource_name}" />
    <input type="hidden" name="record_id" value="{$record_id}" />
    <input type="hidden" name="field_count" value="{$smarty.const.MUSIC_VOTE_COUNT}" />
    <input type="hidden" name="vote_type_id" value="{ConstMusicGlobal::VoteTypeID}" />
    <table class="list">
        <tbody>

            <tr>
                <td class="left">{lang('Username')}</td>
                <td class="left"><input type="text" name="username" value="" /></td>
            </tr>
            
            <tr>
                <td class="left"></td>
                <td class="left"><input type="submit" name="submit" value="{lang('Add')}" /></td>
            </tr>

        </tbody>
    </table>
</form>