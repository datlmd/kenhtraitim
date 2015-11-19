{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Users
 * 
 * @package PenguinFW
 * @subpackage users
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin user logs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditUsers').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditUsers">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('user_name')}</td>
                    <td class="left"><input type="text" name="user_name" value="{$data_edit->user_name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_agent')}</td>
                    <td class="left"><input type="text" name="user_agent" value="{$data_edit->user_agent}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_ip')}</td>
                    <td class="left"><input type="text" name="user_ip" value="{$data_edit->user_ip}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_url')}</td>
                    <td class="left"><input type="text" name="user_url" value="{$data_edit->user_url}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
