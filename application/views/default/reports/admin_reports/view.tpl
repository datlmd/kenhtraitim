{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Reports
 * 
 * @package PenguinFW
 * @subpackage reports
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View reports')}</h1>

    <div class=buttons>
        <a href="{base_url('reports/admin_reports/export')}/{$report_id}" class="button"><span>{lang('Export')}</span></a>        
    </div>
</div>

<div class="content">
        
    <table class="list">
        <thead>
            <tr>                    
                {foreach from=$result[0] key=field item=v}
                    <td class="left">{$field}</td>
                {/foreach}                    
            </tr>
        </thead>

        <tbody>
            {foreach $result as $value}
                <tr>
                    {foreach from=$result[0] key=field item=v}
                        <td class="left">{$value.$field}</td>
                    {/foreach}
                </tr>
            {foreachelse}
                <tr>
                    <td class="left" colspan="10">{lang('No record')}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>

</div>