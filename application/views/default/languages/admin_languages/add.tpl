
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Languages
 * 
 * @package PenguinFW
 * @subpackage languages
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add languages')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddLanguages').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddLanguages">
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('code')}</td>
                    <td class="left"><input type="text" name="code" value="" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('is_active')}</td>
                    <td class="left"><input type="checkbox" name="is_active" value="1" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
