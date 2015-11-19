
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Languages
 * 
 * @package PenguinFW
 * @subpackage languages
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Translations')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddTranslations').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddTranslations">
        <input type="hidden" name="module_id" value="{$module_id}" />
        <input type="hidden" name="lang_id" value="{$lang_id}" />
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left">{get_label('key')}</td>
                    <td class="left"><textarea name="key"></textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('value')}</td>
                    <td class="left"><textarea name="value"></textarea></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>
