{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Campaigns
 * 
 * @package PenguinFW
 * @subpackage campaigns
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin provinces')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditCampaigns').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditCampaigns">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('create_user')}</td>
                    <td class="left"><input type="text" name="create_user" value="{$data_edit->create_user}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('modify_user')}</td>
                    <td class="left"><input type="text" name="modify_user" value="{$data_edit->modify_user}" /></td>
                </tr>               
            
            </tbody>
        </table>
    </form>

</div>
