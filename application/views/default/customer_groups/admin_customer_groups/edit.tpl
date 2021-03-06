{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Customer_groups
 * 
 * @package PenguinFW
 * @subpackage customer_groups
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin customer groups')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditCustomer_groups').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditCustomer_groups">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('slogan')}</td>
                    <td class="left"><input type="text" name="slogan" value="{$data_edit->slogan}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('votes')}</td>
                    <td class="left"><input type="text" name="votes" value="{$data_edit->votes}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('introduce')}</td>
                    <td class="left"><input type="text" name="introduce" value="{$data_edit->introduce}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
