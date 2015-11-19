
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Settings
 * 
 * @package PenguinFW
 * @subpackage settings
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add settings')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddSettings').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
   
    <form action="" method="post" id="FormAddSettings">
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left">{get_label('key')}</td>
                    <td class="left"><input type="text" name="key" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('value')}</td>
                    <td class="left"><textarea name="value"></textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea name="description"></textarea></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>
