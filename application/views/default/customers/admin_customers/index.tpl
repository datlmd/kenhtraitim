{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Customers
 * @version 1.0.0
 */

*}

<script type="text/javascript">
    function submit_action(action)
{
    $("#FilterUser").attr("action", action);

    $("#FilterUser").submit();
}
</script>

<div class="heading">
    <h1>{lang('Admin customers manager')}</h1>

    <div class=buttons>
        <a onclick="submit_action('/customers/admin_customers/export/')" style="cursor: pointer;" class="button"><span>{lang('Export')}</span></a>
        <a href="{base_url('customers/admin_customers/add')}" class="button"><span>{lang('Add')}</span></a>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('customers/admin_customers/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
                {/foreach}
            </select>
        {/if}
    </div>
</div>

<div class="content">

    <form action="{current_url()}" method="get" id="FilterUser">
        <table class="filter">
            <tbody>
                <tr>
                    <td>
                        <label>{lang('Name')}</label>
                        <input type="text" style="width: 80px;" name="name" value="{$smarty.get.name}" />
                    </td>

                    <td>
                        <label>{lang('Gender')}</label>
                        <select style="width: 80px;" name="user_genders_id">
                            <option value="">{lang('All')}</option>
                            <option value="1" {if $smarty.get.user_genders_id eq 1}selected{/if}>{lang('Female')}</option>
                            <option value="2" {if $smarty.get.user_genders_id eq 2}selected{/if}>{lang('Male')}</option>
                            <option value="3" {if $smarty.get.user_genders_id eq 3}selected{/if}>{lang('Other')}</option>
                        </select>
                    </td>

                    <td>
                        <label>{lang('Age')}</label>
                        <select style="width: 90px;"  name="user_age_id">
                            <option value="">{lang('All')}</option>
                            <option value="1" {if $smarty.get.user_age_id eq 1}selected{/if}>{lang('Under 14')}</option>
                            <option value="2" {if $smarty.get.user_age_id eq 2}selected{/if}>{lang('14 to 16')}</option>
                            <option value="3" {if $smarty.get.user_age_id eq 3}selected{/if}>{lang('16 to 18')}</option>
                            <option value="4" {if $smarty.get.user_age_id eq 4}selected{/if}>{lang('18 to 24')}</option>
                            <option value="5" {if $smarty.get.user_age_id eq 5}selected{/if}>{lang('Over 24')}</option>
                        </select>
                    </td>

                    <td>
                        <label>{lang('Region')}</label>
                        <select  style="width: 100px;" name="user_regions_id">
                            <option value="">{lang('All')}</option>
                            {foreach $regions as $region}
                                <option value="{$region.id}" {if $smarty.get.user_regions_id eq $region.id}selected{/if}>{$region.name}</option>
                            {/foreach}

                        </select>
                    </td>

                    <td>
                        <label>{lang('Group')}</label>
                        <select  style="width: 100px;" name="user_group_id">
                            <option value="">{lang('All')}</option>
                            {foreach $groups as $group}
                                <option value="{$group.id}" {if $smarty.get.user_group_id eq $group.id}selected{/if}>{$group.name}</option>
                            {/foreach}
                            <option value="-1" {if $smarty.get.user_group_id eq -1}selected{/if}>{lang('None')}</option>
                        </select>
                    </td>


                    <td>
                        <label>{lang('From date')}</label>
                        <input type="text" name="from_date" style="width: 80px;" class="pgDate" value="{$smarty.get.from_date}" />
                    </td>

                    <td>
                        <label>{lang('To date')}</label>
                        <input type="text" name="to_date" style="width: 80px;" class="pgDate" value="{$smarty.get.to_date}" />
                    </td>


                    <td><a onclick="submit_action('/customers/admin_customers/')" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>

    <form action="{base_url('customers/admin_customers/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/customer_list_view.tpl"}
    </form>

</div>
