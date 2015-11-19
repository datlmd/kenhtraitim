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
    <h1>{lang('Add Admin game logs')}</h1>

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
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip')}</td>
                    <td class="left"><input type="text" name="ip" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_agent')}</td>
                    <td class="left"><input type="text" name="user_agent" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
