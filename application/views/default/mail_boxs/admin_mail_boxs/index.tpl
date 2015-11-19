{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Mails
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
    <h1>{lang('Mails manager')}</h1>

    <div class=buttons>
        <a href="javascript:void(0);" class="button JsDeleteItem"><span>{lang('Delete')}</span></a>
        <a href="{base_url()}custom_fields/admin_custom_field_names/index/{$this_resource}" class="button"><span>{lang('Custom field')}</span></a>
        {if $cf_names neq false}
            <select class="JsCustomFieldChange">
                {foreach $cf_names as $cfn}
                    <option value="{base_url('mail_boxs/admin_mail_boxs/index/')}/{$cfn.id}" {if $cfn_id eq $cfn.id}selected{/if}>{$cfn.name}</option>
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
                        <label>{lang('User Name')}</label>
                        <input type="text" style="width: 80px;" name="name" value="{$smarty.get.name}" />
                    </td>

                    <td>
                        <label>{lang('Email to')}</label>
                        <input type="text" style="width: 80px;" name="email_to" value="{$smarty.get.email_to}" />
                    </td>


                    <td>
                        <label>{lang('From date')}</label>
                        <input type="text" name="from_date" style="width: 80px;" class="pgDate" value="{$smarty.get.from_date}" />
                    </td>

                    <td>
                        <label>{lang('To date')}</label>
                        <input type="text" name="to_date" style="width: 80px;" class="pgDate" value="{$smarty.get.to_date}" />
                    </td>


                    <td><a onclick="submit_action('/mail_boxs/admin_mail_boxs/')" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>

    <form action="{base_url('mail_boxs/admin_mail_boxs/delete')}" class="JsDeleteForm" method="post">
        {include file="../../elements/list_view.tpl"}
    </form>
   

</div>
