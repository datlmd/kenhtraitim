{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Reports
 * 
 * @package PenguinFW
 * @subpackage reports
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit reports')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditReports').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}    
    
    <form action="" method="post" id="FormEditReports">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>                

                <tr>
                    <td class="left">{get_label('share')}</td>
                    <td class="left">
                        <select name="share">
                            {foreach $share_types as $value => $share_type}
                                <option value="{$value}" {if $data_edit->share eq $value}selected{/if}>{$share_type}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
