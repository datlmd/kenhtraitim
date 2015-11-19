{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Campaigns
 * 
 * @package PenguinFW
 * @subpackage campaigns
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin provinces')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddCampaigns').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddCampaigns">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('create_user')}</td>
                    <td class="left"><input type="text" name="create_user" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('modify_user')}</td>
                    <td class="left"><input type="text" name="modify_user" value="" /></td>
                </tr>
                
            
            </tbody>
        </table>
    </form>

</div>
