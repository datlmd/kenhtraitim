{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Customers
 * 
 * @package PenguinFW
 * @subpackage customers
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin customers')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditCustomers').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditCustomers">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('gender')}</td>
                    <td class="left"><input type="text" name="gender" value="{$data_edit->gender}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('email')}</td>
                    <td class="left"><input type="text" name="email" value="{$data_edit->email}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('region')}</td>
                    <td class="left"><input type="text" name="region" value="{$data_edit->region}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('province')}</td>
                    <td class="left"><input type="text" name="province" value="{$data_edit->province}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('phone')}</td>
                    <td class="left"><input type="text" name="phone" value="{$data_edit->phone}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('dob')}</td>
                    <td class="left"><input type="text" name="dob" value="{$data_edit->dob}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip_address')}</td>
                    <td class="left"><input type="text" name="ip_address" value="{$data_edit->ip_address}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
