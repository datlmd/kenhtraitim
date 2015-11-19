{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Vn_areas
 * 
 * @package PenguinFW
 * @subpackage vn_areas
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin wards')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditVn_areas').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditVn_areas">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('district_id')}</td>
                    <td class="left">
                        <select name="district_id">
                            <option value="">{lang('All')}</option>
                            {foreach $district_ids as $district_id}
                                <option value="{$district_id.id}" {if $data_edit->district_id eq $district_id.id}selected{/if}>{lang($district_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('status_id')}</td>
                    <td class="left">
                        <select name="status_id">
                            <option value="">{lang('All')}</option>
                            {foreach $status_ids as $status_id}
                                <option value="{$status_id.id}" {if $data_edit->status_id eq $status_id.id}selected{/if}>{lang($status_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('order')}</td>
                    <td class="left"><input type="text" name="order" value="{$data_edit->order}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
