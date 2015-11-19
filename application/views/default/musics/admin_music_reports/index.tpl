
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Admin music reports manager')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditOrderMusics').submit();" class="button"><span>{lang('Save')}</span></a>
        <a href="{base_url('musics/admin_music_reports/add')}/{$type_id}" class="button"><span>{lang('Add')}</span></a>
        <a href="{base_url('musics/admin_music_reports/report')}/{$type_id}" class="button"><span>{lang('Export')}</span></a>
        <a href="{base_url('musics/admin_music_reports/clear')}/{$type_id}" class="button"><span>{lang('Clear')}</span></a>
    </div>
</div>

<div class="content">
    <form action="" id="FormEditOrderMusics" method="post">
        <input type="hidden" name="type_id" value="{$type_id}" />
        <table class="list">
            <thead>
                <tr>                
                    <td class="left">{lang('Order')}</td>                
                    <td class="left">{lang('Music name')}</td>
                    <td class="left">{lang('Total point')}</td>
                    <td class="left">{lang('Listen point')}</td>
                    <td class="left">{lang('Vote point')}</td>
                    <td class="left">{lang('Sms vote point')}</td>
                </tr>
            </thead>

            <tbody>
                {foreach $reports as $report}
                    <tr>                
                        <td class="left"><input type="text" name="order[{$report.id}]" value="{$report.weight}" style="width:30px;" /></td>
                        <td class="left">{$report.music}</td>
                        <td class="left">{$report.total_count}</td>
                        <td class="left">{$report.listen_count}</td>
                        <td class="left">{$report.vote_count}</td>
                        <td class="left">{$report.sms_count}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </form>
    {$pagination_link}
</div>
