{if $district_ids}
    <option value="">{lang('All')}</option>
    {foreach $district_ids as $district_id}
        <option value="{$district_id.id}" >{lang($district_id.name)}</option>
    {/foreach}
{else}
    <option value="">{lang('All')}</option>
{/if}