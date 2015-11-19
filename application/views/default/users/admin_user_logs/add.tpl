{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Users
 * 
 * @package PenguinFW
 * @subpackage users
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin user logs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddUsers').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddUsers">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('user_name')}</td>
                    <td class="left"><input type="text" name="user_name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_agent')}</td>
                    <td class="left"><input type="text" name="user_agent" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_ip')}</td>
                    <td class="left"><input type="text" name="user_ip" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_url')}</td>
                    <td class="left"><input type="text" name="user_url" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
