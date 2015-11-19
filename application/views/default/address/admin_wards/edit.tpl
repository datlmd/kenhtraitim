{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Campaigns
 * 
 * @package PenguinFW
 * @subpackage campaigns
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin wards')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditCampaigns').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}


    <form action="" method="post" id="FormEditCampaigns">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>                         

                <tr>
                    <td class="left">{get_label('province_id')}</td>
                    <td class="left">
                        <select id="sel_province" name="province_id">
                            <option value="">{lang('All')}</option>
                            {foreach $province_ids as $province_id}
                                <option value="{$province_id.id}" {($active_province_id  eq $province_id.id) ? 'selected' : ''}>{lang($province_id.name)}</option> 
                            {/foreach}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('district_id')}</td>
                    <td class="left">
                        <select id="sel_district" name="district_id">
                            <option value="">{lang('All')}</option>
                            {foreach $district_ids as $district_id}
                                <option value="{$district_id.id}" {set_select('district_id', $district_id.id, ($data_edit->district_id eq $district_id.id) ? TRUE : FALSE)}>{lang($district_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{set_value('name',$data_edit->name)}" /></td>
                </tr>

            </tbody>
        </table>
    </form>

</div>
