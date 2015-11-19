{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Customer_groups
 * 
 * @package PenguinFW
 * @subpackage customer_groups
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin customer groups')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddCustomer_groups').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddCustomer_groups">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('slogan')}</td>
                    <td class="left"><input type="text" name="slogan" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('votes')}</td>
                    <td class="left"><input type="text" name="votes" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('introduce')}</td>
                    <td class="left"><input type="text" name="introduce" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
