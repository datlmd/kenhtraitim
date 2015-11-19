
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Reports
 * 
 * @package PenguinFW
 * @subpackage reports
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add reports')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddReports').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddReports">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>                

                <tr>
                    <td class="left">{get_label('share')}</td>
                    <td class="left">
                        <select name="share">
                            {foreach $share_types as $value => $share_type}
                                <option value="{$value}">{$share_type}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
