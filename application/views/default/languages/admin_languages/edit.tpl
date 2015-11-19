
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Languages
 * 
 * @package PenguinFW
 * @subpackage languages
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit languages')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditLanguages').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormEditLanguages">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('is_active')}</td>
                    <td class="left"><input type="checkbox" name="is_active" value="1"{if $data_edit->is_active eq 1} selected{/if} /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
