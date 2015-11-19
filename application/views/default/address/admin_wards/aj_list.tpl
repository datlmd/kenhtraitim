{if $ward_ids}
    <option value="">{lang('All')}</option>
    {foreach $ward_ids as $ward_id}
        <option value="{$ward_id.id}" >{lang($ward_id.name)}</option>
    {/foreach}
{else}
    <option value="">{lang('All')}</option>
{/if}