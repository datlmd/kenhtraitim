<table class="list">
    {if $ga_fields eq false}

        <tr><td class="left">{lang('No record')}</td></tr>

    {else}
        <thead>
        <tr>
            {foreach from=$ga_fields key=field item=field_type}
                <td class="left">{get_label($field)}</td>
            {/foreach}

        </tr>
        </thead>


        {foreach $ga_list_views as $list_view}

            <tr>

                {foreach from=$ga_fields key=field item=field_type}
                    {if $field=='image_name' OR $field=='avatar'}
                        <td class="left">
                            <img width="140" src="{img_url()}media/images/{$list_view.$field}" />
                        </td>
                    {elseif $field=='chart'}
                        <td class="left process_chart_td" >
                            <span class="process_chart_div">
                                <img src="{str_replace(' ', '%20', $list_view.$field)}" />
                            </span>
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

    {/if}
</table>