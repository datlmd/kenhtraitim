{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Statistics
 * 
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin statistic permissions')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditStatistics').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditStatistics">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('campaign_id')}</td>
                    <td class="left">
                        <select name="campaign_id">
                            <option value="">{lang('All')}</option>
                            {foreach $campaign_ids as $campaign_id}
                                <option value="{$campaign_id.id}" {if $data_edit->campaign_id eq $campaign_id.id}selected{/if}>{lang($campaign_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('account_id')}</td>
                    <td class="left">
                        <select name="account_id">
                            <option value="">{lang('All')}</option>
                            {foreach $account_ids as $account_id}
                                <option value="{$account_id.id}" {if $data_edit->account_id eq $account_id.id}selected{/if}>{lang($account_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('permission')}</td>
                    <td class="left"><input type="text" name="permission" value="{$data_edit->permission}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
