{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Vn_areas
 * 
 * @package PenguinFW
 * @subpackage vn_areas
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin districts')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddVn_areas').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddVn_areas">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('province_id')}</td>
                    <td class="left">
                        <select name="province_id">
                            <option value="">{lang('All')}</option>
                            {foreach $province_ids as $province_id}
                                <option value="{$province_id.id}">{lang($province_id.name)}</option>
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
                                <option value="{$status_id.id}">{lang($status_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('order')}</td>
                    <td class="left"><input type="text" name="order" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
