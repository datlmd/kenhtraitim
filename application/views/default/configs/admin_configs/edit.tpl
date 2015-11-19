{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Configs
 * 
 * @package PenguinFW
 * @subpackage configs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin configs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditConfigs').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditConfigs">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('value')}</td>
                    <td class="left"><input type="text" name="value" value="{$data_edit->value}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
