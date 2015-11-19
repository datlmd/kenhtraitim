{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Games
 * 
 * @package PenguinFW
 * @subpackage games
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin game prizes')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddGames').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddGames">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('image')}</td>
                    <td class="left"><input type="text" name="image" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('total')}</td>
                    <td class="left"><input type="text" name="total" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('balance')}</td>
                    <td class="left"><input type="text" name="balance" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_using')}</td>
                    <td class="left"><input type="checkbox" name="is_using" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
