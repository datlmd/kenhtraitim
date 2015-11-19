
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Musics
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add music reports')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddMusics').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    
    <form action="" method="get" id="MusicsSearch">
        <table class="filter">
            <tbody>
                <tr>
                    
                    <td>
                        <label>{lang('Limit')}</label>
                        <input type="text" name="limit" value="{$smarty.get.limit}" />
                    </td>                                        
				
                    <td><a onclick="$('#MusicsSearch').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
    
    <form action="" method="post" id="FormAddMusics">
        <input type="hidden" name="type_id" value="{$type_id}" />
        
        <table class="list">
            <thead>
                <tr>
                    <td class="left"><input type="checkbox" name="AllSelect" value="1" class="JsListViewId" /></td>
                    <td class="left">{lang('Order')}</td>
                    <td class="left">{lang('ID')}</td>
                    <td class="left">{lang('Name')}</td>
                    <td class="left">{lang('Username')}</td>
                    <td class="left">{lang('Total point')}</td>
                </tr>
            </thead>

            <tbody>
                {assign var=i value=0}
                {foreach $musics as $music}                    
                    <tr>
                        <td class="left">
                            <input type="checkbox" name="listViewId[]" value="{$music.id}" class="listViewId" />
                            <input type="hidden" name="total[{$music.id}]" value="{$music.total}" />
                            <input type="hidden" name="listen[{$music.id}]" value="{$music.listen_point}" />
                            <input type="hidden" name="vote[{$music.id}]" value="{$music.vote_point}" />
                            <input type="hidden" name="sms_vote[{$music.id}]" value="{$music.sms_vote_point}" />
                        </td>
                        <td class="left">{assign var=i value=$i+1}{$i}</td>
                        <td class="left">{$music.id}</td>
                        <td class="left">{$music.name}</td>
                        <td class="left">{$music.username}</td>
                        <td class="left">{$music.total}</td>  
                    </tr>
                {foreachelse}
                    <tr>
                        <td class="left" colspan="10">{lang('No record')}</td>
                    </tr>
                {/foreach}            
            </tbody>
        </table>
    </form>

</div>
