{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Pages
 * 
 * @package PenguinFW
 * @subpackage pages
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin page view manages')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddPages').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddPages">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('controller')}</td>
                    <td class="left"><input type="text" name="controller" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('action')}</td>
                    <td class="left"><input type="text" name="action" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><input type="text" name="description" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('key')}</td>
                    <td class="left"><input type="text" name="key" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
