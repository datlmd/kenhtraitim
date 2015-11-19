{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Statistics
 * 
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin statistic permissions')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddStatistics').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddStatistics">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('campaign_id')}</td>
                    <td class="left">
                        <select name="campaign_id">
                            <option value="">{lang('All')}</option>
                            {foreach $campaign_ids as $campaign_id}
                                <option value="{$campaign_id.id}">{lang($campaign_id.name)}</option>
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
                                <option value="{$account_id.id}">{lang($account_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('permission')}</td>
                    <td class="left"><input type="text" name="permission" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
