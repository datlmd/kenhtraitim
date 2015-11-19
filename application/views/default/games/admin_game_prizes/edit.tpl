{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Games
 * 
 * @package PenguinFW
 * @subpackage games
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin game prizes')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditGames').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditGames">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('image')}</td>
                    <td class="left"><input type="text" name="image" value="{$data_edit->image}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('total')}</td>
                    <td class="left"><input type="text" name="total" value="{$data_edit->total}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('balance')}</td>
                    <td class="left"><input type="text" name="balance" value="{$data_edit->balance}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_using')}</td>
                    <td class="left"><input type="checkbox" name="is_using" value="{$data_edit->is_using}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
