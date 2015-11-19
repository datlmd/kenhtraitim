{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Customers
 * 
 * @package PenguinFW
 * @subpackage customers
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin customers')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddCustomers').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddCustomers">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('gender')}</td>
                    <td class="left"><input type="text" name="gender" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('email')}</td>
                    <td class="left"><input type="text" name="email" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('region')}</td>
                    <td class="left"><input type="text" name="region" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('province')}</td>
                    <td class="left"><input type="text" name="province" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('phone')}</td>
                    <td class="left"><input type="text" name="phone" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('dob')}</td>
                    <td class="left"><input type="text" name="dob" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip_address')}</td>
                    <td class="left"><input type="text" name="ip_address" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
