
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Settings
 * 
 * @package PenguinFW
 * @subpackage settings
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit settings')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditSettings').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    
    <form action="" method="post" id="FormEditSettings">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left">{get_label('key')}</td>
                    <td class="left"><input type="text" name="key" value="{$data_edit->key}" readonly="true" style="color:#c7c7c7;" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('value')}</td>
                    <td class="left"><textarea name="value">{$data_edit->value}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea name="description">{$data_edit->description}</textarea></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>
