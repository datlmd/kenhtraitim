{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin View table list
 * 
 * @package PenguinFW
 * @subpackage Element
 * @version 1.0.0
 */

*}

<table class="list">
    {if $cp_fields eq false}
        <tbody>
            <tr><td class="left">{lang('No record')}</td></tr>
        </tbody>
    {else}
        <thead>
            <tr>
                    {foreach from=$cp_fields key=field item=field_type}
                    <td class="left">{get_label($field)}</td>
                {/foreach}

            </tr>
        </thead>

        <tbody>
            {foreach $cp_list_views as $list_view}

                <tr>
                       {foreach from=$cp_fields key=field item=field_type}
                        {if $field=='image_name' OR $field=='avatar'}
                            <td class="left">
                                <img width="140" src="{img_url()}media/images/{$list_view.$field}" />
                            </td>
                        {elseif $field=='chart'}
                            <td class="left process_chart_td" >
                                <div id="process_chart_div_{$list_view.id}" class="process_chart_div">
                                <script type="text/javascript">
                                    google.setOnLoadCallback(draw_process_chart('process_chart_div_{$list_view.id}', '{$list_view.chart}'));
                                </script>
                                </div>
                            </td> 

                        {else}
                            <td class="left">
                                {$value = pg_field_value($list_view.$field, $field_type)}
                                {$value}
                            </td>
                        {/if}
                    {/foreach}

                </tr>
            {foreachelse}
                <tr>
                    <td class="left" colspan="10">{lang('No record')}</td>
                </tr>
            {/foreach}            
        </tbody>
    {/if}
</table>