{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Events
 * 
 * @package PenguinFW
 * @subpackage events
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin events')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditEvents').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}


    <form action="" method="post" id="FormEditEvents">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            

                <tr>
                    <td class="left"><span class="required">*</span> {get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}"/></td>
                </tr>

                <tr>
                    <td class="left">{get_label('status_id')}</td>
                    <td class="left">
                        <select name="status_id">
                            {foreach $status_ids as $status_id}
                                <option value="{$status_id.id}" {if $data_edit->status_id eq $status_id.id}selected{/if}>{lang($status_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left"><span class="required">*</span> {get_label('start date')}</td>
                    <td class="left">
                        <input style="width: 100px;" class="pgDate"  type="text" name="start_date" value="{$data_edit->start_date}" /> :  
                        <input style="width: 50px;" class="pgTime"  type="text" name="start_time" value="{$data_edit->start_time}" />
                    </td>
                </tr>

                <tr>
                    <td class="left"><span class="required">*</span> {get_label('end date')}</td>
                    <td class="left">
                        <input style="width: 100px;" class="pgDate"  type="text" name="end_date" value="{$data_edit->end_date}" /> :  
                        <input style="width: 50px;" class="pgTime"  type="text" name="end_time" value="{$data_edit->end_time}" />
                    </td>
                </tr>


            </tbody>
        </table>
    </form>

</div>
