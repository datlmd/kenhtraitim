{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Pages
 * 
 * @package PenguinFW
 * @subpackage pages
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin page view manages')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditPages').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditPages">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('controller')}</td>
                    <td class="left"><input type="text" name="controller" value="{$data_edit->controller}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('action')}</td>
                    <td class="left"><input type="text" name="action" value="{$data_edit->action}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><input type="text" name="description" value="{$data_edit->description}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('key')}</td>
                    <td class="left"><input type="text" name="key" value="{$data_edit->key}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
